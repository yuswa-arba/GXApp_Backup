<template>
    <div class="row">
        <div class="col-lg-6 m-b-10">
            <div class="card card-bordered">
                <div class="card-block">
                    <h4> Payroll Setting</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-master-lighter">
                            <tr>
                                <th class="text-black">Name</th>
                                <th class="text-black">Value</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(setting,index) in payrollSettings">
                                <td>{{setting.name}}</td>
                                <td>
                                    <span v-if="!setting.editing">{{setting.value}}</span>
                                    <input v-else="" type="text" :name="'editValue'+setting.id" :value="setting.value">
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
                payrollSettings: []
            }
        },
        created(){
            let self = this


            // get payroll setting data
            get(api_path + 'salary/payrollSetting/list')
                .then((res) => {
                    self.payrollSettings = res.data.payrollSettings.data
                })

        },
        methods: {

            startEditing(id, index){

                let self = this
                self.payrollSettings[index].editing = true

            },
            doneEditing(id, index){
                let self = this

                let value = $('input[name="' + 'editValue' + id + '"]').val()

                if(value){
                    post(api_path + 'salary/payrollSetting/edit', {id: id, value: value})
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
                                self.payrollSettings.splice(index,1,res.data.payrollSetting.data)

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

                self.payrollSettings[index].editing = false
            }

        },
        computed: {}

    }
</script>