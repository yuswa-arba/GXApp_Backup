<template>
    <div class="row">

        <div class="col-lg-12 m-b-10 p-t-200" v-if="isGeneratingSalary">
            <!--Fetching data progress-->
            <div class="center-margin">
                <p class="text-center fs-21">Generating Salary Reports.. Please Wait....</p>
                <div class="progress h-8">
                    <div class="progress-bar-indeterminate progress-bar-success"></div>
                </div>
                <br>
            </div>

        </div>

        <div class="col-lg-12 m-b-10 p-t-200" v-else="">

            <!--Fetching data progress-->
            <div class="center-margin text-center">
                <h3 class="bold text-primary" v-if="isGenerateSalarySuccessful">Generating Salary is Successful</h3>
                <h3 class="bold text-danger" v-else="">Generating Salary is Unsuccessful</h3>
            </div>
            <div class="text-center">
                <button class="btn btn-outline-primary" @click="finish()">Finish</button>
            </div>



        </div>

    </div>

</template>
<script type="text/javascript">
    import {mapGetters, mapState} from 'vuex'
    export default{
        components: {},
        computed: {
            ...mapState('report', {
                isGeneratingSalary: 'isGeneratingSalary',
                isGenerateSalarySuccessful:'isGenerateSalarySuccessful'
            })
        },
        created(){

        },
        mounted: function () {

        },
        methods:{
            finish(){
                this.$router.push('/')
            }
        }

    }
</script>