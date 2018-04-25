<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-30 ">
            <div class="card card-default card-bordered border-solid-grey">
                <div class="card-block">
                    <div class="scrollable">
                        <div style="height: 700px;">
                            <div class="talbe-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-master-ligher">
                                    <tr>
                                        <th>No.</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Min. Stock</th>
                                        <th>Item Code</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(inventory,index) in generalInventories">
                                        <td>{{parseInt(index)+1}}</td>
                                        <td>{{inventory.quantity}}</td>
                                        <td>{{inventory.unitFormat}}</td>
                                        <td>{{inventory.minStock}}</td>
                                        <td>{{inventory.itemCode}}</td>
                                        <td>{{inventory.itemName}}</td>
                                        <td>{{inventory.itemCategory}}</td>
                                        <td>{{inventory.priceSale}}</td>
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
            return {}
        },
        created(){
            let self = this

            this.$store.dispatch({
                type: 'generalInventory/getDataOnCreate'
            })

        },
        computed: {
            ...mapState('generalInventory',{
                generalInventories:'generalInventories'
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


            }
        }
    }
</script>