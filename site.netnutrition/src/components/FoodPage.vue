<template>
    <div>
        <app-dining-center-select></app-dining-center-select>
        <app-add-food></app-add-food>
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
