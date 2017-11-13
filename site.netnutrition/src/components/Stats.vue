<template>
    <div class = "container">
        <div class="dateRangeContainer">
            <label for="sel1">Date Range:</label>
            <select class = "statsSelect" id="sel1" v-model="dateRange">
                <option selected disabled>Select Date</option>
                <option>Today</option>
                <option>Yesterday</option>
                <option>Last Week</option>
                <option>Last Month</option>
            </select>
        </div>
        <canvas v-show="displayChart" id="myChart" width="720" height="400"></canvas>
        <app-single-day-stats v-show="displaySingleDayStats" :foodData = "foodLogTodayOrYesterday" ></app-single-day-stats>
    </div>
</template>

<script>
import axios from 'axios'
import "chart.js";
    export default {
        data(){
            return{
                dateRange: "Select Date",
                foodLogTodayOrYesterday:{},
                foodLogLastWeek:[],
                foodLogLastMonth:[],
                statsChart: {},
                chartData:{},
                weekday:[],
                displaySingleDayStats:false,
                displayChart:false,
                borderColor:[
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(25, 193, 42, 1)'
                ]
            }
        },
        mounted() {

            this.weekday[0] =  "Sunday";
            this.weekday[1] = "Monday";
            this.weekday[2] = "Tuesday";
            this.weekday[3] = "Wednesday";
            this.weekday[4] = "Thursday";
            this.weekday[5] = "Friday";
            this.weekday[6] = "Saturday";

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
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0
                    }
                }
            }
            });
        },
        watch:{
            dateRange(){
                
                switch(this.dateRange){

                    case "Yesterday":
                        var d = new Date();
                        d.setDate(d.getDate()-1);
                        this.getFoodLogSpecificDate(d);
                        
                        
                        break;
                    case "Today":
                        this.getFoodLogSpecificDate(new Date());
                        break;
                    case "Last Week":
                        
                        this.getFoodLogLastWeek();
                        
                        this.displaySingleDayStats = false;
                        this.displayChart = true;
                        break;


                    
                }
            }
        
        },
        methods:{
            getFoodLogSpecificDate(date){
                this.fetchFoodLog(date).then((response) => {
                    
                    this.foodLogTodayOrYesterday = this.formatFoodData(response);
                    this.displayChart = false;
                    this.displaySingleDayStats = true;
                });
            },
            getFoodLogLastWeek(){
                
                //Set up the chartData datasets to take in new info
                this.chartData.datasets = new Array(4);
                var labels = ["Total Calories", "Total Fat", "Total Protein", "Total Carbs"]
                for(let i = 0; i < 4; i++){
                    this.chartData.datasets[i] = {
                        data: new Array(7), 
                        label: labels[i], 
                        borderColor: this.borderColor[i],
                        fill: false}
                }

                this.chartData.labels = new Array(7);
                    
                //Get food for past seven days
                for(let i = 7; i > 0; i--){
                    var d = new Date();
                    d.setDate(d.getDate() - i);

                    this.chartData.labels[7 - i] = this.weekday[d.getDay()];
                    this.fetchFoodLog(d).then((response) => {
                    
                        var foodData = this.formatFoodData(response)
                        this.foodLogLastWeek.push(foodData);
                    
                        var foodIds = Object.keys(foodData);

                        var totalCalories = 0;
                        var totalProtein = 0;
                        var totalFat = 0;
                        var totalCarbs = 0;
                
                        foodIds.forEach(elem =>{
                            let servings = foodData[elem].servings;
                            totalCalories += parseInt(foodData[elem].food.Calories) * servings || 0;
                            totalCarbs += parseInt(foodData[elem].food["Total Carbohydrate"]) * servings || 0;
                            totalProtein += parseInt(foodData[elem].food.Protein) * servings|| 0;
                            totalFat += parseInt(foodData[elem].food["Total Fat"]) * servings|| 0;
                        });

                        
                        this.chartData.datasets[0].data[7 - i] = totalCalories;
                        this.chartData.datasets[1].data[7 - i] = totalFat;
                        this.chartData.datasets[2].data[7 - i] = totalProtein;
                        this.chartData.datasets[3].data[7 - i] = totalCarbs;

                        this.statsChart.config.data = this.chartData;
                        this.statsChart.update();
                    });
                }

                
                
                
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

