<template>
    <div>
       <h3> Dining Centers </h3>
    
      <div class="list-group">
            <button v-for="center in diningCenters" type="button" class="list-group-item">
                 <h4>{{ center.name }} </h4>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                diningCenters:['UDC', 'Windows', 'Convos']
            }
        },

        mounted() {
            axios.get('http://netnutrition.dev/api/dining-list')
                    .then( response => {
                        this.diningCenters = response.data
                    })
        }
    }
</script>
