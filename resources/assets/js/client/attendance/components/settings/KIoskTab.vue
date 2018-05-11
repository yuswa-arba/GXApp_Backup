<template>
    <div class="row">
        <div class="col-lg-7 m-b-10"></div>
        <div class="col-lg-5 m-b-10">
            <div class="card card-bordered">
                <div class="card-block">
                    <form id="kiosk-form">
                        <h4>Kiosk Form</h4>
                        <div class="form-group ">
                            <label>Code Name </label>
                            <input name="codeName" type="text" class="form-control" placeholder="e.g Kiosk_Canteen_1">
                        </div>
                        <div class="form-group ">
                            <label>Description</label>
                            <input name="description" type="text" class="form-control"
                                   placeholder="e.q 2nd Floor near meeting room ">
                        </div>

                        <div class="form-group form-group-default-select2">
                            <label class="">Activate</label>
                            <select class="full-width select2" name="isActivated" data-placeholder="Enable Device">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>
                        <button class="btn btn-complete pull-right" type="button" @click="createKiosk()">Save</button>
                    </form>
                    <div class="clearfix"></div>
                    <br>
                </div>
            </div>
        </div>

        <div class="col-lg-12 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-350">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-text-center settingDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black">ID</th>
                                        <th class="text-black">Code Name</th>
                                        <th class="text-black">Description</th>
                                        <th class="text-black">Activation</th>
                                        <th class="text-black">Passcode</th>
                                        <th class="text-black">Battery Power</th>
                                        <th class="text-black">Charging</th>
                                        <th class="text-black">Activated</th>
                                        <th class="text-black">Synced,Unsycned</th>
                                        <th class="text-black">Last Heartbeat</th>
                                        <th class="text-black">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="kiosk in kiosks">
                                        <td>{{kiosk.id}}</td>
                                        <td>
                                            <span v-if="!kiosk.editing">{{kiosk.codeName}}</span>
                                            <input class="" :value="kiosk.codeName" type="text" v-else=""
                                                   :name="'kioskCodeName'+kiosk.id">
                                        </td>
                                        <td>
                                            <span v-if="!kiosk.editing">{{kiosk.description}}</span>
                                            <input class="" :value="kiosk.description" type="text" v-else=""
                                                   :name="'kioskDesc'+kiosk.id">
                                        </td>
                                        <td>{{kiosk.activationCode}}</td>
                                        <td>
                                            <span v-if="!kiosk.editing"> {{kiosk.passcode}}</span>
                                            <input class="w-80" :value="kiosk.passcode" type="text" v-else=""
                                                   :name="'kioskPasscode'+kiosk.id">

                                        </td>
                                        <td>{{kiosk.batteryPower}}</td>
                                        <td>
                                            <i class="fs-16 text-complete fa fa-check" v-if="kiosk.isCharging==1"></i>
                                            <i class="fs-16 text-danger fa fa-times" v-else=""></i>
                                        </td>
                                        <td>
                                            <i class="fs-16 text-complete fa fa-check" v-if="kiosk.isActivated==1"></i>
                                            <i class="fs-16 text-danger fa fa-times" v-else=""></i>
                                        </td>
                                        <td>
                                            {{kiosk.totalSynced}},{{kiosk.totalUnsynced}}
                                        </td>
                                        <td>
                                            {{kiosk.lastHeartBeat}}
                                        </td>
                                        <td>
                                            <i v-if="!kiosk.editing" class="fs-14 fa fa-pencil pointer"
                                               @click="editKiosk(kiosk.id)"></i>
                                            <span v-else="" class="fs-12 text-danger cursor"
                                                  @click="saveEditingKiosk(kiosk.id)">DONE</span>
                                            &nbsp; &nbsp;
                                            <i class="fs-14 text-danger fa fa-trash pointer"
                                               @click="deleteKiosk(kiosk.id)"></i>
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
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                kiosks: [],
                apiToken: '',
                formObject: {},
            }
        },
        created(){
            let self = this
            get(api_path + 'component/list/kiosks')
                .then((res) => {
                    self.kiosks = res.data.data
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
            createKiosk(){
                let self = this
                let serializeForm = $('#kiosk-form').serializeArray()

                _.forEach(serializeForm, function (value, key) {
                    self.formObject[value.name] = value.value
                })

                post(api_path + 'attendance/kiosk/create', self.formObject)
                    .then((res) => {
                        if (!res.data.isFailed && res.data.kiosk) {

                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'info'
                            }).show();

                            self.kiosks.push(res.data.kiosk)

                        } else {
                            /* Show error notification */
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
//            getApiToken(){
//                let self = this
//                post('/oauth/token', {
//                    grant_type: 'client_credentials',
//                    client_id: '5',
//                    client_secret: 'NVPNbhFw7EwWlqnvyCcAFE1dvMs1E9AtC4pdBO9h'
//                })
//                    .then((res) => {
//                        self.apiToken = res.data.access_token
//                    })
//
//            },
            deleteKiosk(kioskId){
                let self = this
                if (confirm('Are you sure to delete this Kiosk?')) {
                    post(api_path + 'attendance/kiosk/delete', {id: kioskId})
                        .then((res) => {
                            if (!res.data.isFailed) {

                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();

                                // remove kiosk from array
                                let kioskIndex = _.findIndex(self.kiosks, {id: kioskId})
                                self.kiosks.splice(kioskIndex, 1)

                            } else {
                                /* Show error notification */
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

                }
            },
            editKiosk(kioskId){
                let self = this

                let kiosk = _.find(self.kiosks, {id: kioskId})
                kiosk.editing = true

            },
            saveEditingKiosk(kioskId){
                let self = this

                let newPasscode = $('input[name="kioskPasscode' + kioskId+'"]').val()
                let newDescription = $('input[name="kioskDesc' + kioskId+'"]').val()
                let newCodeName = $('input[name="kioskCodeName' + kioskId+'"]').val()


                post(api_path + 'attendance/kiosk/edit', {
                    kioskId: kioskId,
                    passcode: newPasscode,
                    description: newDescription,
                    codeName: newCodeName
                })
                    .then((res) => {

                            let kiosk = _.find(self.kiosks, {id: kioskId})
                            if (!res.data.isFailed) {

                                //success notification
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();


                                //insert new data
                                kiosk.passcode = newPasscode
                                kiosk.codeName = newCodeName
                                kiosk.description = newDescription
                                // close edit
                                kiosk.editing = false
                            } else {
                                //error notification
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'danger'
                                }).show();

                                //close edit
                                kiosk.editing = false
                            }
                        }
                    )
                    .catch((err) => {
                        //error notification
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    })


            }
        }
    }
</script>