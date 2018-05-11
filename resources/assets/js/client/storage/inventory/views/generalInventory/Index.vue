<template>
    <div class="row">
        <div class="col-lg-2 m-t-30">
            <button class="btn btn-success"
                    v-if="selectedItemsIds.length>0"
                    @click="generateQRCode()">
                Generate <i class="fa fa-qrcode fs-16"></i>
            </button>
        </div>
        <div class="col-lg-5 m-t-30">

        </div>
        <div class="col-lg-5 m-t-30">
            <div class="input-group pull-right" style="width:350px">
                <input type="text" style="height: 40px;"
                       id="search-general-item-box"
                       class="form-control text-black"
                       @keyup="emptySearchItem()"
                       @keyup.enter="searchItem()"
                       v-model="searchText"
                       placeholder="Search Item Code / Name / Categories ">

                <span class="input-group-addon primary cursor"
                      @click="searchItem()">
                    <i class="fa fa-search cursor"></i>
                </span>
            </div>
        </div>

        <div class="col-lg-12 m-b-10 m-t-10 ">
            <div class="card card-default card-bordered border-solid-grey">
                <div class="card-block">
                    <div class="scrollable">
                        <div style="height: 700px;">
                            <div class="talbe-responsive">
                                <table class="table table-hover sortable">
                                    <thead class="bg-master-ligher">
                                    <tr>
                                        <th style="width: 30px">
                                            <div class="checkbox check-success ">
                                                <input type="checkbox" id="all-item-cb" @change="checkAllItems()">
                                                <label for="all-item-cb" class="fs-16"></label>
                                            </div>
                                        </th>
                                        <th>No.</th>
                                        <th>Quantity (Unit) </th>
                                        <th>Min. Stock &nbsp;&nbsp;<i class="fa fa-sort fs-16 text-black cursor"></i></th>
                                        <th>Name (Code) &nbsp;&nbsp;<i class="fa fa-sort fs-16 text-black cursor"></i></th>
                                        <th>SN</th>
                                        <th>Category &nbsp;&nbsp;<i class="fa fa-sort fs-16 text-black cursor"></i></th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(inventory,index) in generalInventories" class="filter-general-item">
                                        <td class="td-small-center">
                                            <div class="checkbox check-success ">
                                                <input type="checkbox" :id="'item-cb-'+index"
                                                       @change="toggleItemCb(index,inventory.id)">
                                                <label :for="'item-cb-'+index"></label>
                                            </div>
                                        </td>
                                        <td class="td-small-center">{{parseInt(index)+1}}</td>
                                        <td class="td-small-center"><span class="text-black">{{inventory.quantity}}</span>
                                            ({{inventory.unitFormat}})
                                        </td>
                                        <td class="td-small-center">{{inventory.minStock}}</td>
                                        <td class="td-small-center"><span class="text-black">{{inventory.itemName}}</span> <br>({{inventory.itemCode}})
                                        </td>
                                        <td class="td-small-center">{{inventory.serialNumber}}</td>
                                        <td class="td-small-center">{{inventory.itemCategory}}</td>
                                        <td class="td-small-center"><span class="text-black">{{inventory.priceSale}}</span></td>
                                    </tr>
                                    </tbody>
                                </table>
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
                searchText: '',
                currentSortType: 0
            }
        },
        created(){
            let self = this

            this.$store.dispatch({
                type: 'generalInventory/getDataOnCreate'
            })

        },
        computed: {
            ...mapState('generalInventory', {
                generalInventories: 'generalInventories',
                selectedItemsIds:'selectedItemsIds'
            })
        },
        methods: {
            infiniteHandler($state) { //getting item list data from server using vue-infinit-scroll

                let self = this

                let generalInventoryVuexState = this.$store.state.generalInventory

                if (generalInventoryVuexState.paginationMeta.current_page >= generalInventoryVuexState.paginationMeta.total_pages && generalInventoryVuexState.paginationMeta.current_page != '') {

                    $state.complete()

                } else {

                    let nextPage = generalInventoryVuexState.paginationMeta.current_page + 1

                    //get next page
                    get(api_path + 'storage/inventory/general/list?page=' + nextPage)
                        .then((res) => {
                            if (!res.data.isFailed) {
                                if (res.data.generalInventory.data) {

                                    //insert generalInventories
                                    let generalInventoryData = res.data.generalInventory.data
                                    if (generalInventoryData) {
                                        generalInventoryVuexState.generalInventories = generalInventoryVuexState.generalInventories.concat(generalInventoryData)
                                    }

                                    //insert pagination
                                    generalInventoryVuexState.paginationMeta = res.data.generalInventory.meta.pagination

                                    $state.loaded();

                                    if (generalInventoryVuexState.generalInventories.length === generalInventoryVuexState.paginationMeta.total) {
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
            searchItem(){
                let self = this

                this.$store.commit({
                    type: 'generalInventory/searchItems',
                    text: self.searchText
                })

            },
            emptySearchItem(){

                let self = this
                if (self.searchText == '') {
                    this.$store.commit({
                        type: 'generalInventory/searchItems',
                        text: ''
                    })
                }

            },
            toggleItemCb(index, itemId){

                let self = this
                let generalInventorVuexState = this.$store.state.generalInventory
                let itemCb = $('#item-cb-' + index)

                if (itemCb.prop('checked')) {

                    generalInventorVuexState.selectedItemsIds.push(itemId)//push to array

                } else {

                    let itemIndex = _.findIndex(generalInventorVuexState.selectedItemsIds, (o) => { //get index of this item id
                        return o == itemId
                    })

                    generalInventorVuexState.selectedItemsIds.splice(itemIndex, 1)//remove from array

                    //unchecked all item cb
                    $('#all-item-cb').prop('checked', false)
                    
                }

            },
            checkAllItems(){

                let self = this
                let generalInventoryVuexState = this.$store.state.generalInventory
                let totalItemIds = generalInventoryVuexState.generalInventories.length + 1//total items
                let allItemCb = $('#all-item-cb')

                //reset the first time
                generalInventoryVuexState.selectedItemsIds = []

                if (allItemCb.prop('checked')) { // check all

                    for (let i = 0; i < totalItemIds; i++) {

                        let cb = $('#item-cb-' + i)
                        cb.prop('checked', true)

                        if (i < totalItemIds - 1) { // do not include the last one
                            generalInventoryVuexState.selectedItemsIds.push(generalInventoryVuexState.generalInventories[i].id)
                        }

                    }

                } else { //uncheck all

                    for (let i = 0; i < totalItemIds; i++) {
                        let cb = $('#item-cb-' + i)
                        cb.prop('checked', false)
                    }

                    generalInventoryVuexState.selectedItemsIds = []

                }
            },
            generateQRCode(){

                let generalInventoryVuexState = this.$store.state.generalInventory
                let totalItemIds = generalInventoryVuexState.generalInventories.length + 1//total items

                this.$store.commit({
                    type:'generalInventory/generateQRCode'
                })

                //uncheck all
                for (let i = 0; i < totalItemIds; i++) {
                    let cb = $('#item-cb-' + i)
                    cb.prop('checked', false)
                }

                //unchecked all item cb
                $('#all-item-cb').prop('checked', false)
            }
        }
    }
</script>