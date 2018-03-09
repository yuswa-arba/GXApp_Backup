<template>
    <div class="modal fade" id="modal-select-supplier" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="closeModal()">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <p class="text-left p-b-5 fs-16">Select Supplier</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <input type="text" style="height: 40px;"
                                       class="form-control"
                                       id="search-supplier-box"
                                       @keyup.enter="searchSupplier()"
                                       placeholder="Search Supplier"
                                       v-model="searchSupplierText"
                                >
                                <span class="input-group-addon primary" @click="searchSupplier()"><i
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
                                                             @click="selectSupplier(supplier)"
                                                             v-for="(supplier,index) in suppliers">

                                                            <div class="row">
                                                                <div class="col-lg-3">
                                                                    <img :src="'/images/suppliers/logo/'+supplier.logo"
                                                                         height="50px" alt="No Image">
                                                                </div>
                                                                <div class="col-lg-5">
                                                                    <p class="text-black bold m-b-0 fs-16">
                                                                        {{supplier.name}}</p>
                                                                    <p>{{supplier.contactPerson1}}</p>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <p>{{supplier.country}},{{supplier.city}}</p>
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
                searchSupplierText: ''
            }
        },
        created(){
        },
        computed: {
            ...mapState('purchaseOrder', {
                suppliers: 'suppliers'
            })
        },
        mounted(){

        },

        methods: {
            closeModal(){
                $('#modal-select-supplier').modal("toggle"); // close modal
            },
            searchSupplier(){
                let self = this
                self.$store.commit({
                    type: 'purchaseOrder/searchSupplier',
                    searchSupplierText: self.searchSupplierText
                })
            },
            selectSupplier(supplier){

                let self  = this

                let purchaseOrderVuexState = this.$store.state.purchaseOrder
                purchaseOrderVuexState.selectedSupplier = supplier

                // Insert to PO Form
                purchaseOrderVuexState.POFormObject.supplierId = supplier.id
                purchaseOrderVuexState.POFormObject.contactPerson = supplier.contactPerson1
                purchaseOrderVuexState.POFormObject.contactNumber = supplier.mobileNumber1


                self.closeModal()


            }
        },
    }
</script>