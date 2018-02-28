<template>
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-9 m-b-10">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block">
                        <input type="text" style="height: 40px;" class="form-control" id="search-warehouses-box"
                               placeholder="Search Warehouse">
                        <div class="scrollable">
                            <div class="" style="height:700px">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover ">
                                        <thead class="bg-master-lighter">
                                        <tr>
                                            <th class="text-black">ID</th>
                                            <th class="text-black">Name</th>
                                            <th class="text-black">Address</th>
                                            <th class="text-black">Country, City, Postal Code</th>
                                            <th class="text-black">Phone</th>
                                            <th class="text-black" style="width: 120px">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="filter-item-warehouses" v-for="(warehouse,index) in warehouses">
                                            <td>
                                                {{warehouse.id}}
                                            </td>
                                            <td>
                                                <span v-if="!warehouse.editing">{{warehouse.name}}</span>
                                                <input v-else="" type="text" :name="'warehouseName'+warehouse.id" :value="warehouse.name">
                                            </td>
                                            <td>
                                                <span v-if="!warehouse.editing">{{warehouse.address}}</span>
                                                <input v-else="" type="text" :name="'warehouseAddress'+warehouse.id" :value="warehouse.address">
                                            </td>
                                            <td>
                                                <span v-if="!warehouse.editing">{{warehouse.country}}, {{warehouse.city}}, {{warehouse.postalCode}}</span>
                                                <div v-else="">
                                                    <select :name="'warehouseCountry'+warehouse.id" style="width: 160px">
                                                        <option :value="country.name" v-for="country in countries" :selected="country.name==warehouse.country">
                                                            {{country.name}}
                                                        </option>
                                                    </select>
                                                    <input type="text" :name="'warehouseCity'+warehouse.id" :value="warehouse.city">
                                                    <input type="text" :name="'warehousePostalCode'+warehouse.id" :value="warehouse.postalCode">
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="!warehouse.editing">{{warehouse.phoneNumber}}</span>
                                                <input v-else=""
                                                       style="width: 140px"
                                                       type="text"
                                                       :value="warehouse.phoneNumber"
                                                       :name="'warehousePhoneNumber'+warehouse.id">
                                            </td>
                                          <td>
                                                <div v-if="warehouse.isDeleted==0">
                                                    <i class="fa fa-times text-danger cursor fs-16"
                                                       @click="deleteWarehouse(warehouse.id,index)"></i>
                                                    &nbsp;&nbsp;
                                                    <i class="fa fa-pencil text-primary cursor fs-16"
                                                       v-if="!warehouse.editing"
                                                       @click="attemptUpdateWarehouse(index)"></i>
                                                    <span class="fs-12 text-danger cursor"
                                                          v-else=""
                                                          @click="saveUpdateWarehouse(warehouse.id,index)">
                                                        DONE
                                                    </span>
                                                </div>
                                                <div v-else="">
                                                    <span class="fs-12 text-info cursor"
                                                          @click="undoDeleteWarehouse(warehouse.id,index)">
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

            <div class="col-lg-3 m-b-10">
                <div class="card card-bordered">
                    <div class="card-block">
                        <form id="warehouse-form">
                            <h4>Warehouses Form</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text"
                                               class="form-control"
                                               v-model="formObject.name"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text"
                                               class="form-control"
                                               v-model="formObject.address"
                                               required>
                                    </div>

                                    <div class="form-group">
                                        <label>Country</label>
                                        <select class="form-control"
                                                v-model="formObject.country"
                                        >
                                            <option :value="country.name" v-for="country in countries">
                                                {{country.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                        <input type="text"
                                               v-model="formObject.city"
                                               class="form-control"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label>Postal Code</label>
                                        <input type="text"
                                               v-model="formObject.postalCode"
                                               class="form-control"
                                               required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="text"
                                               v-model="formObject.phoneNumber"
                                               class="form-control"
                                               required>
                                    </div>
                                    <button class="btn btn-complete pull-right" type="button"
                                            @click="createWarehouse()">Create
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
                countries: [],
                warehouses: [],
                formObject: {
                    name: '',
                    address: '',
                    country: '',
                    city: '',
                    postalCode: '',
                    phoneNumber: ''
                }
            }
        },
        created(){

            let self = this

            //get countries list
            get(api_path + 'component/list/countries')
                .then((res) => {
                    self.countries = res.data.data
                })

            //get warehouse list
            get(api_path + 'storage/warehouse/list')
                .then((res) => {
                    if (!res.data.isFailed) {
                        self.warehouses = res.data.warehouses.data
                    }
                })


        },
        methods: {
            createWarehouse(){
                let self = this
                post(api_path + 'storage/create/warehouse', self.formObject)
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
                            if (res.data.warehouse.data) {
                                self.warehouses.push(res.data.warehouse.data)
                            }

                            //reset form
                            self.formObject = {
                                name: '',
                                address: '',
                                country: '',
                                city: '',
                                postalCode: '',
                                phoneNumber: ''
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
            attemptUpdateWarehouse(index){
                let self = this
                self.warehouses[index].editing = true
            },
            saveUpdateWarehouse(id, index){
                let self = this

                let warehouseName = $('input[name="' + 'warehouseName' + id + '"').val()
                let warehouseAddress = $('input[name="' + 'warehouseAddress' + id + '"').val()
                let warehouseCountry = $('select[name="' + 'warehouseCountry' + id + '"').val()
                let warehouseCity = $('input[name="' + 'warehouseCity' + id + '"').val()
                let warehousePostalCode = $('input[name="' + 'warehousePostalCode' + id + '"').val()
                let warehousePhoneNumber = $('input[name="' + 'warehousePhoneNumber' + id + '"').val()


                post(api_path + 'storage/update/warehouse', {
                    id: id,
                    name: warehouseName,
                    address: warehouseAddress,
                    country: warehouseCountry,
                    city: warehouseCity,
                    postalCode: warehousePostalCode,
                    phoneNumber: warehousePhoneNumber
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

                            self.warehouses[index].name = warehouseName
                            self.warehouses[index].address = warehouseAddress
                            self.warehouses[index].country = warehouseCountry
                            self.warehouses[index].city = warehouseCity
                            self.warehouses[index].postalCode = warehousePostalCode
                            self.warehouses[index].phoneNumber = warehousePhoneNumber
                            self.warehouses[index].editing = false

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
            deleteWarehouse(id, index){
                let self = this
                if (id) {
                    if (confirm('Are you sure to delete this warehouse?')) {
                        post(api_path + 'storage/delete/warehouse', {id: id})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.warehouses[index].isDeleted = 1

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
            undoDeleteWarehouse(id, index){
                let self = this
                if (id) {
                    if (confirm('Undo delete this warehouse?')) {
                        post(api_path + 'storage/undoDelete/warehouse', {id: id})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.warehouses[index].isDeleted = 0

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