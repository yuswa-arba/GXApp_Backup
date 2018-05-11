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
                    <div class="card-title">Login Details</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 employee-details">
                            <label>Username / E-mail</label>
                            <h5>{{form.email}}</h5>
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Access Status</label>
                            <select class="form-control" v-model="form.accessStatusId">
                                <option v-for="accessStatus in accessStatuses"
                                        :value="accessStatus.id">
                                    {{accessStatus.name}}
                                </option>
                            </select>                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Allow Super Admin</label>
                            <select class="form-control" v-model="form.allowSuperAdminAccess">
                                <option :value="1">True</option>
                                <option :value="0">False</option>
                            </select>
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Allow Admin</label>
                            <select class="form-control" v-model="form.allowAdminAccess">
                                <option :value="1">True</option>
                                <option :value="0">False</option>
                            </select>
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Change Password</label>
                            <input type="password" class="form-control" v-model="form.changePassword">
                        </div>


                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-6"></div>
        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Fingerspot Details</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 employee-details">
                            <label>Fingerspot User ID</label>
                            <h5>{{fingerspotDetail.fingerspotUserId}}</h5>
                        </div>
                        <div class="col-lg-6" v-if="fingerspotDetail.fingerspotUserId==null||fingerspotDetail.fingerspotUserId==''">
                            <button class="btn btn-info" @click="uploadFingerspotUser">Upload</button>
                        </div>
                        <div class="col-lg-6" v-else="">
                            <button class="btn btn-danger" @click="removeFingerspotUser()">Remove</button>
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
                form:{},
                fingerspotDetail:[],

                //form componetns
                accessStatuses:[]
            }
        },
        created(){
            get(api_path + 'employee/edit/login/' + this.$route.params.id)
                .then((res) => {

                    //set current value
                    this.form = res.data.detail.data
                    this.form.id = this.$route.params.id

                    //form components
                    this.accessStatuses = this.form.formComponents.accessStatuses
                })

            get(api_path + 'employee/detail/fingerspot/' + this.$route.params.id)
                .then((res) => {
                this.fingerspotDetail = res.data.detail.data

                })

        },
        methods:{
            save(){
                delete this.form.formComponents // remove form components during submit
                this.$bus.$emit('save:login_detail',this.form)
            },
            uploadFingerspotUser(){
                post(api_path + 'employee/fingerspot/upload/' + this.$route.params.id)
                    .then((res) => {
                    if(!res.data.isFailed){
                    this.fingerspotDetail = res.data.detail.data
                     $('.page-container').pgNotification({
                          style: 'flip',
                          message: res.data.message,
                          position: 'top-right',
                          timeout: 3500,
                          type: 'info'
                      }).show();
                    } else{
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: res.data.message,
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

                })
            },
            removeFingerspotUser(){
                post(api_path + 'employee/fingerspot/delete/' + this.$route.params.id)
                    .then((res) => {
                    if(!res.data.isFailed){
                    this.fingerspotDetail =[]
                     $('.page-container').pgNotification({
                          style: 'flip',
                          message: res.data.message,
                          position: 'top-right',
                          timeout: 3500,
                          type: 'info'
                      }).show();
                    } else{
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: res.data.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                }

                })
            }
        }
    }
</script>