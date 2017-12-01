<template>
    <div class = "container">
        <datepicker v-model="dateStart"></datepicker>
        <br>
        <datepicker v-model="dateEnd"></datepicker>
        <button @click="getFoodBetweenDates" class='btn btn-default'>View</button>
        <canvas v-show="displayChart" id="myChart" width="720" height="400"></canvas>
    </div>
</template>

<script>
import axios from 'axios'
import "chart.js";
    export default {
        data(){
            return{
                dateRange: "Select Date",
                statsChart: {},
                chartData:{},
                displayChart:false,
                borderColor:[
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(25, 193, 42, 1)'
                ],
                dateStart:new Date(),
                dateEnd: new Date()
            }
        },
        mounted() {

            var ctx = document.getElementById("myChart").getContext('2d');

            this.$store.dispatch('fetchFoodLog', new Date());
            
            this.chartData = {
                labels: [],
                datasets: [{
                    label: '',
                    data: [],
                    borderColor: [],
                    borderWidth: 1
                }]
            }


            this.statsChart = new Chart(ctx, {
            type: 'line',
            data: this.chartData,
            options: {
                responsive: false,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [
                        {
                        id: "stacked",
                        stacked: true,
                            ticks: {
                                beginAtZero:true
                            }
                        },
                        {
                        display: false,
                        id: "unstacked",
                        stacked: false,
                            ticks: {
                                beginAtZero: true
                            }
                        }
                    ]
                },
                elements: {
                    line: {
                        tension: 0
                    }
                }
            }
            });
        },
        methods:{
            //gets food data for dates between start and end date inclusively of both
            getFoodBetweenDates(){
                
                //get the differece in days between two dates
                var timeDiff = this.dateEnd.getTime() - this.dateStart.getTime();
                var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24)); 
                

                This.setupChart(diffDays);
                
                var d = this.dateStart;
                
                //Get food for the days inbetween dates
                for(let i = 0; i < diffDays; i++){

                    
                    d.setDate(d.getDate() + 1);

                    this.chartData.labels[i] = d.toISOString().substring(0, 10);
                    this.fetchFoodLog(d).then((response) => {
                    
                        var foodData = this.formatFoodData(response);
                    
                        var foodIds = Object.keys(foodData);

                        var totalCalories = 0;
                        var protein = 0;
                        var fat = 0;
                        var carbs = 0;
                
                        foodIds.forEach(elem =>{
                            let servings = foodData[elem].servings;
                            totalCalories += parseInt(foodData[elem].food.Calories) * servings|| 0;
                            carbs += parseInt(foodData[elem].food["Total Carbohydrate"]) * servings * 4 || 0;
                            protein += parseInt(foodData[elem].food.Protein) * servings * 4|| 0;
                            fat += parseInt(foodData[elem].food["Total Fat"]) * servings * 9|| 0;
                        });

                        
                        this.chartData.datasets[0].data[i] = totalCalories;
                        this.chartData.datasets[1].data[i] = fat;
                        this.chartData.datasets[2].data[i] = protein;
                        this.chartData.datasets[3].data[i] = carbs;

                        this.statsChart.config.data = this.chartData;
                        this.statsChart.update();
                    });
                }
                this.displayChart = true;
                
                
            },
            setupChart(diffDays){

                //Set up the chartData datasets to take in new info
                this.chartData.datasets = new Array(4);
                var labels = ["Total Calories", "Calories From Fat", "Calories From Protein", "Calories From Carbs"];

                this.chartData.datasets[0] = {
                        yAxisID: "unstacked",
                        data: new Array(diffDays), 
                        label: labels[0], 
                        borderColor: this.borderColor[0],
                        backgroundColor: this.borderColor[0],
                        fill: false
                }

                for(let i = 1; i < 4; i++){
                    this.chartData.datasets[i] = {
                        yAxisID: "stacked",
                        data: new Array(diffDays), 
                        label: labels[i], 
                        borderColor: this.borderColor[i],
                        backgroundColor: this.borderColor[i],
                        fill: true
                    }
                }

                this.chartData.labels = new Array(diffDays);
            },
            fetchFoodLog(date){
            
                let tzoffset = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
                let dateString = (new Date(date - tzoffset)).toISOString().split('T')[0]

                let params = {
                    params: {
                        token:this.$store.state.APIToken,
                        date: dateString
                    }
                }

                return axios.get(process.env.API_DOMAIN + '/food-log', params);
                        
            },
            formatFoodData(response){
                    
                let foodData = {}
                let data = response.data[0]

                for (let i = 0; i < data.foods.length; i++){
                    let food = data.foods[i]
                

                    if (food.id in foodData){
                        foodData[food.id].servings += parseInt(food.pivot.servings)
                    }
                    else {
                        //convert food nutrition to dictionary
                        let foodDict = {}
                        foodDict['id'] = food.id
                        foodDict['name'] = food.name

                        for (let item of food.nutritions){
                            foodDict[item.name] = item.value
                        }

                        foodData[food.id] = {
                            food: foodDict,
                            servings: parseInt(food.pivot.servings),
                            menu: data.menus[i]
                        }
                    }
                }
                return foodData;
                
            }
        }
    }
</script>
<style>
    .dateRangeContainer{
        display: inline;
    }

    .statsSelect{
        width: 150px;
        text-align: center;
    }
</style>

