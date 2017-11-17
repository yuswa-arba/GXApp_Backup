<template>
    <div class="row row-same-height">

        <div class="col-lg-12 m-b-10 m-t-10">

            <slot name="go-back-and-view-menu"></slot>

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
                            <p class="text-primary">{{detail.employeeId}}</p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Employee No</label>
                            <p class="text-primary">{{detail.employeeNo}}</p>
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Name</label>
                            <p class="text-primary">{{detail.employeeName}}</p>
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
                        <div class="col-lg-3 employee-details">
                            <label>Job Position</label>
                            <h5>{{detail.jobPosition}}</h5>
                        </div>

                        <div class="col-lg-3 employee-details">
                            <label>Division</label>
                            <h5>{{detail.division}}</h5>
                        </div>

                        <div class="col-lg-3 employee-details">
                            <label>Branch Office</label>
                            <h5>{{detail.branchOffice}}</h5>
                        </div>

                        <div class="col-lg-3 employee-details">
                            <label>Recruitment Status</label>
                            <h5>{{detail.recruitmentStatus}}</h5>
                        </div>

                        <div class="col-lg-3 employee-details">
                            <label>Date of Entry</label>
                            <h5>{{detail.dateOfEntry}}</h5>
                        </div>

                        <div class="col-lg-3 employee-details">
                            <label>Date of Start</label>
                            <h5>{{detail.dateOfStart}}</h5>
                        </div>

                        <div class="col-lg-3 employee-details">
                            <label>Date of Resignation</label>
                            <h5>{{detail.dateOfResignation}}</h5>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../../helpers/api'
    import {api_path} from '../../helpers/const'
    export default{
        data(){
            return {
                detail: []
            }
        },
        created(){
            get(api_path() + 'employee/detail/employment/' + this.$route.params.id)
                .then((res) => {
                console.log(res)
                this.detail = res.data.detail.data
            })
        }
    }
</script>