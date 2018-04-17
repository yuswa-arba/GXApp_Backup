<template>
    <div class="row">

        <div class="col-lg-12 m-b-10 m-t-10">

            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-500">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover settingDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black">Division</th>
                                        <th class="text-black">Branch</th>
                                        <th class="text-black">Start Date - End Date</th>
                                        <th class="text-black">Due Date</th>
                                        <th class="text-black">Generated</th>
                                        <th class="text-black">Last Update</th>
                                        <th class="text-black" style="width:250px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="timesheet in timesheets" class="filter-item">
                                        <td>{{timesheet.divisionName}}</td>
                                        <td>{{timesheet.branchOfficeName}}</td>
                                        <td>{{timesheet.startDate}} - {{timesheet.endDate}}</td>
                                        <td>{{timesheet.dueDate}}</td>
                                        <td>@ {{timesheet.generatedAt}} by {{timesheet.generatedBy}}</td>
                                        <td>
                                            <span v-if="timesheet.lastUpdatedAt!=''&&timesheet.lastUpdatedAt!=null">@ {{timesheet.lastUpdatedAt}} by {{timesheet.lastUpdatedBy}}</span>
                                            <span v-else="">-</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary" @click="goToSummary(timesheet.id)">Summary
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                </div>
            </div>


        </div>


    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../../../helpers/api'
    import {objectToFormData} from '../../../helpers/utils'
    import {mapState} from 'vuex'
    export default{
        data(){
            return {}
        },

        computed: {
            ...mapState('editTimesheet', {
                timesheets: 'timesheets'
            })
        },
        created(){
            let self = this
            this.$store.dispatch('editTimesheet/getDataOnCreate')
        },
        mounted(){

        },
        methods: {
            goToSummary(timesheetId){
                this.$router.push({name: 'timesheetSummary', params: {editTimesheetId: timesheetId}})
            }
        },
    }
</script>