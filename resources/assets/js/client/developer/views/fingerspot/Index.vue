<template>
    <div class="row">
        <div class="col-lg-12 m-b-10" v-if="!showCreateForm">
            <button class="btn btn-primary pull-right" @click="showDeviceForm()">
                Insert Device
            </button>
        </div>
        <div class="col-lg-8 m-b-10"></div>
        <div class="col-lg-4 m-b-10" v-if="showCreateForm">
            <div class="card no-border">
                <div class="card-header">
                    <i class="fa fa-times text-danger pull-right cursor fs-16" @click="hideDeviceForm()"></i>
                </div>
                <div class="card-block ">
                    <form id="fingerspot-form">
                        <h4>Fingerspot Form</h4>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Server IP</label>
                                    <input type="text" class="form-control" v-model="formObject.server_ip">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Server Port</label>
                                    <input type="text" class="form-control" v-model="formObject.server_port">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label> Serial Number</label>
                                    <input type="text" class="form-control" v-model="formObject.device_sn">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <input type="text" class="form-control" v-model="formObject.description">
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="checkbox check-success ">
                                        <input type="checkbox"
                                               value="1"
                                               name="is_activated"
                                               id="is_activated"
                                               v-model="formObject.is_activated">
                                        <label for="is_activated">Activate</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="form-group">
                                    <button class="btn btn-primary pull-right" @click="createFingerspotDevice()">
                                        Create
                                    </button>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-500">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover fingerspotDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th>ID</th>
                                        <th>Server IP</th>
                                        <th>Server Port</th>
                                        <th>SN</th>
                                        <th>Activated</th>
                                        <th>Description</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(device,index) in fingerspotDevices">
                                        <td>{{device.id}}</td>
                                        <td>
                                            <span v-if="!device.editing">  {{device.server_ip}}</span>
                                            <input style="width: 140px;" type="text" :value="device.server_ip" :name="'serverIp-'+device.id" v-else="">
                                        </td>
                                        <td>
                                            <span v-if="!device.editing">   {{device.server_port}}</span>
                                            <input style="width: 140px;" type="text" :value="device.server_port" :name="'serverPort-'+device.id" v-else="">
                                        </td>
                                        <td>
                                            <span v-if="!device.editing"> {{device.device_sn}}</span>
                                            <input style="width: 140px;" type="text" :value="device.device_sn" :name="'deviceSn-'+device.id" v-else="">
                                        </td>
                                        <td>
                                            <div v-if="!device.editing">
                                                <i class="fa fa-check text-primary" v-if="device.is_activated"></i>
                                                <i class="fa fa-times text-danger" v-else=""></i>
                                            </div>
                                            <div class="checkbox check-success " v-else="" style="width: 100px">
                                                <input type="checkbox"
                                                       value="1"
                                                       :name="'isActivated-'+device.id"
                                                       :checked="device.is_activated"
                                                       id="'isActivated-'+device.id">
                                                <label for="'isActivated-'+device.id">Activate</label>
                                            </div>

                                        </td>
                                        <td>
                                            <span v-if="!device.editing">{{device.description}}</span>
                                            <input style="width: 140px;" type="text" :value="device.description" :name="'description-'+device.id" v-else="">
                                        </td>
                                        <td>
                                            <i class="fa fa-pencil text-primary cursor"
                                               @click="attemptUpdateDevice(index)"
                                               v-if="!device.editing"></i>
                                            <span class="fs-12 text-danger cursor"
                                                  v-else=""
                                                  @click="saveUpdateDevice(device.id,index)">
                                                        DONE
                                                    </span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>
<script type="text/javascript">
    import {api_path} from '../../../helpers/const'
    import {get, post} from '../../../helpers/api'
    export default{
        data(){
            return {
                fingerspotDevices: [],
                formObject: {
                    server_ip: '',
                    server_port: '',
                    device_sn: '',
                    is_activated: 0,
                    description: '',
                },
                showCreateForm:false
            }
        },
        created(){
            this.getFingerspotDevices()
        },
        methods: {
            showDeviceForm(){
                this.showCreateForm = true
            },
            hideDeviceForm(){
                this.showCreateForm = false
            },
            getFingerspotDevices(){
                get(api_path + 'developer/fingerspot/list')
                    .then((res) => {
                        if (!res.data.isFailed) {
                            this.fingerspotDevices = res.data.fingerspotDevices.data
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
            },
            createFingerspotDevice(){
                let self = this
                post(api_path + 'developer/fingerspot/submit', this.formObject)
                    .then((res) => {
                        if (!res.data.isFailed) {

                            self.fingerspotDevices.push(res.data.fingerspotDevice.data)

                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'info'
                            }).show();


                            //reset form
                            self.formObject = {
                                server_ip: '',
                                server_port: '',
                                device_sn: '',
                                is_activated: 0,
                                description: '',
                            }


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

            },
            attemptUpdateDevice(index){
                let self = this
                self.fingerspotDevices[index].editing = true
            },
            saveUpdateDevice(id, index){
                let self = this
                let serverIp = $('input[name="' + 'serverIp-' + id + '"').val()
                let serverPort = $('input[name="' + 'serverPort-' + id + '"').val()
                let deviceSn = $('input[name="' + 'deviceSn-' + id + '"').val()
                let isActivated = $('input[name="' + 'isActivated-' + id + '"').val()
                let description = $('input[name="' + 'description-' + id + '"').val()

                post(api_path + 'developer/fingerspot/update', {
                    id:id,
                    serverIp: serverIp,
                    serverPort: serverPort,
                    deviceSn: deviceSn,
                    isActivated: isActivated,
                    description: description,
                }).then((res) => {
                    if (!res.data.isFailed) {


                         $('.page-container').pgNotification({
                              style: 'flip',
                              message: res.data.message,
                              position: 'top-right',
                              timeout: 3500,
                              type: 'info'
                          }).show();

                        self.fingerspotDevices[index].server_ip = serverIp
                        self.fingerspotDevices[index].server_port = serverPort
                        self.fingerspotDevices[index].device_sn = deviceSn
                        self.fingerspotDevices[index].description = description
                        self.fingerspotDevices[index].is_activated = isActivated
                        self.fingerspotDevices[index].editing = false


                    } else{
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
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