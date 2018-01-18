<template>
    <div class="row row-same-height">

        <div class="col-lg-12 m-b-10 m-t-10">

            <slot name="go-back-menu"></slot>
            <slot name="edit-menu"></slot>

        </div>
        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12 employee-details">
                            <label>Employee ID</label>
                            <p class="text-primary">{{$route.params.id}}</p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Employee No</label>
                            <p class="text-primary">{{employeeDetail.employeeNo}}</p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Employee Information</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-4">
                            <div style="" class="cursor">
                                <img :src="`/images/employee/${employeeDetail.employeePhoto}`"
                                     alt="No Image" class="img-responsive" style="width:100%; height:auto;">
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-4 employee-details">

                            <label>Surname/Given name</label>
                            <h5>{{employeeDetail.surname}}/{{employeeDetail.givenName}}</h5>

                            <label>Email</label>
                            <h5>{{employeeDetail.email}}</h5>

                            <label>Bank Account</label>
                            <h5>{{employeeDetail.bankAccNo}} ({{employeeDetail.bankName}})</h5>



                        </div>
                        <div class="col-lg-4 employee-details">
                            <label>Division</label>
                            <h5>{{employeeDetail.divisionName}}</h5>

                            <label>Job Position</label>
                            <h5>{{employeeDetail.jobPositionName}}</h5>

                            <label>Branch Office</label>
                            <h5>{{employeeDetail.branchOfficeName}}</h5>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6">
            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Salary Information</div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12 employee-details">
                            <label>Basic Salary</label>
                            <p class="text-primary" v-if="salaryDetail.basicSalary">{{salaryDetail.basicSalary}}</p>
                            <span v-else="">-</span>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Inserted Date</label>
                            <p class="text-primary" v-if="salaryDetail.insertedDate">{{salaryDetail.insertedDate}}</p>
                            <span v-else="">-</span>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Inserted By</label>
                            <p class="text-primary" v-if="salaryDetail.insertedBy">{{salaryDetail.insertedBy}}</p>
                            <span v-else="">-</span>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Bonus Cut</div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12 employee-details">
                            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                                <div class="card-block no-padding">
                                    <div class="scrollable">
                                        <div class=" h-500">
                                            <div class="table-responsive">
                                                <table class="table table-hover employeeBonusCutDT">
                                                    <thead class="bg-master-lighter">
                                                    <tr>
                                                        <th class="text-black padding-10">ID</th>
                                                        <th class="text-black padding-10">Bonus Cut Type</th>
                                                        <th class="text-black padding-10">Value</th>
                                                        <th class="text-black padding-10">With Formula</th>
                                                        <th class="text-black padding-10">Active</th>
                                                        <th class="text-black padding-10">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(bonusCutDetail,index) in bonusCutDetails">
                                                        <td>{{bonusCutDetail.id}}</td>
                                                        <td>
                                                            {{bonusCutDetail.bonusCutTypeName}} ({{bonusCutDetail.bonusCutTypeAddOrSub}})
                                                        </td>

                                                        <td>
                                                            <span class="fs-14" v-if="bonusCutDetail.value">{{bonusCutDetail.value}}</span>
                                                            <span v-else="">-</span>
                                                        </td>

                                                        <td>
                                                            <span v-if="bonusCutDetail.isUsingFormula && bonusCutDetail.formula">  {{bonusCutDetail.formula}}</span>
                                                            <span v-else="">-</span>

                                                        </td>
                                                        <td>
                                                            <i class="fa fa-check text-primary fs-16" v-if="bonusCutDetail.isActive"></i>
                                                            <i class="fa fa-times text-danger fs-16" v-else=""></i>
                                                        </td>
                                                        <td>
                                                            <i class="fa fa-pencil fs-16 cursor"></i>
                                                        </td>

                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="help pull-right m-t-10" style="opacity: 0.7">Scroll for more</label>
                                </div>
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
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                employeeDetail: [],
                salaryDetail:[],
                bonusCutDetails:[]
            }
        },
        created(){
            let self =this
            get(api_path + 'salary/employee/detail/' + self.$route.params.id)
                .then((res) => {
                    self.employeeDetail = res.data.employee.data
                    self.salaryDetail = res.data.salary.data
                    self.bonusCutDetails = res.data.bonusCut.data

                    console.log(JSON.stringify(res.data))
                })
        }
    }
</script>