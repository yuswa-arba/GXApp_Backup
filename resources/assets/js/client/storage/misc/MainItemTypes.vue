<template>
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-4 m-b-10">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block">
                        <input type="text" style="height: 40px;" class="form-control" id="search-types-box"
                               placeholder="Search Types"
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
                                        <tr class="filter-item-types"
                                            :class="{'bg-danger-lighter':type.isDeleted}"
                                            v-for="(type,index) in itemTypes">
                                            <td>{{type.code}}</td>
                                            <td>
                                                <span v-if="!type.editing">{{type.name}}</span>
                                                <input v-else=""
                                                       :name="'typeName'+type.code"
                                                       :value="type.name"
                                                       type="text"
                                                       class="form control">
                                            </td>
                                            <td>
                                                <div v-if="type.isDeleted==0">
                                                    <i class="fa fa-times text-danger cursor fs-16"
                                                       @click="deleteType(type.code,index)"></i>
                                                    &nbsp;&nbsp;
                                                    <i class="fa fa-pencil text-primary cursor fs-16"
                                                       v-if="!type.editing"
                                                       @click="attemptUpdateType(index)"></i>
                                                    <span class="fs-12 text-danger cursor"
                                                          v-else=""
                                                          @click="saveUpdateType(type.code,index)">
                                                        DONE
                                                    </span>
                                                </div>
                                                <div v-else="">
                                                    <span class="fs-12 text-info cursor" @click="undoDeleteType(type.code,index)">
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
                        <form id="item-type-form">
                            <h4>Item Type Form</h4>
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
                                    <button class="btn btn-complete pull-right" type="button" @click="createType()">
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
                itemTypes: [],
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
            get(api_path + 'storage/itemType/list')
                .then((res) => {

                    if (!res.data.isFailed) {
                        self.itemTypes = res.data.types.data
                    }

                })
                .catch((err) => {
                })

        },
        methods: {
            createType(){

                let self = this

                if (self.formObject.code && self.formObject.name) {

                    post(api_path + 'storage/create/itemType', self.formObject)
                        .then((res) => {

                            if (!res.data.isFailed) {

                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: 'New type created successfully',
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();

                                //push to array
                                if (res.data.itemType.data) {
                                    self.itemTypes.push(res.data.itemType.data)
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
            attemptUpdateType(index){

                let self = this
                self.itemTypes[index].editing = true
            },
            saveUpdateType(code, index){

                let self = this

                let typeName = $('input[name="' + 'typeName' + code + '"]').val()

                if (typeName) {

                    post(api_path + 'storage/update/itemType', {code: code, name: typeName})
                        .then((res) => {

                            if (!res.data.isFailed) {

                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: res.data.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();

                                self.itemTypes[index].name = typeName
                                self.itemTypes[index].editing = false

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

                    self.itemTypes[index].editing = false
                }
            },
            deleteType(code, index){
                let self = this
                if (code) {
                    if (confirm('Are you sure you want to delete this type?')) {
                        post(api_path + 'storage/delete/itemType', {code: code})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.itemTypes[index].isDeleted = 1

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
            undoDeleteType(code,index){
                let self = this
                if(code){
                    if(confirm("Undo delete this type?")){
                        post(api_path + 'storage/undoDelete/itemType', {code: code})
                            .then((res) => {
                                if (!res.data.isFailed) {

                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: res.data.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'info'
                                    }).show();

                                    self.itemTypes[index].isDeleted = 0

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