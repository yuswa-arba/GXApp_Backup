<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <div class="row">
                <div class="col-lg-4">
                    <h4 class="text-master" v-if="isSearchingPO">Searching Purchase Order.. Please Wait..</h4>

                    <h4 class="text-master" v-if="purchaseOrders.length>0"></h4>
                    <h4 class="text-master" v-else-if="isSearchingPO"></h4>
                    <h4 class="text-master" v-else="">No Purchase Order Found</h4>
                </div>
                <div class="col-lg-3"></div>
                <div class="col-lg-5">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="input-group m-l-10 pull-right" style="width:300px">
                                <input type="text" style="height: 40px;"
                                       class="form-control text-black"
                                       v-model="searchText"
                                       @keyup="emptySearchPO()"
                                       @keyup.enter="searchPurchaseOrder()"
                                       placeholder="Search PO / Approval / Supplier / Warehouse ">

                                <span class="input-group-addon primary cursor"
                                      @click="searchPurchaseOrder()">
                                    <i class="fa fa-search cursor"></i>
                                </span>
                            </div>

                        </div>
                        <div class="col-lg-5">
                            <select class="btn btn-outline-primary m-l-10 h-35 pull-right"
                                    style="width: 180px"
                                    @change="sortPurchaseOrders()"
                                    v-model="sortStatus">
                                <option value="">All</option>
                                <option :value="status.id" v-for="status in purchaseOrderStatuses">{{status.name}}</option>
                            </select>
                        </div>
                    </div>



                </div>
            </div>

            <div class="card card-default card-bordered border-solid-grey m-t-20"
                 v-for="(purchaseOrder,index) in purchaseOrders">

                <div class="card-block no-padding">
                    <div class="col-lg-12 border-bottom-grey" style="background:#fafafa;">
                        <div class="row">
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Purchase Order No.</p>
                                <p class="text-black fs-18 m-b-10">{{purchaseOrder.purchaseOrderNumber}}</p>

                                <p class="text-uppercase m-b-0">Approval No.</p>
                                <p class="text-primary fs-16 m-b-10 cursor" v-if="purchaseOrder.withRequisition"
                                   @click="goToApprovalDetail(purchaseOrder.approvalNumber)">
                                    {{purchaseOrder.approvalNumber}}</p>
                                <p v-else="">-</p>
                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Date</p>
                                <p class="text-black fs-16 m-b-10">{{purchaseOrder.date}}</p>

                                <p class="text-uppercase m-t-10 m-b-0">Status</p>
                                <p class="text-black fs-14 m-b-10">{{purchaseOrder.status}}</p>
                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Supplier Details</p>
                                <p class="text-black fs-14 m-b-0">{{purchaseOrder.supplierName}}</p>
                                <p class="text-black fs-14 m-b-0"><i class="fa fa-user"></i>
                                    {{purchaseOrder.contactPerson}}</p>
                                <p class="text-black fs-14 m-b-0"><i class="fa fa-mobile"></i>
                                    {{purchaseOrder.contactNumber}}</p>
                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Ship To</p>
                                <p class="text-black fs-14 m-b-0">{{purchaseOrder.warehouseName}}</p>
                                <p class="text-black fs-14 m-b-0"><i class="fa fa-user"></i>
                                    {{purchaseOrder.recipientName}}</p>
                                <p class="text-black fs-14 m-b-0"><i class="fa fa-mobile"></i>
                                    {{purchaseOrder.recipientNumber}}</p>
                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Notes</p>
                                <p class="text-black fs-14 m-b-10">{{purchaseOrder.notes}}</p>
                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20 no-padding">
                                <button class="btn btn-primary m-t-10 m-r-5"
                                        @click="showPurchaseOrderDetail(purchaseOrder.id)"><i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <infinite-loading @infinite="infiniteHandler"
                          spinner="waveDots"
                          class="margin-center"
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
                sortStatus: '',
                searchText:''
            }
        },
        created(){
            // get necessary data on create for this page
            this.$store.dispatch({
                type: 'entry/getDataOnCreate'
            })

        },
        computed: {
            ...mapState('entry', {
                isSearchingPO: 'isSearchingPO',
                purchaseOrderStatuses: 'purchaseOrderStatuses',
                purchaseOrders: 'purchaseOrders'
            })
        },
        methods:{
            infiniteHandler($state) { //getting item list data from server using vue-infinit-scroll

                let self = this

                let entryVuexState = this.$store.state.entry

                if (entryVuexState.paginationMeta.current_page >= entryVuexState.paginationMeta.total_pages && entryVuexState.paginationMeta.current_page != '') {

                    $state.complete()

                } else {

                    let nextPage = entryVuexState.paginationMeta.current_page + 1

                    //get next page
                    get(api_path + 'storage/admin/purchaseOrder/list?page=' + nextPage + '&sortStatus=' + self.sortStatus)
                        .then((res) => {
                            if (!res.data.isFailed) {
                                if (res.data.purchaseOrders.data) {

                                    //insert purchaseOrders
                                    let purchaseOrdersData = res.data.purchaseOrders.data
                                    if (purchaseOrdersData) {
                                        entryVuexState.purchaseOrders = entryVuexState.purchaseOrders.concat(purchaseOrdersData)
                                    }

                                    //insert pagination
                                    entryVuexState.paginationMeta = res.data.purchaseOrders.meta.pagination

                                    $state.loaded();

                                    if (entryVuexState.purchaseOrders.length === entryVuexState.paginationMeta.total) {
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
            sortPurchaseOrders(){
                let self = this

                let entryVuexState = this.$store.state.entry
                entryVuexState.isSearchingPO = true

                this.$store.commit({
                    type: 'entry/getPurchaseOrderList',
                    sortStatus: self.sortStatus
                })

            },
            emptySearchPO(){ // if empty get all data again
                let self = this
                if(self.searchText==''){
                    self.sortPurchaseOrders()
                }
            },
            searchPurchaseOrder(){
                let self = this

                this.$store.commit({
                    type: 'entry/searchPurchaseOrder',
                    searchText: self.searchText
                })

            },
            showPurchaseOrderDetail(purchaseOrderId){
                this.$router.push({name: 'PODetail', params: {id: purchaseOrderId}})
            },

            goToApprovalDetail(approvalNo){
                this.$router.push({name:'approvalDetail',params:{approvalNo:approvalNo}})
            }
        }
    }
</script>