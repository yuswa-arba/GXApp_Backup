<template>
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-12 m-b-10">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-header">
                        <p class="card-title text-uppercase text-black" style="opacity: 1">Supplier Form</p>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group-attached">
                                    <div class="form-group form-group-default required">
                                        <label> Name </label>
                                        <input type="text" class="form-control" v-model="formObject.name">
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label> Address </label>
                                        <input type="text" class="form-control" v-model="formObject.address">
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label>Country</label>
                                        <select name="" id="" class="form-control" v-model="formObject.country">
                                            <option :value="country.name" v-for="country in countries"
                                                    :selected="country.name=='Indonesia'">{{country.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label>City</label>
                                        <input type="text" class="form-control" v-model="formObject.city">
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label>Postal Code</label>
                                        <input type="text" class="form-control" v-model="formObject.postalCode">
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label>Telephone Number</label>
                                        <input type="text" class="form-control" v-model="formObject.telephoneNumber">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-4">
                                <div class="form-group-attached">
                                    <div class="form-group form-group-default">
                                        <label> Contact Person 1</label>
                                        <input type="text" class="form-control" v-model="formObject.contactPerson1">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label> Mobile Number 1</label>
                                        <input type="text" class="form-control" v-model="formObject.mobileNumber1">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label> Email 1</label>
                                        <input type="email" class="form-control" v-model="formObject.email1">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label> Contact Person 2</label>
                                        <input type="text" class="form-control" v-model="formObject.contactPerson2">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label> Mobile Number 2</label>
                                        <input type="text" class="form-control" v-model="formObject.mobileNumber2">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label> Email 2</label>
                                        <input type="email" class="form-control" v-model="formObject.email2">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group-attached">
                                    <div class="form-group form-group-default">
                                        <label> Accounting Number </label>
                                        <input type="text" class="form-control" v-model="formObject.accountingNumber">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Notes</label>
                                        <input type="text" class="form-control" v-model="formObject.notes">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label> Logo</label>
                                        <input type="file" class="form-control" @change="insertSupplierLogo($event)">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-12">
                                <button class="btn btn-complete pull-right" type="button" @click="createSupplier()">
                                    Create
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 m-b-10">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block">
                        <input type="text" style="height: 40px;" class="form-control" id="search-suppliers-box"
                               placeholder="Search Suppliers">
                        <div class="scrollable">
                            <div class="" style="height:700px">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover ">
                                        <thead class="bg-master-lighter">
                                        <tr>
                                            <th class="text-black">ID</th>
                                            <th></th>
                                            <th class="text-black">Name</th>
                                            <th class="text-black">Address,Country</th>
                                            <th class="text-black">Telephone</th>
                                            <th class="text-black" style="width: 100px">Contact 1</th>
                                            <th class="text-black" style="width: 100px">Contact 2</th>
                                            <th class="text-black">Accounting No.</th>
                                            <th class="text-black">Notes</th>
                                            <th class="text-black" style="width:120px">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="filter-item-suppliers" v-for="(supplier,index) in suppliers">
                                            <td>{{supplier.id}}</td>
                                            <td>
                                                <div v-if="!supplier.editing && supplier.logo"  class="cursor" @click="viewImage('/images/suppliers/logo/'+supplier.logo)">
                                                    <img :src="'/images/suppliers/logo/'+supplier.logo" height="70px" alt="">
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="!supplier.editing">{{supplier.name}}</span>
                                                <input type="text"
                                                       style="width:120px"
                                                       v-else=""
                                                       :name="'supplierName'+supplier.id"
                                                       :value="supplier.name">


                                            </td>
                                            <td>
                                                <span v-if="!supplier.editing">{{supplier.address}},{{supplier.city}},{{supplier.postalCode}},{{supplier.country}}</span>
                                                <div v-else="">
                                                    <input type="text"
                                                           placeholder="Address"
                                                           :name="'supplierAddress'+supplier.id"
                                                           :value="supplier.address">
                                                    <br>
                                                    <input type="text"
                                                           placeholder="City"
                                                           :name="'supplierCity'+supplier.id"
                                                           :value="supplier.city">
                                                    <br>
                                                    <input type="text"
                                                           placeholder="Postal Code"
                                                           :name="'supplierPostalCode'+supplier.id"
                                                           :value="supplier.postalCode">
                                                    <br>
                                                    <select :name="'supplierCountry'+supplier.id"
                                                            style="width: 120px;;">
                                                        <option :value="country.name" v-for="country in countries"
                                                                :selected="country.name==supplier.country">
                                                            {{country.name}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="!supplier.editing">{{supplier.telephoneNumber}}</span>
                                                <input type="text"
                                                       style="width: 90px"
                                                       v-else=""
                                                       :name="'supplierTelNumber'+supplier.id"
                                                       :value="supplier.telephoneNumber">
                                            </td>
                                            <td>
                                                <span v-if="!supplier.editing">

                                                    {{supplier.contactPerson1}} <br>
                                                    {{supplier.mobileNumber1}} <br>
                                                    {{supplier.email1}}

                                                </span>
                                                <div v-else="">
                                                    <input type="text"
                                                           style="width: 110px"
                                                           placeholder="Contact Person"
                                                           :name="'supplierContactPerson1'+supplier.id"
                                                           :value="supplier.contactPerson1">
                                                    <input type="text"
                                                           style="width: 110px"
                                                           placeholder="Mobile"
                                                           :name="'supplierMobileNumber1'+supplier.id"
                                                           :value="supplier.mobileNumber1">
                                                    <input type="text"
                                                           style="width: 110px"
                                                           placeholder="Email"
                                                           :name="'supplierEmail1'+supplier.id"
                                                           :value="supplier.email1">
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="!supplier.editing">

                                                    {{supplier.contactPerson2}} <br>
                                                    {{supplier.mobileNumber2}} <br>
                                                    {{supplier.email2}}

                                                </span>
                                                <div v-else="">
                                                    <input type="text"
                                                           style="width: 110px"
                                                           placeholder="Contact Person"
                                                           :name="'supplierContactPerson2'+supplier.id"
                                                           :value="supplier.contactPerson2">
                                                    <input type="text"
                                                           style="width: 110px"
                                                           placeholder="Mobile"
                                                           :name="'supplierMobileNumber2'+supplier.id"
                                                           :value="supplier.mobileNumber2">
                                                    <input type="text"
                                                           style="width: 110px"
                                                           placeholder="Email"
                                                           :name="'supplierEmail2'+supplier.id"
                                                           :value="supplier.email2">
                                                </div>
                                            </td>
                                            <td>
                                                <span v-if="!supplier.editing">{{supplier.accountingNumber}}</span>
                                                <input type="text"
                                                       style="width: 80px"
                                                       v-else=""
                                                       :name="'supplierAccNumber'+supplier.id"
                                                       :value="supplier.accountingNumber">
                                            </td>
                                            <td>
                                                <span v-if="!supplier.editing">{{supplier.notes}}</span>
                                                <input type="text"
                                                       v-else=""
                                                       :name="'supplierNotes'+supplier.id"
                                                       :value="supplier.notes">
                                            </td>
                                            <td>
                                                <div v-if="supplier.isDeleted==0">
                                                    <i class="fa fa-times text-danger cursor fs-16"
                                                       @click="deleteSupplier(supplier.id,index)"></i>
                                                    &nbsp;&nbsp;
                                                    <i class="fa fa-pencil text-primary cursor fs-16"
                                                       v-if="!supplier.editing"
                                                       @click="attemptUpdateSupplier(index)"></i>
                                                    <span class="fs-12 text-danger cursor"
                                                          v-else=""
                                                          @click="saveUpdateSupplier(supplier.id,index)">
                                                        DONE
                                                    </span>
                                                </div>
                                                <div v-else="">
                                                    <span class="fs-12 text-info cursor"
                                                          @click="undoDeleteSupplier(supplier.id,index)">
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
        </div>
    </div>
</template>

<script type="text/javascript">
    import{get, post} from '../../helpers/api'
    import {api_path} from '../../helpers/const'
    import {objectToFormData} from '../../helpers/utils'

    export default{
        data(){
            return {
                countries: [],
                suppliers: [],
                formObject: {
                    name: '',
                    address: '',
                    country: '',
                    city: '',
                    postalCode: '',
                    telephoneNumber: '',
                    contactPerson1: '',
                    mobileNumber1: '',
                    email1: '',
                    contactPerson2: '',
                    mobileNumber2: '',
                    email2: '',
                    accountingNumber: '',
                    notes: '',
                    logo: '',
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

            //get suppliers list
            get(api_path + 'storage/supplier/list')
                .then((res) => {
                    if (!res.data.isFailed) {
                        if (res.data.suppliers.data) {
                            self.suppliers = res.data.suppliers.data
                        }
                    }
                })

        },
        methods: {
            insertSupplierLogo(e){
                let self = this
                self.formObject.logo = e.target.files[0]
            },
            createSupplier(){
                let self = this

                if (
                    self.formObject.name &&
                    self.formObject.address &&
                    self.formObject.country &&
                    self.formObject.city &&
                    self.formObject.postalCode &&
                    self.formObject.telephoneNumber
                ) {
                    post(api_path + 'storage/create/supplier', objectToFormData(self.formObject))
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
                                if (res.data.supplier.data) {
                                    self.suppliers.push(res.data.supplier.data)
                                }

                                //reset form
                                self.formObject = {
                                    name: '',
                                    address: '',
                                    country: '',
                                    city: '',
                                    postalCode: '',
                                    telephoneNumber: '',
                                    contactPerson1: '',
                                    mobileNumber1: '',
                                    email1: '',
                                    contactPerson2: '',
                                    mobileNumber2: '',
                                    email2: '',
                                    accountingNumber: '',
                                    notes: '',
                                    logo: '',
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
                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Form is invalid',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            },
            attemptUpdateSupplier(index){
                let self = this
                self.suppliers[index].editing = true
            },
            saveUpdateSupplier(id, index){

                let self = this

                let supplierName = $('input[name="' + 'supplierName' + id + '"]').val()
                let supplierAddress = $('input[name="' + 'supplierAddress' + id + '"]').val()
                let supplierCity = $('input[name="' + 'supplierCity' + id + '"]').val()
                let supplierPostalCode = $('input[name="' + 'supplierPostalCode' + id + '"]').val()
                let supplierCountry = $('select[name="' + 'supplierCountry' + id + '"]').val()
                let supplierTelNumber = $('input[name="' + 'supplierTelNumber' + id + '"]').val()
                let supplierContactPerson1 = $('input[name="' + 'supplierContactPerson1' + id + '"]').val()
                let supplierMobileNumber1 = $('input[name="' + 'supplierMobileNumber1' + id + '"]').val()
                let supplierEmail1 = $('input[name="' + 'supplierEmail1' + id + '"]').val()
                let supplierContactPerson2 = $('input[name="' + 'supplierContactPerson2' + id + '"]').val()
                let supplierMobileNumber2 = $('input[name="' + 'supplierMobileNumber2' + id + '"]').val()
                let supplierEmail2 = $('input[name="' + 'supplierEmail2' + id + '"]').val()
                let supplierAccNumber = $('input[name="' + 'supplierAccNumber' + id + '"]').val()
                let supplierNotes = $('input[name="' + 'supplierNotes' + id + '"]').val()

                if (
                    supplierName &&
                    supplierAddress &&
                    supplierCountry &&
                    supplierCity &&
                    supplierPostalCode &&
                    supplierTelNumber
                ) {

                    post(api_path + 'storage/update/supplier', {
                        id: id,
                        name: supplierName,
                        address: supplierAddress,
                        country: supplierCountry,
                        city: supplierCity,
                        postalCode: supplierPostalCode,
                        telephoneNumber: supplierTelNumber,
                        contactPerson1: supplierContactPerson1,
                        mobileNumber1: supplierMobileNumber1,
                        email1: supplierEmail1,
                        contactPerson2: supplierContactPerson2,
                        mobileNumber2: supplierMobileNumber2,
                        email2: supplierEmail2,
                        accountingNumber: supplierAccNumber,
                        notes: supplierNotes,
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

                                self.suppliers[index].name = supplierName
                                self.suppliers[index].address = supplierAddress
                                self.suppliers[index].country = supplierCountry
                                self.suppliers[index].city = supplierCity
                                self.suppliers[index].postalCode = supplierPostalCode
                                self.suppliers[index].telephoneNumber = supplierTelNumber
                                self.suppliers[index].contactPerson1 = supplierContactPerson1
                                self.suppliers[index].mobileNumber1 = supplierMobileNumber1
                                self.suppliers[index].email1 = supplierEmail1
                                self.suppliers[index].contactPerson2 = supplierContactPerson2
                                self.suppliers[index].mobileNumber2 = supplierMobileNumber2
                                self.suppliers[index].email2 = supplierEmail2
                                self.suppliers[index].accountingNumber = supplierAccNumber
                                self.suppliers[index].notes = supplierNotes
                                self.suppliers[index].editing = false


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
                        message: 'Required form cannot be empty',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();

                    self.suppliers[index].editing = false
                }


            },
            deleteSupplier(id, index){
                let self = this
                if (id) {
                    if (confirm('Are you sure to delete this supplier?')) {
                        post(api_path + 'storage/delete/supplier', {id: id})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.suppliers[index].isDeleted = 1

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
            undoDeleteSupplier(id, index){
                let self = this
                if (id) {
                    if (confirm('Undo delete this supplier?')) {
                        post(api_path + 'storage/undoDelete/supplier', {id: id})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.suppliers[index].isDeleted = 0

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
            viewImage(url){
                window.open(url,'_blank')
            }
        }
    }

</script>