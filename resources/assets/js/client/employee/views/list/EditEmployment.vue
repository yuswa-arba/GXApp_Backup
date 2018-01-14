<template>
    <div class="row row-same-height">

        <div class="col-lg-12 m-b-10 m-t-10">

            <slot name="cancel-menu"></slot>
            <button class="btn btn-primary m-r-15 m-b-10 pull-left"
                    @click="save()">
                Save
            </button>
        </div>


        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Employee Profile</div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12 employee-details">
                            <label>Employee ID</label>
                            <p class="text-primary">{{form.employeeId}}</p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Employee No</label>
                            <p class="text-primary">{{form.employeeNo}}</p>
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Name</label>
                            <p class="text-primary">{{form.employeeName}}</p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Employment Details</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12 employee-details">
                            <label>Job Position</label>
                            <select class="form-control" v-model="form.jobPositionId">
                                <option v-for="jobPosition in jobPositions" :value="jobPosition.id">
                                    {{jobPosition.name}}
                                </option>
                            </select>

                        </div>

                        <div class="col-lg-12 employee-details">

                            <label>Division</label>
                            <select class="form-control" v-model="form.divisionId">
                                <option v-for="division in divisions" :value="division.id">
                                    {{division.name}}
                                </option>
                            </select>

                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Branch Office</label>
                            <select class="form-control" v-model="form.branchOfficeId">
                                <option v-for="branchOffice in branchOffices" :value="branchOffice.id">
                                    {{branchOffice.name}}
                                </option>
                            </select>

                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Recruitment Status</label>
                            <select class="form-control" v-model="form.recruitmentStatusId">
                                <option v-for="recruitmentStatus in recruitmentStatuses"
                                        :value="recruitmentStatus.id">
                                    {{recruitmentStatus.name}}
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Date of Entry</label>
                            <input type="text" class="form-control" v-model="form.dateOfEntry" placeholder="dd/mm/yyyy">
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Date of Start</label>
                            <input type="text" class="form-control" v-model="form.dateOfStart" placeholder="dd/mm/yyyy">
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Date of Resignation</label>
                            <input type="text" class="form-control" v-model="form.dateOfResignation"
                                   placeholder="dd/mm/yyyy">
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                form: {},

                //form components
                jobPositions: [],
                divisions: [],
                branchOffices: [],
                recruitmentStatuses: []
            }
        },
        created(){
            get(api_path + 'employee/edit/employment/' + this.$route.params.id)
                .then((res) => {

                    //set current value
                    this.form = res.data.detail.data
                    this.form.employeeId = this.$route.params.id

                    //form components
                    this.jobPositions = this.form.formComponents.jobPositions
                    this.divisions = this.form.formComponents.divisions
                    this.branchOffices = this.form.formComponents.branchOffices
                    this.recruitmentStatuses = this.form.formComponents.recruitmentStatuses
                })
        },
        methods: {
            save(){
                delete this.form.formComponents // remove form components during submit
                this.$bus.$emit('save:employment_detail',this.form)
            }
        }
    }
</script>