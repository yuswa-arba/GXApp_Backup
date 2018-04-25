<template>
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-12 m-b-25">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-header">
                        <p class="card-title text-uppercase text-black" style="opacity: 1">Item Form</p>
                    </div>
                    <div class="card-block">
                        <div class="row" @keyup.enter="createItem()">
                            <div class="col-lg-4">
                                <div class="form-group-attached">
                                    <div class="form-group form-group-default required">
                                        <label> Name </label>
                                        <input type="text" class="form-control" v-model="formObject.name">
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label> Unit </label>
                                        <select v-model="formObject.unitId" class="form-control">
                                            <option :value="unit.id" v-for="unit in units">{{unit.format}} -
                                                {{unit.description}} ({{unit.uomTypeName}})
                                            </option>
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
                                            <option :value="category.code" v-for="category in categories">
                                                {{category.name}} ({{category.code}})
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label>Accounting Number</label>
                                        <input v-model="formObject.accountingNumber" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
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
                                            <option :value="status.id" v-for="status in statuses">{{status.name}}
                                            </option>
                                        </select>
                                    </div>


                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group form-group-default">
                                    <label>Photo</label>
                                    <input name="itemPhoto" type="file" class="form-control"
                                           @change="insertItemPhoto($event)">
                                </div>
                                <div class="form-group">
                                    <div class="checkbox check-success ">
                                        <input type="checkbox"
                                               value="1"
                                               name="requiresTesting"
                                               id="requiresTesting"
                                               v-model="formObject.requiresTesting">
                                        <label for="requiresTesting">Requires Testing</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="checkbox check-success ">
                                        <input type="checkbox"
                                               name="requiresSN"
                                               value="1"
                                               id="requiresSN"
                                               v-model="formObject.requiresSerialNumber">
                                        <label for="requiresSN">Requires Serial Number</label>
                                    </div>
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
            <div class="col-lg-12 m-b-10">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" style="height: 40px;" class="form-control" id="search-items-box"
                                       placeholder="Search Items">
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <select class="btn btn-outline-primary h-35 w-100 pull-right"
                                                v-model="sortStatusId" @change="changeFilter()">
                                            <option value="" disabled selected hidden>Sort Status</option>
                                            <option value="">All</option>
                                            <option :value="status.id" v-for="status in statuses">{{status.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select class="btn btn-outline-primary h-35 w-100 pull-right"
                                                v-model="sortCategoryCode" @change="changeFilter()">
                                            <option value="" disabled selected hidden>Sort Category</option>
                                            <option value="">All</option>
                                            <option :value="category.code" v-for="category in categories">
                                                {{category.name}} ({{category.code}})
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select class="btn btn-outline-primary h-35 w-100 pull-right"
                                                v-model="sortTypeCode" @change="changeFilter()">
                                            <option value="" disabled selected hidden>Sort Type</option>
                                            <option value="">All</option>
                                            <option :value="type.code" v-for="type in types">{{type.name}}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="scrollable">
                            <div class="" style="height:700px">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="bg-master-lighter">
                                        <tr>
                                            <th class="text-black">ID</th>
                                            <th></th>
                                            <th class="text-black">Name</th>
                                            <th class="text-black">Item Code</th>
                                            <th class="text-black">Unit</th>
                                            <th class="text-black">Reminder 1,2</th>
                                            <th class="text-black">Min. Stock</th>
                                            <th class="text-black">Status</th>
                                            <th class="text-black">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item,index) in items" class="filter-item-item">
                                            <td>{{item.id}}</td>
                                            <td>
                                                <div v-if="!item.editing && item.photo" class="cursor"
                                                     @click="viewImage('/images/storage/items/'+item.photo)">
                                                    <img :src="'/images/storage/items/'+item.photo" height="70px"
                                                         alt="">
                                                </div>
                                            </td>
                                            <td>{{item.name}}</td>
                                            <td>{{item.itemCode}}</td>
                                            <td>{{item.unitFormat}}</td>
                                            <td>{{item.reminder1}},{{item.reminder2}}</td>
                                            <td>{{item.minimumStock}}</td>
                                            <td>{{item.statusName}}</td>
                                            <td>
                                                <div v-if="item.isDeleted==0">
                                                    <i class="fa fa-times text-danger cursor fs-16"
                                                       @click="deleteItem(item.id,index)"></i>
                                                    &nbsp;&nbsp;
                                                    <!--<i class="fa fa-pencil text-primary cursor fs-16"-->
                                                    <!--v-if="!item.editing"-->
                                                    <!--@click="attemptUpdateItem(index)"></i>-->
                                                    <!--<span class="fs-12 text-danger cursor"-->
                                                    <!--v-else=""-->
                                                    <!--@click="saveUpdateItem(item.id,index)">-->
                                                    <!--DONE-->
                                                    <!--</span>-->
                                                </div>
                                                <div v-else="">
                                                    <span class="fs-12 text-info cursor"
                                                          @click="undoDeleteItem(item.id,index)">
                                                        UNDELETE
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <infinite-loading @infinite="infiniteHandler" spinner="waveDots"
                                                      ref="infiniteLoading">
                                        <span slot="no-more">
                                          There is no more Items
                                        </span>
                                    </infinite-loading>
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
    import InfiniteLoading from 'vue-infinite-loading';
    export default{
        components: {
            InfiniteLoading,
        },
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
                    reminder1: 0,
                    reminder2: 0,
                    minimumStock: 0,
                    allowNotification: '',
                    statusId: '',
                    requiresSerialNumber: 0,
                    requiresTesting: 0,
                    photo: '',
                },
                paginationMeta: {
                    count: '',
                    current_page: '',
                    links: [],
                    per_page: '',
                    total: '',
                    total_pages: ''
                },
                sortStatusId: '',
                sortCategoryCode: '',
                sortTypeCode: ''
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
            //            get(api_path + 'storage/item/list')
            //                .then((res) => {
            //                    if (!res.data.isFailed) {
            //                        if (res.data.items.data) {
            //
            //                            //insert items
            //                            self.items = res.data.items.data
            //
            //                            //insert pagination
            //                            self.paginationMeta = res.data.items.meta.pagination
            //
            //                        }
            //                    }
            //                })

        },
        methods: {
            infiniteHandler($state) { //getting item list data from server using vue-infinit-scroll

                let self = this

                if (self.paginationMeta.current_page >= self.paginationMeta.total_pages && self.paginationMeta.current_page != '') {

                    $state.complete()

                } else {

                    let param = '';

                    if (self.sortStatusId) { // sort by status
                        if (param != '') {
                            param += '&'
                        }
                        param += 'status=' + self.sortStatusId
                    }

                    if (self.sortCategoryCode) { // sort by category
                        if (param != '') {
                            param += '&'
                        }
                        param += 'categoryCode=' + self.sortCategoryCode
                    }

                    if (self.sortTypeCode) { // sort by type
                        if (param != '') {
                            param += '&'
                        }
                        param += 'typeCode=' + self.sortTypeCode
                    }


                    let nextPage = self.paginationMeta.current_page + 1

                    //get next page
                    get(api_path + 'storage/item/list?' + param + '&page=' + nextPage)
                        .then((res) => {
                            if (!res.data.isFailed) {
                                if (res.data.items.data) {

                                    //insert items
                                    let itemsData = res.data.items.data
                                    if (itemsData) {
                                        self.items = self.items.concat(itemsData)
                                    }

                                    //insert pagination
                                    self.paginationMeta = res.data.items.meta.pagination

                                    $state.loaded();

                                    if (self.items.length === self.paginationMeta.total) {
                                        $state.complete()
                                    }

                                } else {
                                    $state.complete()
                                }
                            } else {
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'danger'
                                }).show();
                                $state.complete()
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
                            $state.complete()
                        })
                }

            },
            changeFilter(){ // update data by sorted data , infiniteHandler() method will be called again

                let self = this

                self.items = []

                self.paginationMeta = {
                    count: '',
                    current_page: '',
                    links: [],
                    per_page: '',
                    total: '',
                    total_pages: ''
                }

                self.$nextTick(() => {
                    self.$refs.infiniteLoading.$emit('$InfiniteLoading:reset')
                });

            },
            insertItemPhoto(e){
                let self = this
                self.formObject.photo = e.target.files[0]
            },
            createItem(){
                let self = this

                if (
                    self.formObject.name &&
                    self.formObject.unitId &&
                    self.formObject.itemTypeCode &&
                    self.formObject.categoryCode &&
                    self.formObject.accountingNumber
                ) {

                    post(api_path + 'storage/create/item', objectToFormData(self.formObject))
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
                                if (res.data.item.data) {
                                    self.items.push(res.data.item.data)
                                }

                                //reset form
                                self.formObject = {
                                    name: '',
                                    unitId: '',
                                    itemTypeCode: '',
                                    categoryCode: '',
                                    accountingNumber: '',
                                    reminder1: 0,
                                    reminder2: 0,
                                    minimumStock: 0,
                                    allowNotification: '',
                                    statusId: '',
                                    requiresSerialNumber: 0,
                                    requiresTesting: 0,
                                    photo: '',
                                }

                                $('input[name="itemPhoto"]').val('')

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
                        message: "Form is invalid",
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }
            },
            deleteItem(id, index){
                let self = this
                if (id) {
                    if (confirm('Are you sure to delete this item?')) {
                        post(api_path + 'storage/delete/item', {id: id})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.items[index].isDeleted = 1

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
            undoDeleteItem(id, index){
                let self = this
                if (id) {
                    if (confirm('Undo delete this item?')) {
                        post(api_path + 'storage/undoDelete/item', {id: id})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.items[index].isDeleted = 0

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
                window.open(url, '_blank')
            }
        }
    }
</script>