<template>
    <div class="row">
        <div class="col-lg-6 m-b-10">
            <div style="padding-top: 20px">
                <h4 class="text-master" v-if="isSearchingItem"> Searching item.. Please wait..</h4>

                <h4 class="text-master" v-if="items.length>0"></h4>
                <h4 class="text-master" v-else="">No Items Found</h4>

            </div>
        </div>
        <div class="col-lg-5 m-b-10" style="margin-top: 20px;margin-right: -20px">
            <!--<input type="text" placeholder="Search Items" class="form-control" id="search-items-box">-->
            <div class="input-group">
                <input type="text" style="height: 40px;" class="form-control" id="search-items-box"
                       placeholder="Search Item Name / Item Code"
                       @keyup="searchItemsOnTyping()"
                       v-model="searchText"
                >
                <span class="input-group-addon master"><i
                        class="fa fa-search cursor" @click="searchItems()"></i></span>
            </div>
            <p class="pull-right" style="padding-top: 3px"><i class="fa fa-info"></i> Sometimes search need to be
                triggered on <i class="fa fa-search"></i> button click </p>
        </div>
        <div class="col-lg-1 m-b-10" style="margin-top: 25px">
            <div class="btn btn-default" @click="goToCartPage()">
                <i class="fa fa-shopping-cart fs-18 cursor"></i>
                <span class="bubble">{{totalItemInCart}}</span>
            </div>

        </div>
        <div class="col-lg-3 col-sm-6 d-flex-not-important flex-column filter-item-item"
             v-for="(item,index) in items">
            <!-- START ITEM -->

            <div class="card card-default card-bordered">
                <div class="card-block">
                    <div class="storage-item-container">
                        <div class="storage-item">
                            <img :src="'/images/storage/items/'+item.photo" height="120px"
                                 style="max-width: 200px;object-fit: cover"
                                 alt="No Image Found" class="img-responsive">
                            <h5 class="text-primary bold overflow-ellipsis">{{item.name}}</h5>
                            <p>{{item.itemCode}}</p>
                        </div>
                    </div>
                    <div class="bg-primary text-center cursor" @click="attemptAddItemToCart(item.id)">
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
    import {mapGetters, mapState} from 'vuex'
    import InfiniteLoading from 'vue-infinite-loading';
    export default{
        components: {
            InfiniteLoading,
        },
        data(){
            return {
                sortStatusId: '',
                sortCategoryCode: '',
                sortTypeCode: '',
                searchText: '',
                delayTimer: null // use for search on finish typing at searchItemsOnTyping() method
            }
        },
        computed: {
            ...mapState('shop', {
                items: 'items',
                isSearchingItem: 'isSearchingItem',
                totalItemInCart: 'totalItemInCart'
            })
        },

        created(){
            let self = this

        },
        methods: {
            infiniteHandler($state) { //getting item list data from server using vue-infinit-scroll

                let self = this

                let shopVuexState = this.$store.state.shop

                if (shopVuexState.paginationMeta.current_page >= shopVuexState.paginationMeta.total_pages && shopVuexState.paginationMeta.current_page != '') {

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


                    let nextPage = shopVuexState.paginationMeta.current_page + 1

                    //get next page
                    get(api_path + 'storage/requisition/shop/item/list?' + param + '&page=' + nextPage)
                        .then((res) => {
                            if (!res.data.isFailed) {
                                if (res.data.items.data) {

                                    //insert items
                                    let itemsData = res.data.items.data
                                    if (itemsData) {
                                        shopVuexState.items = shopVuexState.items.concat(itemsData)
                                    }

                                    //insert pagination
                                    shopVuexState.paginationMeta = res.data.items.meta.pagination

                                    $state.loaded();

                                    if (shopVuexState.items.length === shopVuexState.paginationMeta.total) {
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
            searchItems(){
                let self = this

                let shopVuexState = this.$store.state.shop
                shopVuexState.isSearchingItem = true

                this.$store.commit({
                    type: 'shop/searchItems',
                    searchText: self.searchText
                })

            },
            searchItemsOnTyping(){
                let self = this

                clearTimeout(self.delayTimer) // clear delay timer wait for user to finish typing
                self.delayTimer = setTimeout(() => {

                    self.searchItems() // call searchItems function()

                }, 500) //delay 0.5 second

            },
            attemptAddItemToCart(itemId){

                //call vuex actions to show modal and get item detail
                this.$store.dispatch({
                    type: 'shop/attemptAddItemToCart',
                    id: itemId
                })

            },
            goToCartPage(){
                window.open('/storage/requisition/cart')
            }
        },
        mounted(){

        }

    }
</script>