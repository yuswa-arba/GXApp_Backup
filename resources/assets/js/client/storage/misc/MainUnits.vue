<template>
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-8 m-b-10">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block">
                        <input type="text" style="height: 40px;" class="form-control" id="search-units-box"
                               placeholder="Search Units">
                        <div class="scrollable">
                            <div class="" style="height:700px">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover ">
                                        <thead class="bg-master-lighter">
                                        <tr>
                                            <th class="text-black">ID</th>
                                            <th class="text-black">Format</th>
                                            <th class="text-black">Description</th>
                                            <th class="text-black">Type</th>
                                            <th class="text-black">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="filter-item-units" v-for="(uom,index) in unitOfMeasurements">
                                            <td>{{uom.id}}</td>
                                            <td>
                                                <span v-if="!uom.editing">{{uom.format}}</span>
                                                <input v-else="" 
                                                       type="text"
                                                        :name="'unitFormat'+uom.id"
                                                       :value="uom.format"
                                                >
                                            </td>
                                            <td>
                                                <span v-if="!uom.editing">{{uom.description}}</span>
                                                <input v-else="" 
                                                       type="text"
                                                        :name="'unitDescription'+uom.id"
                                                       :value="uom.description"
                                                >
                                            </td>
                                            <td>
                                                <span v-if="!uom.editing">{{uom.uomTypeName}}</span>
                                                <select v-else="" :name="'unitTypeId'+uom.id">
                                                    <option :value="uomType.id" v-for="uomType in uomTypes" :selected="uomType.id==uom.uomTypeId">{{uomType.name}}</option>
                                                </select>

                                            </td>
                                            <td>
                                                <div v-if="uom.isDeleted==0">
                                                    <i class="fa fa-times text-danger cursor fs-16"
                                                       @click="deleteUnit(uom.id,index)"></i>
                                                    &nbsp;&nbsp;
                                                    <i class="fa fa-pencil text-primary cursor fs-16"
                                                       v-if="!uom.editing"
                                                       @click="attemptUpdateUnit(index)"></i>
                                                    <span class="fs-12 text-danger cursor"
                                                          v-else=""
                                                          @click="saveUpdateUnit(uom.id,index)">
                                                        DONE
                                                    </span>
                                                </div>
                                                <div v-else="">
                                                    <span class="fs-12 text-info cursor"
                                                          @click="undoDeleteUnit(uom.id,index)">
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
                        <form id="warehouse-form">
                            <h4>Unit of Measurement Form</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Format</label>
                                        <input type="text" class="form-control"
                                               v-model="formObject.formatValue"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control"
                                               v-model="formObject.description"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-control" v-model="formObject.uomTypeId">
                                            <option :value="uomType.id" v-for="uomType in uomTypes">{{uomType.name}}</option>
                                        </select>
                                    </div>
                                    <button class="btn btn-complete pull-right" type="button"
                                            @click="createUnitOfMeasurement()">Create
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
                uomTypes: [],
                unitOfMeasurements: [],
                formObject: {
                    formatValue: '',
                    description: '',
                    uomTypeId: ''
                }
            }
        },
        created(){
            let self = this

            //get uom types
            get(api_path + 'component/list/uomTypes')
                .then((res) => {
                    self.uomTypes = res.data.data
                })

            //get unit of measurements
            get(api_path + 'storage/unit/list')
                .then((res) => {
                    if (!res.data.isFailed) {
                        self.unitOfMeasurements = res.data.units.data
                    }
                })

        },
        methods: {
            createUnitOfMeasurement(){

                let self = this
                post(api_path + 'storage/create/unit', self.formObject)
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
                            if (res.data.unit.data) {
                                self.unitOfMeasurements.push(res.data.unit.data)
                            }

                            //reset form
                            self.formObject = {
                                format: '',
                                description: '',
                                uomTypeId: ''
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
            attemptUpdateUnit(index){
                let self = this
                self.unitOfMeasurements[index].editing = true
            },
            saveUpdateUnit(id, index){
                let self = this

                let unitFormat = $('input[name="' + 'unitFormat' + id + '"').val()
                let unitDescription = $('input[name="' + 'unitDescription' + id + '"').val()
                let unitTypeId = $('select[name="' + 'unitTypeId' + id + '"').val()
                let unitTypeName = $('select[name="' + 'unitTypeId' + id + '"] option:selected').text()

                post(api_path + 'storage/update/unit', {
                    id: id,
                    formatValue: unitFormat,
                    description: unitDescription,
                    uomTypeId: unitTypeId
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

                            self.unitOfMeasurements[index].formatValue = unitFormat
                            self.unitOfMeasurements[index].description = unitDescription
                            self.unitOfMeasurements[index].uomTypeId = unitTypeId
                            self.unitOfMeasurements[index].uomTypeName = unitTypeName
                            self.unitOfMeasurements[index].editing = false

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
            deleteUnit(id, index){
                let self = this
                if (id) {
                    if (confirm('Are you sure to delete this unit?')) {
                        post(api_path + 'storage/delete/unit', {id: id})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.unitOfMeasurements[index].isDeleted = 1

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
            undoDeleteUnit(id, index){
                let self = this
                if (id) {
                    if (confirm('Undo delete this unit?')) {
                        post(api_path + 'storage/undoDelete/unit', {id: id})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.unitOfMeasurements[index].isDeleted = 0

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