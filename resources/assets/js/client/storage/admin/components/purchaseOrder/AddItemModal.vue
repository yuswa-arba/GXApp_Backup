<template>
    <div class="modal  fade stick-up" id="modal-add-item" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="closeModal()">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <h5 class="text-left dark-title p-b-5">Add Item</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <input type="text" style="height: 40px;"
                                       class="form-control"
                                       id="search-item-box"
                                       @focus="onSearchFocus()"
                                       @keyup.enter="searchItems()"
                                       placeholder="Search Item"
                                       v-model="searchItemText"
                                >
                                <span class="input-group-addon primary" @click="searchItems()" ><i
                                        class="fa fa-search cursor"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-12" v-if="!finishSelectItemToBeInserted">
                            <div class="card no-border">
                                <div class="card-body">
                                    <div class="card card-default">
                                        <div class="card-block no-padding">
                                            <div class="scrollable">
                                                <div :class="{'h-150':items.length>2}">
                                                    <div class="row">
                                                        <div class="col-lg-12 border-bottom-grey padding-10 select-hover-warning"
                                                             @click="selectItemsToBeInserted(item)"
                                                             v-for="(item,index) in items">
                                                            <div class="pull-right">
                                                                <p class="m-b-0 fs-14">Status: {{item.statusName}}</p>
                                                                <p class="fs-14">Unit: {{item.unitFormat}}</p>
                                                            </div>
                                                            <p class="text-black m-b-0 fs-16">{{item.name}}</p>
                                                            <p>{{item.itemCode}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-right m-r-10" v-if="items.length>2">Scroll for more</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="card no-border" v-if="itemToBeInserted.itemDetail.id!=null">
                                <div class="card-block">
                                    <div class="row">
                                        <div class="col-lg-12 bg-master-lighter p-t-10 m-b-10">
                                            <p class="text-black m-b-0 fs-16">{{itemToBeInserted.itemDetail.name}}</p>
                                            <p>{{itemToBeInserted.itemDetail.itemCode}}</p>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="checkbox check-success ">
                                                <input id="hasCustomUnit"
                                                       type="checkbox"
                                                       value="1"
                                                       v-model="itemToBeInserted.hasCustomUnit">
                                                <label for="hasCustomUnit">Has Custom Unit</label>
                                            </div>
                                            <div class="form-group form-group-default required"
                                                 v-if="itemToBeInserted.hasCustomUnit">
                                                <label>Custom Unit</label>
                                                <input type="text" class="form-control" v-model="itemToBeInserted.customUnit">
                                            </div>
                                            <div class="form-group form-group-default required" v-else="">
                                                <label>Unit</label>
                                                <select name="unitFormat" class="form-control" v-model="itemToBeInserted.unitId">
                                                    <option :value="unit.id" v-for="unit in unitOfMeasurements">
                                                        {{unit.description}} / {{unit.format}}
                                                    </option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group form-group-default required">
                                                <label> Amount </label>
                                                <input type="number" class="form-control"
                                                       v-model="itemToBeInserted.amount">
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Price</label>
                                                <input type="text" class="form-control"
                                                       v-model="itemToBeInserted.price">
                                            </div>
                                            <div class="form-group form-group-default required">
                                                <label>Currency</label>
                                                <input type="text" readonly v-model="itemToBeInserted.currencyFormat">
                                            </div>
                                        </div>
                                        <div class="col-lg-12 m-t-10">
                                            <button class="btn btn-primary pull-right" @click="insertItemToPO()">Insert</button>
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
                searchItemText: '',
                finishSelectItemToBeInserted: false
            }
        },
        created(){
            this.setCurrencyBasedOnPOForm()
        },
        computed: {
            ...mapState('purchaseOrder', {
                items: 'items',
                unitOfMeasurements: 'unitOfMeasurements',
                currencies: 'currencies',
                itemToBeInserted: 'itemToBeInserted'
            })
        },
        mounted(){

        },

        methods: {
            setCurrencyBasedOnPOForm(){

                let self = this
                let purchaseOrderVuexState = this.$store.state.purchaseOrder

                purchaseOrderVuexState.itemToBeInserted.currencyFormat = purchaseOrderVuexState.POFormObject.currencyFormat

            },
            closeModal(){
                let self = this
                let purchaseOrderVuexState = this.$store.state.purchaseOrder

                self.searchItemText = '' //reset search value

                purchaseOrderVuexState.items = []//resset items lsit

                purchaseOrderVuexState.itemToBeInserted = { //reset item to be inserted data
                    withRequisitionItem:0,
                    requisitionItemId:'',
                    itemDetail: {},
                    amount:'',
                    hasCustomUnit:0,
                    customUnit:'',
                    unitId:'',
                    unitFormat:'',
                    price:'',
                    currencyFormat:'IDR'
                }

                $('#modal-add-item').modal("toggle"); // close modal

            },
            onSearchFocus(){
                let self = this
                //finish selecting item
                self.finishSelectItemToBeInserted = false
            },
            searchItems(){

                let self = this

                //unfinish selecting item
                self.finishSelectItemToBeInserted = false

                self.$store.commit({
                    type: 'purchaseOrder/searchItems',
                    searchItemText: self.searchItemText
                })

            },
            selectItemsToBeInserted(item){

                let self = this

                //insert to vuex
                let purchaseOrderVuexState = this.$store.state.purchaseOrder
                purchaseOrderVuexState.itemToBeInserted.itemDetail = item
                purchaseOrderVuexState.itemToBeInserted.unitId = item.unitId
                purchaseOrderVuexState.itemToBeInserted.unitFormat = _.find(purchaseOrderVuexState.unitOfMeasurements,{id:item.unitId}).format


                //finish selecting item
                self.finishSelectItemToBeInserted = true

            },
            insertItemToPO(){

                let self = this

                self.searchItemText = '' //reset search value

                self.$store.dispatch({
                    type:'purchaseOrder/insertItemToPO'
                })


            }
        },
    }
</script>