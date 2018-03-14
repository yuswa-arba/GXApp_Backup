<template>
    <div class="modal fade stick-up" id="modal-attempt-generate-inside-summary" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <h5 class="text-left dark-title p-b-5">Generate Summary</h5>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Date Start - Date End </label>
                                    <div class="input-daterange input-group" id="summary-datepicker-range">
                                        <input type="text" class="input-sm form-control" name="start" id="generateFromDate"/>
                                        <div class="input-group-addon">to</div>
                                        <input type="text" class="input-sm form-control" name="end" id="generateToDate"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label> Select Branch Office</label>
                                    <select class="form-control" id="select-branch-office">
                                        <option value="" disabled selected hidden>Select</option>
                                        <option :value="branchOffice.id" v-for="branchOffice in branchOffices">{{branchOffice.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" @click="generateSummary()">
                                Generate
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal-dialog -->


</template>

<script>
    import {mapGetters, mapState} from 'vuex'

    export default{
        data(){
            return{

            }
        },
        mounted: function () {
            $('#summary-datepicker-range').datepicker({format: 'dd/mm/yyyy',autoclose:true})
        },
        computed:{
            ...mapState('timesheet',{
                branchOffices:'branchOffices'
            })
        },
        methods: {
            generateSummary(){
                let self = this
                let branchOfficeId = $('#select-branch-office').val()
                let fromDate = $('#generateFromDate').val()
                let toDate = $('#generateToDate').val()


                if(fromDate&&toDate&&branchOfficeId){
                    this.$store.dispatch({
                        type:'timesheet/startGenerateSummary',
                        branchOfficeId:branchOfficeId,
                        fromDate:fromDate,
                        toDate: toDate
                    })

                    this.$router.push({name:'summaryTimesheet'})

                }
            }
        }

    }
</script>