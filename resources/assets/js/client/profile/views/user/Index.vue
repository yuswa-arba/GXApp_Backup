<template>
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Personal Information</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-4">
                            <div style="" class="cursor"
                                 @click="viewImage('/images/employee/'+userDetail.employeePhoto)">
                                <img :src="`/images/employee/${userDetail.employeePhoto}`"
                                     alt="No Image" class="img-responsive" style="width:100%; height:auto;">
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-4 employee-details">

                            <label>Surname/Given name</label>
                            <h5>{{userDetail.surname}}/{{userDetail.givenName}}</h5>

                            <label>Employee No</label>
                            <h5>{{userDetail.employeeNo}}</h5>

                        </div>
                        <div class="col-lg-4 employee-details">
                            <label>Email</label>
                            <h5>{{userDetail.email}}</h5>

                            <label>Phone Number</label>
                            <h5>{{userDetail.phoneNo}}</h5>

                            <label>Bank </label>
                            <h5>{{userDetail.bankAccNo}} ({{userDetail.bankName}})</h5>

                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6">
            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Employment Information</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-4 employee-details">

                            <label>Division</label>
                            <h5>{{userDetail.divisionName}}</h5>

                        </div>
                        <div class="col-lg-4 employee-details">
                            <label>Job Position</label>
                            <h5>{{userDetail.jobPositionName}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Branch Office</label>
                            <h5>{{userDetail.branchOfficeName}}</h5>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Change Password</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-4 employee-details">

                            <label>Old Password</label>
                            <input type="password" class="form-control" v-model="formChangePwd.oldPwd">

                        </div>
                        <div class="col-lg-4 employee-details">
                            <label>New Password</label>
                            <input type="password" class="form-control" v-model="formChangePwd.newPwd">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Confirm New Password</label>
                            <input type="password" class="form-control" v-model="formChangePwd.confirmNewPwd">
                        </div>

                        <div class="col-lg-12 employee-details">
                            <button class="btn btn-primary m-t-20 pull-right" @click="changePassword()">Save</button>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script type="text/javascript">
    import {get, post} from'../../../helpers/api'
    import {api_path} from'../../../helpers/const'
    export default{
        data(){
            return {
                userDetail: {},
                formChangePwd: {
                    oldPwd: '',
                    newPwd: '',
                    confirmNewPwd: '',
                }
            }
        },
        components: {},
        mounted(){

        },
        computed: {},
        created(){ //get user detail on create
            get(api_path + 'profile/user/detail')
                .then((res) => {
                    if (!res.data.isFailed) {

                        this.userDetail = res.data.employee.data

                    } else {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: res.data.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    }
                })
                .catch((err) => {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: err.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                })
        },
        methods: {
            viewImage(url){
                window.open(url, '_blank')
            },
            changePassword(){
                let form = this.formChangePwd

                if (form.oldPwd && form.newPwd && form.confirmNewPwd) {

                    if (form.newPwd == form.confirmNewPwd) { /* Make sure its equal */

                        post(api_path + 'profile/user/change/password', form)
                            .then((res) => {
                                if (!res.data.isFailed) { /* Success response */

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    //resset form
                                    this.formChangePwd = {
                                        oldPwd: '',
                                        newPwd: '',
                                        confirmNewPwd: '',
                                    }


                                } else { /* Error response */
                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'danger'
                                    }).show();
                                }
                            })
                            .catch((err) => { /* Error response */
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: err.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'danger'
                                }).show();
                            })

                    } else { /* Error Notification */
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: 'Confirm password doesn\'t match',
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    }

                } else { /* Error Notification */
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Form cannot be empty',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            }
        }
    }
</script>