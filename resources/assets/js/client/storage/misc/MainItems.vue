<template>
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-8 m-b-10">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-header">
                        <p class="card-title text-uppercase text-black" style="opacity: 1">Item Form</p>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group-attached">
                                    <div class="form-group form-group-default required">
                                        <label> Name </label>
                                        <input type="text" class="form-control" v-model="formObject.name">
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label> Unit </label>
                                        <select v-model="formObject.unitId" class="form-control">
                                            <option :value="unit.id" v-for="unit in units">{{unit.format}} - {{unit.description}} ({{unit.uomTypeName}})</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label> Type </label>
                                        <select v-model="formObject.itemTypeCode" class="form-control">
                                            <option :value="type.code" v-for="type in types">{{type.name}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label> Category </label>
                                        <select v-model="formObject.categoryCode" class="form-control">
                                            <option :value="category.code" v-for="category in categories">{{category.name}} ({{category.code}})</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label>Accounting Number</label>
                                        <input v-model="formObject.accountingNumber" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group-attached">
                                    <div class="form-group form-group-default">
                                        <label>Reminder 1</label>
                                        <input v-model="formObject.reminder1" type="number" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Reminder 2</label>
                                        <input v-model="formObject.reminder2" type="number" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Minimum Stock</label>
                                        <input v-model="formObject.minimumStock" type="number" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label> Allow Notification </label>
                                        <select v-model="formObject.allowNotification" class="form-control">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Status</label>
                                        <select v-model="formObject.statusId" class="form-control">
                                            <option :value="status.id" v-for="status in statuses">{{status.name}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Photo</label>
                                        <input type="file" class="form-control" @change="insertItemPhoto($event)">
                                    </div>
                                    <br>
                                    <button class="btn btn-complete pull-right" type="button" @click="createItem()">
                                        Create
                                    </button>
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
                items: [],
                categories: [],
                types: [],
                units: [],
                statuses: [],
                formObject: {
                    name: '',
                    unitId: '',
                    itemTypeCode: '',
                    categoryCode: '',
                    accountingNumber: '',
                    reminder1: '',
                    reminder2: '',
                    minimumStock: '',
                    allowNotification: '',
                    statusId: '',
                    photo: '',
                }
            }
        },
        created(){
            let self = this

            //get categories list
            get(api_path + 'storage/itemCategory/list')
                .then((res) => {
                    self.categories = res.data.categories.data
                })

            //get item types list
            get(api_path + 'storage/itemType/list')
                .then((res) => {
                    self.types = res.data.types.data
                })

            //get units list
            get(api_path + 'storage/unit/list')
                .then((res) => {
                    self.units = res.data.units.data
                })

            //get status list
            get(api_path + 'storage/status/list')
                .then((res) => {
                    self.statuses = res.data.status.data
                })

            //get item list
            get(api_path + 'storage/item/list?'+'typeCode=C'+'&accNo=1234')
                .then((res) => {
                    if (!res.data.isFailed) {
                        if (res.data.items.data) {
                            self.items = res.data.items.data
                        }
                    }
                })

        },
        methods: {
            insertItemPhoto(e){
                let self = this
                self.formObject.photo = e.target.files[0]
            },
            createItem(){
                let self = this
            }
        }
    }
</script>