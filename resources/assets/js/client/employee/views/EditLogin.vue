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
                form:{},

                //form componetns
                accessStatuses:[]
            }
        },
        created(){
            get(api_path() + 'employee/edit/login/' + this.$route.params.id)
                .then((res) => {

                    //set current value
                    this.form = res.data.detail.data
                    this.form.id = this.$route.params.id

                    //form components
                    this.accessStatuses = this.form.formComponents.accessStatuses
                })
        },
        methods:{
            save(){
                delete this.form.formComponents // remove form components during submit
                this.$bus.$emit('save:login_detail',this.form)
            }
        }
    }
</script>