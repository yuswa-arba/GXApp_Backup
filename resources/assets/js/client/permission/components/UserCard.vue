<template>
    <div class="row">
        <div class="col-lg-4  filter-item" v-for="(user,index) in users">
            <div class="card card-default ">
                <div class="card-header ">
                    <div class="card-title">
                        #{{index}} {{user.name}} <span :id="'newRole'+user.employeeId"
                                                         class="text-alert hide">*</span>
                        &nbsp;
                    </div>
                    <div class="card-controls">
                        <ul>

                        </ul>
                    </div>
                </div>
                <div class="card-block">

                    <p class="hint-text fade small pull-left">
                        Total : {{user.roles.length}}
                        / {{user.totalRoles}} Roles</p>
                    <div class="clearfix"></div>
                    <div class="progress progress-small m-b-15 m-t-10">
                        <!-- START BOOTSTRAP PROGRESS (http://getbootstrap.com/components/#progress) -->
                        <div class="progress-bar progress-bar-primary"
                             :style="{width:percent(user.roles.length,user.totalRoles)+'%'}">
                        </div>
                        <!-- END BOOTSTRAP PROGRESS -->
                    </div>
                    <div class="scrollable">
                        <div class="scroll-h-70">
                            <p class="all-caps font-montserrat text-success fs-8 bold no-margin">
                                <span v-for="roles in user.roles">
                                    <i class="fa fa-circle smaller"></i> {{roles.name}}
                                <br>
                                </span>

                            </p>
                        </div>
                    </div>
                    <button class="btn btn-block btn-vd-role" :value="user.name" @click="showModal(user)">
                        View
                        Details
                    </button>
                </div>
            </div>
        </div>
        <!-- MODAL VIEW DETAIL ROLE -->
        <div class="modal fade stick-up" id="modal-user-detail" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog modal-lg role-permission-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="pg-close"></i>
                        </button>
                        <!--<div id="mh-role"></div>-->
                        <h5 class="text-left dark-title p-b-5">#{{upperCase(userName)}}</h5>
                    </div>
                    <div class="modal-body">
                        <!--<div id="mb-role-detail"></div>-->
                        <div class="row">
                            <div class="col-lg-12"></div>
                            <div class="col-lg-3 col-md-3 col-sm-3 sm-m-t-10" v-for="role in roles">
                                <div class="checkbox check-danger checkbox-circle">
                                    <input type="checkbox"
                                           v-model="assignedRoles"
                                           :value="role"
                                           :id="'cbroles'+role.id"
                                           @change="assign(user.employeeId,role)"
                                    >
                                    <label :for="'cbroles'+role.id">{{role.name}}</label>
                                </div>
                            </div>
                            <div class="col-lg-12 m-b-15"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--<div id="mf-role"></div>-->
                        <button class="p-t-5 p-b-5 btn text-primary bold all-caps btn-block" @click="closeModal()">
                            Close
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- END MODAL ROLE-->
    </div>

</template>

<script>
    import {get, post} from '../../helpers/api'
    import {api_path} from '../../helpers/const'

    export default {
        data(){
            return {
                role: '',
                userName: '',
                users: [],
                roles: [],
                assignedRoles: [],

            }
        },
        created(){

            let self = this;
            get(api_path + 'setting/user/list')
                .then((res) => {
                    self.users = res.data.data;
                })
        },
        methods: {
            percent(permission, totalPermission){
                return (permission / totalPermission) * 100
            },
            upperCase(text){
                return _.upperCase(text)
            },
            showModal(user){

                let self = this;

                this.user = user;

                get(api_path + 'setting/user/assigned/' + user.employeeId)
                    .then((res) => {
                        this.userName= res.data.data.name;
                        this.roles = res.data.data.allRoles.data;
                        this.assignedRoles = res.data.data.assignedRoles.data;
                        this.user.roles = this.assignedRoles; // update card list
                    });

                $('#modal-user-detail').modal('show')
            },
            closeModal(){
                this.role = '';
                $('#modal-user-detail').modal("toggle"); // close modal
            },
            assign(employeeId, role){
                let assignRoleIdArr = [];

                _.forEach(this.assignedRoles, function (value, key) {
                    assignRoleIdArr.push(value.id); // push permission ID to array
                });

                let data = {employeeId: employeeId, assignRoleIdArr: assignRoleIdArr};

                post(api_path + 'setting/user/assign/by_user', data)
                    .then((res) => {

                        this.user.roles = res.data.assigned.data;


                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: res.data.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'info'
                        }).show();

                    })
                    .catch((err) => {

                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
                            position: 'top-right',
                            timeout: 0,
                            type: 'danger'
                        }).show();
                    })


            }
        },
        mounted(){
//            console.log('Role Card Component mounted')
        }
    }
</script>