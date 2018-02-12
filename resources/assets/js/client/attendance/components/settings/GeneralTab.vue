<template>
    <div class="row column-seperation">
        <div class="col-lg-8 m-b-10">
            <div class="card card-bordered">
                <div class="card-block">
                    <h4> Attendance Setting</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-master-lighter">
                            <tr>
                                <th class="text-black">Name</th>
                                <th class="text-black">Value</th>
                                <th class="text-black">Description</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(setting,index) in attendanceSettings">
                            <td>{{setting.name}}</td>
                            <td>
                            <span v-if="!setting.editing">{{setting.value}}</span>
                            <input v-else="" type="text" :name="'editValue'+setting.id" :value="setting.value">
                            </td>
                            <td>
                            <span v-if="!setting.editing">{{setting.description}}</span>
                            <input v-else="" type="text" :name="'editDescription'+setting.id" :value="setting.description" style="width: 380px">
                            </td>
                            <td>
                            <i v-if="!setting.editing" class="fa fa-pencil text-primary fs-16 cursor"
                            @click="startEditing(setting.id,index)"></i>
                            <i v-else="" class="text-danger cursor"
                            @click="doneEditing(setting.id,index)">DONE</i>
                            </td>
                            </tr>
                            </tbody>
                        </table>
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
                attendanceSettings:[]
            }
        },
        created(){
            let self = this

            get(api_path+'attendance/setting/list')
                .then((res)=>{
                    self.attendanceSettings = res.data.attendanceSettings.data
                })

        },
        methods:{
            startEditing(id, index){

                let self = this
                self.attendanceSettings[index].editing = true

            },
            doneEditing(id, index){
                let self = this

                let value = $('input[name="' + 'editValue' + id + '"]').val()
                let description = $('input[name="' + 'editDescription' + id + '"]').val()

                if(value){
                    post(api_path + 'attendance/setting/edit', {id: id, value: value,description:description})
                        .then((res) => {

                            if (!res.data.isFailed) {
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();

                                //update array
                                self.attendanceSettings.splice(index,1,res.data.attendanceSetting.data)

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
                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Update canceled. Value cannot be empty',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

                self.attendanceSettings[index].editing = false
            }

        },
        computed:{}
    }
</script>