<template>
    <div class="row">
        <div class="col-lg-4  filter-item" v-for="role in roles">
            <div class="card card-default ">
                <div class="card-header ">
                    <div class="card-title">
                        #{{role.id}} {{role.name}} <span :id="'newPermission'+role.id"
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

                    <p class="hint-text fade small pull-left">
                        Total : {{role.permissions.length}}
                        / {{role.totalPermission}} Permissions</p>
                    <div class="clearfix"></div>
                    <div class="progress progress-small m-b-15 m-t-10">
                        <!-- START BOOTSTRAP PROGRESS (http://getbootstrap.com/components/#progress) -->
                        <div class="progress-bar progress-bar-primary"
                             :style="{width:percent(role.permissions.length,role.totalPermission)+'%'}">
                        </div>
                        <!-- END BOOTSTRAP PROGRESS -->
                    </div>
                    <div class="scrollable">
                        <div class="scroll-h-70">
                            <p class="all-caps font-montserrat text-success fs-8 bold no-margin">
                                <span v-for="permission in role.permissions">
                                    <i class="fa fa-circle smaller"></i> {{permission.name}}
                                <br>
                                </span>

                            </p>
                        </div>
                    </div>
                    <button class="btn btn-block btn-vd-role" :value="role.name" @click="showModal(role)">
                        View
                        Details
                    </button>
                </div>
            </div>
        </div>
        <!-- MODAL VIEW DETAIL ROLE -->
        <div class="modal fade stick-up" id="modal-role-detail" tabindex="-1" role="dialog" aria-hidden="true">

            <div class="modal-dialog modal-lg role-permission-modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <i class="pg-close"></i>
                        </button>
                        <!--<div id="mh-role"></div>-->
                        <h5 class="text-left dark-title p-b-5">#{{roleId}} {{upperCase(roleName)}}</h5>
                    </div>
                    <div class="modal-body">
                        <!--<div id="mb-role-detail"></div>-->
                        <div class="row">
                            <div class="col-lg-12"></div>
                            <div class="col-lg-3 col-md-3 col-sm-3 sm-m-t-10" v-for="permission in permissions">
                                <div class="checkbox check-danger checkbox-circle">
                                    <input type="checkbox"
                                           v-model="assignedPermissions"
                                           :value="permission"
                                           :id="'cbpermission'+permission.id"
                                           @change="assign(roleName,permission)"
                                    >
                                    <label :for="'cbpermission'+permission.id">{{permission.name}}</label>
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
                roleId: '',
                roleName: '',
                roles: [],
                permissions: [],
                assignedPermissions: [],

            }
        },
        created(){

            let self = this;
            get(api_path + 'setting/role/list')
                .then((res) => {
                    self.roles = res.data.data;
                })

            this.$bus.$on('assign:by_permission', function (role) {

                $('#newPermission' + role.id).removeClass('hide'); //show badge
            })


        },
        methods: {
            percent(permission, totalPermission){
                return (permission / totalPermission) * 100
            },
            upperCase(text){
                return _.upperCase(text)
            },
            showModal(role){

                let self = this;

                this.role = role;

                get(api_path + 'setting/role/assigned/' + role.name)
                    .then((res) => {
                        this.roleId = res.data.data.id;
                        this.roleName = res.data.data.name;
                        this.permissions = res.data.data.allPermissions.data;
                        this.assignedPermissions = res.data.data.assignedPermissions.data;
                        this.role.permissions = this.assignedPermissions; // update card list
                        $('#newPermission' + role.id).addClass('hide'); // hide badge if there is any
                    });

                $('#modal-role-detail').modal('show')
            },
            closeModal(){
                this.role = '';
                $('#modal-role-detail').modal("toggle"); // close modal
            },
            assign(roleName, permission){
                let assignPermissionIdArr = [];

                _.forEach(this.assignedPermissions, function (value, key) {
                    assignPermissionIdArr.push(value.id); // push permission ID to array
                });

                let data = {roleName: roleName, assignPermissionIdArr: assignPermissionIdArr};

                post(api_path + 'setting/role/assign/by_role', data)
                    .then((res) => {

                        this.role.permissions = res.data.assigned.data;

                        this.$bus.$emit('assign:by_role', permission)

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