<template>
    <div>
        <app-dining-center-select></app-dining-center-select>
        <app-food-select-list></app-food-select-list>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                diningCenterName: ''

            }
        },
        watch: {
         '$route' (to, from) {
                this.diningCenterName = this.$route.params.location 
                this.$store.dispatch('fetchDiningCenterMenu', this.diningCenterName)
            }
        },

        mounted() { 
            this.diningCenterName = this.$route.params.location
            this.$store.dispatch('fetchDiningCenterMenu', this.diningCenterName)
        }
    }
</script>
