<template>
    <div class="modal fade" id="modal-select-warehouse" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="closeModal()">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <p class="text-left p-b-5 fs-16">Select Warehouse</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <input type="text" style="height: 40px;"
                                       class="form-control"
                                       id="search-warehouse-box"
                                       @keyup.enter="searchWarehouse()"
                                       placeholder="Search Warehouse"
                                       v-model="searchWarehouseText"
                                >
                                <span class="input-group-addon primary" @click="searchWarehouse()"><i
                                        class="fa fa-search cursor"></i></span>
                            </div>

                        </div>
                        <div class="col-lg-12">
                            <div class="card no-border">
                                <div class="card-body">
                                    <div class="card card-default">
                                        <div class="card-block no-padding">
                                            <div class="scrollable">
                                                <div style="height: 500px">
                                                    <div class="row">
                                                        <div class="col-lg-12 border-bottom-grey select-hover-warning"
                                                             style="padding: 10px 5px"
                                                             @click="selectWarehouse(warehouse)"
                                                             v-for="(warehouse,index) in warehouses">

                                                            <div class="row">
                                                                <div class="col-lg-5">
                                                                    <p class="text-black bold m-b-0 fs-16">
                                                                        {{warehouse.name}}</p>
                                                                    <p>{{warehouse.address}}</p>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <p>{{warehouse.country}},{{warehouse.city}}</p>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal-dialog -->


</template>

<script>
    import {mapGetters, mapState} from 'vuex'
    export default{
        data(){
            return {
                searchWarehouseText: ''
            }
        },
        created(){
        },
        computed: {
            ...mapState('purchaseOrder', {
                warehouses: 'warehouses'
            })
        },
        mounted(){

        },

        methods: {
            closeModal(){
                $('#modal-select-warehouse').modal("toggle"); // close modal
            },
            searchWarehouse(){
                let self = this
                self.$store.commit({
                    type: 'purchaseOrder/searchWarehouse',
                    searchWarehouseText: self.searchWarehouseText
                })
            },
            selectWarehouse(warehouse){

                let self  = this

                let purchaseOrderVuexState = this.$store.state.purchaseOrder
                purchaseOrderVuexState.selectedWarehouse = warehouse

                // Insert to PO Form
                purchaseOrderVuexState.POFormObject.warehouseId = warehouse.id


                self.closeModal()


            }
        },
    }
</script>