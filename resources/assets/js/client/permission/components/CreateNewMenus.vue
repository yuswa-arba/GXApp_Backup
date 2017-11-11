<template>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="#"
           id="btn-new-role"
           @click="showModal(1)"
        >
            New Role</a>
        <a class="dropdown-item" href="#"
           id="btn-new-permission"
           @click="showModal(2)"
        >
            New Permission
        </a>
    </div>
</template>

<script>
    import {get, post} from '../../helpers/api'
    import {api_path} from '../../helpers/const'

    export default {
        data(){
            return {
                newRoleName:'',
                newPermissionName:'',
            }
        },
        created(){

        },
        methods: {
            showModal(id){
                if (id == '1') {
                    $('#modal-new-role').modal("show")
                } else if (id == '2') {
                    $('#modal-new-permission').modal("show")
                }
            },
            submitNewPermission(permissionName){
                console.log(permissionName)
            },
            submitNewRole(roleName){

            }
        },
        mounted(){

        }
    }

</script>
