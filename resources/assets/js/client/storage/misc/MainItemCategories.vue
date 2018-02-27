<template>
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-4 m-b-10">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block">
                        <input type="text" style="height: 40px;" class="form-control" id="search-categories-box"
                               placeholder="Search Categories"
                        >
                        <div class="scrollable">
                            <div class="" style="height:700px">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover ">
                                        <thead class="bg-master-lighter">
                                        <tr>
                                            <th class="text-black">Code</th>
                                            <th class="text-black">Name</th>
                                            <th class="text-black">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="filter-item-categories"
                                            :class="{'bg-danger-lighter':category.isDeleted}"
                                            v-for="(category,index) in itemCategories">
                                            <td>{{category.code}}</td>
                                            <td>
                                                <span v-if="!category.editing">{{category.name}}</span>
                                                <input v-else=""
                                                       :name="'categoryName'+category.code"
                                                       :value="category.name"
                                                       type="text"
                                                       class="form control">
                                            </td>
                                            <td>
                                                <div v-if="category.isDeleted==0">
                                                    <i class="fa fa-times text-danger cursor fs-16"
                                                       @click="deleteCategory(category.code,index)"></i>
                                                    &nbsp;&nbsp;
                                                    <i class="fa fa-pencil text-primary cursor fs-16"
                                                       v-if="!category.editing"
                                                       @click="attemptUpdateCategory(index)"></i>
                                                    <span class="fs-12 text-danger cursor"
                                                          v-else=""
                                                          @click="saveUpdateCategory(category.code,index)">
                                                        DONE
                                                    </span>
                                                </div>
                                                <div v-else="">
                                                    <span class="fs-12 text-info cursor" @click="undoDeleteCategory(category.code,index)">
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
                        <form id="item-category-form">
                            <h4>Item Category Form</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Code</label>
                                        <input type="text" class="form-control" name="code" required
                                               v-model="formObject.code">
                                    </div>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" required
                                               v-model="formObject.name">
                                    </div>
                                    <button class="btn btn-complete pull-right" type="button" @click="createCategory()">
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
                itemCategories: [],
                formObject: {
                    code: '',
                    name: ''
                },
                updateFormObject: {
                    code: '',
                    name: ''
                }
            }
        },
        created(){

            let self = this

            //get data on create
            get(api_path + 'storage/itemCategory/list')
                .then((res) => {

                    if (!res.data.isFailed) {
                        self.itemCategories = res.data.categories.data
                    }

                })
                .catch((err) => {
                })

        },
        methods: {
            createCategory(){

                let self = this

                if (self.formObject.code && self.formObject.name) {

                    post(api_path + 'storage/create/itemCategory', self.formObject)
                        .then((res) => {

                            if (!res.data.isFailed) {

                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: 'New category created successfully',
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();

                                //push to array
                                if (res.data.itemCategory.data) {
                                    self.itemCategories.push(res.data.itemCategory.data)
                                }

                                //reset form
                                self.formObject = {
                                    code: '',
                                    name: ''
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
                        message: 'Form cannot be empty',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }
            },
            attemptUpdateCategory(index){

                let self = this
                self.itemCategories[index].editing = true
            },
            saveUpdateCategory(code, index){

                let self = this

                let categoryName = $('input[name="' + 'categoryName' + code + '"]').val()

                if (categoryName) {

                    post(api_path + 'storage/update/itemCategory', {code: code, name: categoryName})
                        .then((res) => {

                            if (!res.data.isFailed) {

                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();

                                self.itemCategories[index].name = categoryName
                                self.itemCategories[index].editing = false

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
                        message: 'Edit canceled.',
                        position: 'top-right',
                        timeout: 0,
                        type: 'danger'
                    }).show();

                    self.itemCategories[index].editing = false
                }
            },
            deleteCategory(code, index){
                let self = this
                if (code) {
                    if (confirm('Are you sure you want to delete this category?')) {
                        post(api_path + 'storage/delete/itemCategory', {code: code})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.itemCategories[index].isDeleted = 1

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
            undoDeleteCategory(code,index){
                let self = this
                if(code){
                    if(confirm("Undo delete this category?")){
                        post(api_path + 'storage/undoDelete/itemCategory', {code: code})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.itemCategories[index].isDeleted = 0

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