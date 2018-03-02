<template>
    <div class="row">
        <div class="col-lg-6 m-b-10"></div>
        <div class="col-lg-6 m-b-10" style="margin-top: 20px">
            <!--<input type="text" placeholder="Search Items" class="form-control" id="search-items-box">-->
            <div class="input-group">
                <input type="text" style="height: 40px;" class="form-control" id="search-items-box"
                       placeholder="Search Item Name / Item Code"
                       v-model="searchText"
                >
                <span class="input-group-addon master"><i
                        class="fa fa-search cursor"></i></span>
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 d-flex-not-important flex-column filter-item-item"
             v-for="(item,index) in items">
            <!-- START ITEM -->

            <div class="card card-default card-bordered">
                <div class="card-block">
                    <div class="storage-item-container">
                        <div class="storage-item">
                            <img :src="'/images/storage/items/'+item.photo" height="120px" alt="No Image Found">
                            <h4 class="text-primary bold">{{item.name}}</h4>
                            <p>{{item.itemCode}}</p>
                        </div>
                    </div>
                    <div class="bg-primary text-center cursor">
                        <h5 class="text-white bold">Add to Request</h5>
                    </div>
                </div>
            </div>
            <!-- END ITEM -->
        </div>
        <infinite-loading @infinite="infiniteHandler" spinner="waveDots"
                          ref="infiniteLoading">
                                        <span slot="no-more">
                                          <!--There is no more Items-->
                                        </span>
        </infinite-loading>

    </div>
</template>

<script type="text/javascript">
    import {get} from '../../../../helpers/api'
    import {api_path} from '../../../../helpers/const'
    import InfiniteLoading from 'vue-infinite-loading';
    export default{
        components: {
            InfiniteLoading,
        },
        data(){
            return {
                items: [],
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
                sortTypeCode: '',
                searchText:''
            }
        },
        created(){
            let self = this

            //get data on create
//            get(api_path + 'storage/item/list')
//                .then((res) => {
//                        if (!res.data.isFailed) {
//                            if (res.data.items.data) {
//
//                                //insert items
//                                let itemsData = res.data.items.data
//                                if (itemsData) {
//                                    self.items = self.items.concat(itemsData)
//                                }
//
//                                //insert pagination
//                                self.paginationMeta = res.data.items.meta.pagination
//                            }
//                        }
//                    }
//                )


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
                    get(api_path + 'storage/requisition/shop/item/list?' + param + '&page=' + nextPage)
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
        },
        mounted(){

        }

    }
</script>