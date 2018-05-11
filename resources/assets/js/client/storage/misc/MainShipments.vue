<template>
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-8 m-b-10">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block">
                        <input type="text" style="height: 40px;" class="form-control" id="search-shipments-box"
                               placeholder="Search Shipments"
                        >
                        <div class="scrollable">
                            <div class="" style="height:700px">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover ">
                                        <thead class="bg-master-lighter">
                                        <tr>
                                            <th class="text-black">ID</th>
                                            <th class="text-black">Name</th>
                                            <th class="text-black">Website</th>
                                            <th class="text-black">Call Center</th>
                                            <th class="text-black">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="filter-item-shipments" v-for="(shipment,index) in shipments">
                                            <td>{{shipment.id}}</td>
                                            <td>
                                                <span v-if="!shipment.editing">{{shipment.name}}</span>
                                                <input v-else=""
                                                       :name="'shipmentName'+shipment.id"
                                                       :value="shipment.name"
                                                       type="text"
                                                       class="form-control">
                                            </td>
                                            <td>
                                                <span v-if="!shipment.editing">{{shipment.website}}</span>
                                                <input v-else=""
                                                       :name="'shipmentWebsite'+shipment.id"
                                                       :value="shipment.website"
                                                       type="text"
                                                       class="form-control">
                                            </td>
                                            <td>
                                                <span v-if="!shipment.editing">{{shipment.callCenter}}</span>
                                                <input v-else=""
                                                       :name="'shipmentCallCenter'+shipment.id"
                                                       :value="shipment.callCenter"
                                                       type="text"
                                                       class="form-control">
                                            </td>
                                            <td>
                                                <div v-if="shipment.isDeleted==0">
                                                    <i class="fa fa-times text-danger cursor fs-16"
                                                       @click="deleteShipment(shipment.id,index)"></i>
                                                    &nbsp;&nbsp;
                                                    <i class="fa fa-pencil text-primary cursor fs-16"
                                                       v-if="!shipment.editing"
                                                       @click="attemptUpdateShipment(index)"></i>
                                                    <span class="fs-12 text-danger cursor"
                                                          v-else=""
                                                          @click="saveUpdateShipment(shipment.id,index)">
                                                        DONE
                                                    </span>
                                                </div>
                                                <div v-else="">
                                                    <span class="fs-12 text-info cursor"
                                                          @click="undoDeleteShipment(shipment.id,index)">
                                                        UNDELETE
                                                    </span>
                                                </div>

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

            <div class="col-lg-4 m-b-10">
                <div class="card card-bordered">
                    <div class="card-block">
                        <form id="shipment-form">
                            <h4>Shipments Form</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text"
                                               v-model="formObject.name"
                                               class="form-control"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label>Website</label>
                                        <input type="text"
                                               class="form-control"
                                               v-model="formObject.website"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label>Call Center</label>
                                        <input type="text"
                                               class="form-control"
                                               v-model="formObject.callCenter"
                                               required>
                                    </div>
                                    <button class="btn btn-complete pull-right" type="button" @click="createShipment()">
                                        Create
                                    </button>

                                </div>
                            </div>
                        </form>

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
                shippingTypes: [],
                shipments: [],
                formObject: {
                    name: '',
                    website: '',
                    callCenter: ''
                }
            }
        },
        created(){
            let self = this

            //get shipments data
            get(api_path + 'storage/shipment/list')
                .then((res) => {
                    if (!res.data.isFailed) {
                        self.shipments = res.data.shipments.data
                    }
                })
        },
        methods: {
            createShipment(){
                let self = this
                post(api_path + 'storage/create/shipment', self.formObject)
                    .then((res) => {
                        if (!res.data.isFailed) {

                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'info'
                            }).show();

                            //push to array
                            if (res.data.shipment.data) {
                                self.shipments.push(res.data.shipment.data)
                            }

                            //reset form
                            self.formObject = {
                                name: '',
                                website: '',
                                callCenter: ''
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
            attemptUpdateShipment(index){
                let self = this
                self.shipments[index].editing = true
            },
            saveUpdateShipment(id, index){
                let self = this

                let shipmentName = $('input[name="' + 'shipmentName' + id + '"]').val()
                let shipmentWebsite = $('input[name="' + 'shipmentWebsite' + id + '"]').val()
                let shipmentCallCenter = $('input[name="' + 'shipmentCallCenter' + id + '"]').val()

                post(api_path + 'storage/update/shipment', {
                    id: id,
                    name: shipmentName,
                    website: shipmentWebsite,
                    callCenter: shipmentCallCenter
                })
                    .then((res) => {
                        if (!res.data.isFailed) {

                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'info'
                            }).show();

                            self.shipments[index].name = shipmentName
                            self.shipments[index].website = shipmentWebsite
                            self.shipments[index].callCenter = shipmentCallCenter
                            self.shipments[index].editing = false

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


            },
            deleteShipment(id, index){
                let self = this
                if (id) {
                    if (confirm('Are you sure to delete this shipment?')) {
                        post(api_path + 'storage/delete/shipment', {id: id})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.shipments[index].isDeleted = 1

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
                    }
                }
            },
            undoDeleteShipment(id, index){
                let self = this
                if (id) {
                    if (confirm('Undo delete this shipment?')) {
                        post(api_path + 'storage/undoDelete/shipment', {id: id})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.shipments[index].isDeleted = 0

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
                    }
                }
            }
        }
    }
</script>