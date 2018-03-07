<template>
    <div class="row">
        <div class="col-lg-12" style="margin-top: 50px">
            <div class="row">
                <div class="col-lg-4">
                    <div class="col-lg-4">
                        <select class="btn btn-outline-primary h-35 pull-left"
                                style="width: 180px"
                                @change="sortRequisition()"
                                v-model="sortApproval">
                            <option value="">All</option>
                            <option :value="approval.id" v-for="approval in approvalStatuses">{{approval.name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4">

                    <h4 class="text-master" v-if="isSearchingRequisition">Searching Requisition.. Please Wait..</h4>

                    <h4 class="text-master" v-if="requisitions.length>0">.</h4>
                    <h4 class="text-master" v-else="">No Requisition Found</h4>

                </div>
                <div class="col-lg-4">

                    <div class="input-group m-b-20">
                        <input type="text" style="height: 40px;" class="form-control" id="search-requisition-box"
                               placeholder="Search Requisition Number"
                               v-model="searchText"
                        >
                        <span class="input-group-addon primary" @click="searchRequisition()"><i
                                class="fa fa-search cursor"></i></span>
                    </div>

                </div>
            </div>
            <div class="card card-default card-bordered border-solid-grey"
                 v-for="requisition in requisitions">
                <div class="card-block no-padding">
                    <div class="col-lg-12 border-bottom-grey" style="background:#fafafa;">
                        <div class="row">
                            <div class="col-lg-3 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Requisition No.</p>
                                <p class="text-black fs-18 m-b-10">{{requisition.requisitionNumber}}</p>

                                <p class="text-uppercase m-b-0">Approval No.</p>
                                <p class="text-black fs-16 m-b-10" v-if="requisition.approvalNumber">
                                    {{requisition.approvalNumber}}</p>
                                <p v-else="">-</p>

                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Requested At</p>
                                <p class="text-black fs-16 m-b-10">{{requisition.requestedAt}}</p>

                                <p class="text-uppercase m-b-0">Date Needed By</p>
                                <p class="text-black fs-16 m-b-10">{{requisition.dateNeededBy}}</p>

                            </div>
                            <div class="col-lg-3 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Description</p>
                                <p class="text-black fs-14 m-b-10">{{requisition.description}}</p>
                            </div>
                            <div class="col-lg-3 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Approval Status</p>
                                <p class="text-black fs-14 m-b-10">{{requisition.approvalName}}</p>
                            </div>
                            <div class="col-lg-1 m-t-20 m-b-20">
                                <button class="btn btn-outline-primary m-t-10 m-r-20">Details</button>
                            </div>
                        </div>
                    </div>
                    <div class="p-t-10"></div>
                    <div class="col-lg-12" v-for="item in requisition.requisitionItems.data">
                        <div class="row border-bottom-grey p-t-10 p-b-10">
                            <div class="col-lg-3 p-t-10">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="cursor" @click="viewImage('/images/storage/items/'+item.itemPhoto)" style="margin-top:-10px">
                                            <img :src="'/images/storage/items/'+item.itemPhoto" height="60px" alt="No Image Found">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-black fs-16 m-b-0">{{item.itemName}}</p>
                                        <p class="no-padding fs-14">{{item.itemCode}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 p-t-10">
                                <p class="fs-16 m-b-0">Amount: <span class="text-black">{{item.amount}}</span></p>
                                <p class=" fs-16 m-b-0">Unit: <span class="text-black">{{item.itemUnit}}</span></p>
                            </div>
                            <div class="col-lg-3 p-t-10">
                                <p class="text-uppercase m-b-0">Notes</p>
                                <p class="text-black fs-16 m-b-10" v-if="item.notes">{{item.notes}}</p>
                                <p v-else="">-</p>
                            </div>
                            <div class="col-lg-3 p-t-10">
                                <p>
                                    <span class="text-uppercase">Approved: </span>
                                    <i class="fa fa-check text-success fs-16" v-if="item.isApproved"></i>
                                    <i class="fa fa-times text-danger fs-16" v-else=""></i>
                                </p>
                                <div v-if="item.updatedAt&&item.updatedBy">
                                    <p class="text-uppercase m-b-0">Latest Update</p>
                                    <p class="text-black fs-16 m-b-10">
                                        Updated at {{item.updatedAt}} by {{item.updatedBy}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-1 p-t-10"></div>
                        </div>

                    </div>
                </div>
            </div>
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
                searchText:'',
                sortApproval:''
            }
        },
        created(){
            // get necessary data on create for this page
            this.$store.dispatch({
                type:'history/getDataOnCreate'
            })
        },
        computed: {
            ...mapState('history', {
                requisitions: 'requisitions',
                approvalStatuses:'approvalStatuses',
                isSearchingRequisition:'isSearchingRequisition'
            })
        },
        methods: {
            infiniteHandler($state) { //getting item list data from server using vue-infinit-scroll

                let self = this

                let historyVuexState = this.$store.state.history

                if (historyVuexState.paginationMeta.current_page >= historyVuexState.paginationMeta.total_pages && historyVuexState.paginationMeta.current_page != '') {

                    $state.complete()

                } else {

                    let nextPage = historyVuexState.paginationMeta.current_page + 1

                    //get next page
                    get(api_path + 'storage/requisition/history?page=' + nextPage + '&sortApproval='+ self.sortApproval)
                        .then((res) => {
                            if (!res.data.isFailed) {
                                if (res.data.requisitions.data) {

                                    //insert requisitions
                                    let requisitionsData = res.data.requisitions.data
                                    if (requisitionsData) {
                                        historyVuexState.requisitions = historyVuexState.requisitions.concat(requisitionsData)
                                    }

                                    //insert pagination
                                    historyVuexState.paginationMeta = res.data.requisitions.meta.pagination

                                    $state.loaded();

                                    if (historyVuexState.requisitions.length === historyVuexState.paginationMeta.total) {
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
            viewImage(url){
                window.open(url, '_blank')
            },
            searchRequisition(){

                let self = this
                this.$store.commit({
                    type:'history/searchRequisition',
                    searchText:self.searchText
                })

            },
            sortRequisition(){
                let self = this
                this.$store.commit({
                    type:'history/getRequisitionHistory',
                    sortApproval:self.sortApproval
                })
            },
        }
    }
</script>