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
                    <div class="card-title">Login Details</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 employee-details">
                            <label>Username / E-mail</label>
                            <h5>{{detail.email}}</h5>
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Access Status</label>
                            <h5>{{detail.accessStatus}}</h5>
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Allow Super Admin</label>
                            <h5>{{detail.allowSuperAdminAccess}}</h5>
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Allow Admin</label>
                            <h5>{{detail.allowAdminAccess}}</h5>
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
            get(api_path() + 'employee/detail/login/' + this.$route.params.id)
                .then((res) => {
                    this.detail = res.data.detail.data
                })
        }
    }
</script>