<template>
    <div class="row">
        <div class="col-lg-4  filter-item" v-for="permission in permissions">
            <div class="card card-default ">
                <div class="card-header ">
                    <div class="card-title">
                        #{{permission.id}} {{permission.name}} <span :id="'newRole'+permission.id"
                                                                     class="text-alert hide">*</span>
                        &nbsp;
                    </div>
                    <div class="card-controls">
                        <ul>
                            <li><a data-toggle="collapse" class="card-collapse"
                                   href="#"><i
                                    class="card-icon card-icon-collapse"></i></a>
                            </li>
                            <li><a href="javascript:;"><i class="fa fa-trash"></i></a>
                            </li>

                            <li><a data-toggle="refresh" class="card-refresh"
                                   href="#"><i
                                    class="card-icon card-icon-refresh"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-block">
                    <ul class="nav nav-tabs nav-tabs-simple m-b-20" role="tablist"
                        data-init-reponsive-tabs="collapse">
                        <li class="nav-item"><a :href="'#role-tab'+permission.id"
                                                class="active" data-toggle="tab"
                                                role="tab"
                                                aria-expanded="true">Role</a>
                        </li>
                        <li class="nav-item"><a :href="'#user-tab'+permission.id"
                                                data-toggle="tab" role="tab"
                                                aria-expanded="false">User</a>
                        </li>
                    </ul>
                    <div class="tab-content no-padding">
                        <div class="tab-pane active" :id="'role-tab'+permission.id">
                            <p class="hint-text fade small pull-left">
                                Total : {{permission.roles.length}}
                                / {{permission.totalRole}} Roles </p>
                            <div class="clearfix"></div>
                            <div class="progress progress-small m-b-15 m-t-10">
                                <!-- START BOOTSTRAP PROGRESS (http://getbootstrap.com/components/#progress) -->
                                <div class="progress-bar progress-bar-primary"
                                     :style="{width:percent(permission.roles.length,permission.totalRole)+'%'}">
                                </div>
                                <!-- END BOOTSTRAP PROGRESS -->
                            </div>
                            <div class="scrollable">
                                <div class="scroll-h-70">
                                    <p class="all-caps font-montserrat text-success fs-8 bold no-margin">
                                       <span v-for="role in permission.roles">
                                            <i class="fa fa-circle smaller"></i> {{role.name}}
                                        <br>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" :id="'user-tab'+permission.id">
                            <p class="hint-text fade small pull-left">
                                Total : {{permission.users.length}}
                                / {{permission.totalUser}} Users </p>
                            <div class="clearfix"></div>
                            <div class="progress progress-small m-b-15 m-t-10">
                                <!-- START BOOTSTRAP PROGRESS (http://getbootstrap.com/components/#progress) -->
                                <div class="progress-bar progress-bar-warning"
                                     :style="{width:percent(permission.users.length,permission.totalUser)+'%'}">
                                </div>
                                <!-- END BOOTSTRAP PROGRESS -->
                            </div>
                            <div class="scrollable">
                                <div class="scroll-h-70">
                                    <p class="all-caps font-montserrat text-success fs-8 bold no-margin">
                                      <span v-for="user in permission.users">
                                            <i class="fa fa-circle smaller"></i> {{user.name}}
                                        <br>
                                      </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-block btn-vd-role"
                            :value="permission.name"
                            @click="showModal(permission)">
                        View Details
                    </button>
                </div>
            </div>
        </div>
        <div class="modal fade stick-up" id="modal-permission-detail" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog modal-lg role-permission-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="pg-close"></i>
                        </button>
                        <!--<div id="mh-permission"></div>-->
                        <h5 class="text-left dark-title p-b-5">#{{permissionId}} {{upperCase(permissionName)}}</h5>
                    </div>
                    <div class="modal-body">
                        <!--<div id="mb-permission-detail"></div>-->
                        <!--TODO: GIVEN TO USER DETAIL-->
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="text-left p-b-5"><span class="label label-success">Given to
                                    users:</span></h4>
                            </div>
                            <div class="col-lg-12"></div>
                            <div class="col-lg-3 sm-m-t-10" v-for="(user,index) in users">
                                <div class="checkbox check-primary checkbox-circle">
                                    <input type="checkbox"
                                           v-model="assignedUsers"
                                           :value="user"
                                           :id="'cbUser'+index"
                                           @change="assignUser(permissionName,user)"
                                    >
                                    <label :for="'cbUser'+index">{{user.name}}</label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <h4 class="text-left p-b-5"><span class="label label-important">Given to
                                    roles:</span></h4>
                            </div>
                            <div class="col-lg-12"></div>
                            <div class="col-lg-3 col-md-3 col-sm-3 sm-m-t-10" v-for="role in roles">
                                <div class="checkbox check-danger checkbox-circle">
                                    <input type="checkbox"
                                           v-model="assignedRoles"
                                           :value="role"
                                           :id="'cbrole'+role.id"
                                           @change="assignPermission(permissionName,role)"
                                    >
                                    <label :for="'cbrole'+role.id">{{role.name}}</label>
                                </div>
                            </div>
                            <div class="col-lg-12 m-b-15"></div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <!--<div id="mf-permission"></div>-->
                        <button class="p-t-5 p-b-5 btn text-primary bold all-caps btn-block" @click="closeModal()">
                            Close
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

</template>

<script>
    import {get, post} from '../../helpers/api'
    import {api_path} from '../../helpers/const'

    export default {
        data(){
            return {
                permission: '',
                permissionId: '',
                permissionName: '',
                permissions: [],
                roles: [],
                assignedRoles: [],
                users:[],
                assignedUsers: [],
            }
        },
        created(){
            let self = this;
            get(api_path + 'setting/permission/list')
                .then((res) => {
                    this.permissions = res.data.data;
                })

            this.$bus.$on('assign:by_role', function (permission) {

                $('#newRole' + permission.id).removeClass('hide'); //show badge
            })
        },
        methods: {
            percent(number, total){
                return (number / total) * 100
            },
            upperCase(text){
                return _.upperCase(text)
            },
            showModal(permission){
                let self = this;

                this.permission = permission;

                get(api_path + 'setting/permission/assigned/' + permission.name)
                    .then((res) => {
                        this.permissionId = res.data.data.id;
                        this.permissionName = res.data.data.name;
                        this.roles = res.data.data.allRoles.data;
                        this.assignedRoles = res.data.data.assignedRoles.data;
                        this.users = res.data.data.allUsers.data;
                        this.assignedUsers  =res.data.data.assignedUsers.data;
                        this.permission.roles =  this.assignedRoles;
                        this.permission.users = this.assignedUsers;
                        $('#newRole'+permission.id).addClass('hide');// hide badge if there is any
                    });

                $('#modal-permission-detail').modal("show"); // show modal

            },
            closeModal(){
                this.role = '';
                $('#modal-permission-detail').modal("toggle"); // close modal
            },
            assignPermission(permissionName, role){

                let assignRoleIdArr = [];

                _.forEach(this.assignedRoles, function (value, key) {
                    assignRoleIdArr.push(value.id); // push role ID to array
                });

                let data = {permissionName: permissionName, assignRoleIdArr: assignRoleIdArr};

                post(api_path + 'setting/permission/assign/by_permission/role', data)
                    .then((res) => {

                        this.permission.roles = res.data.assigned.data

                        this.$bus.$emit('assign:by_permission',role)

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


            },
            assignUser(permissionName, user){
                let assignUserIdArr = [];

                _.forEach(this.assignedUsers, function (value, key) {
                    assignUserIdArr.push(value.employeeId); // push role ID to array
                });

                let data = {permissionName: permissionName, assignUserIdArr: assignUserIdArr};

                post(api_path + 'setting/permission/assign/by_permission/user', data)
                    .then((res) => {

                    this.permission.users = res.data.assigned.data

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
//            console.log('Permission Card Component mounted')
        }
    }
</script>