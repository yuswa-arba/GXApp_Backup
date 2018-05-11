<template>
    <div class="modal  fade stick-up" id="modal-attempt-insert-to-inventory" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="closeModal()">
                        <i class="pg-close"></i>
                    </button>
                    <br>
                    <br>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="text-left dark-title p-l-0 p-t-0 p-b-5 p-r-0 no-margin"
                                style="line-height: 22px!important;"> {{selectedItemToInsert.itemName}}
                            </h4>
                            <p class="text-left p-b-5">Item Code: {{selectedItemToInsert.itemCode}}</p>
                        </div>
                        <div class="col-lg-6">
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-grey" @click="minusAmount()"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <input type="text"
                                       class="btn text-true-black"
                                       style="width: 60px;border-color: #b7b7b7"
                                       id="item-to-insert-amount"
                                       v-model="selectedItemToInsert.quantity">
                                <button type="button" class="btn btn-grey" @click="plusAmount()"><i
                                        class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div v-if="selectedItemToInsert.requiresSerialNumber">
                                <div class="scrollable">
                                    <div :class="{'h-450':parseInt(selectedItemToInsert.quantity)>10}">
                                        <div class="row" v-for="index in parseInt(selectedItemToInsert.quantity)">
                                            <div class="col-lg-2">
                                                <p class="m-t-5">Item {{parseInt(index)}}</p>
                                            </div>
                                            <div class="col-lg-5">
                                                <div class="form-group">
                                                    <input type="text"
                                                           class="form-control"
                                                           name="itemsToInsertSN[]"
                                                           :id="'itemsToInsertSN-'+index-1"
                                                           placeholder="Insert serial number">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <label v-if="parseInt(selectedItemToInsert.quantity)>10"
                                       class="help pull-right m-t-10"
                                       style="opacity: 0.7">Scroll for more
                                </label>

                            </div>
                        </div>
                        <br>
                        <div class="col-lg-6">
                            <h4 class="text-left dark-title p-l-0 p-t-0 p-b-5 p-r-0 no-margin"
                                style="line-height: 22px!important;"> Branch Office
                            </h4>
                            <div class="form-group">
                                <select class="form-control" v-model="selectedBranchOfficeId" style="height: 10px">
                                    <option value="" hidden selected>Select Branch Office</option>
                                    <option :value="branchOffice.id" v-for="branchOffice in branchOffices">
                                        {{branchOffice.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">

                        </div>
                        <div class="col-lg-12 m-t-10">
                            <button class="btn btn-primary pull-right" @click="insertNow()">Insert</button>
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
    import series from 'async/series';
    export default{
        data(){
            return {
                selectedBranchOfficeId: ''
            }
        },
        mounted(){

        },
        created(){
        },
        computed: {
            ...mapState('entry', {
                selectedItemToInsert: 'selectedItemToInsert',
                itemsToInsert: 'itemsToInsert',
                branchOffices: 'branchOffices',
            })
        },
        methods: {
            closeModal(){
                $('#modal-attempt-insert-to-inventory').modal('toggle')
            },
            plusAmount(){
                let entryVuexState = this.$store.state.entry
                entryVuexState.selectedItemToInsert.quantity++
            },
            minusAmount(){
                let entryVuexState = this.$store.state.entry
                if (entryVuexState.selectedItemToInsert.quantity > 0) {
                    entryVuexState.selectedItemToInsert.quantity--
                }
            },
            insertNow(){

                let self = this
                let entryVuexState = this.$store.state.entry
                let formArray = []

                if (parseInt(entryVuexState.selectedItemToInsert.quantity) > 0
                    && entryVuexState.selectedPurchaseOrderId != ''
                    && self.selectedBranchOfficeId) {

                    //insert selected branch office ID
                    entryVuexState.selectedBranchOfficeId = self.selectedBranchOfficeId

                    //is requires serial number, validate
                    if (entryVuexState.selectedItemToInsert.requiresSerialNumber) {

                        let serialNumbersInput = $('input[name="itemsToInsertSN[]"]')
                        let isValid = true;

                        series([
                            function (cb) {
                                serialNumbersInput.each(function (index, member) {

                                    let formObject = {
                                        itemId: '',
                                        quantity: '',
                                        serialNumber: ''
                                    }

                                    var value = $(member).val();

                                    //validate
                                    if (value != '') {
                                        formObject.itemId = entryVuexState.selectedItemToInsert.itemId
                                        formObject.quantity = 1
                                        formObject.serialNumber = value

                                        //push to array
                                        formArray.push(formObject)

                                    } else {
                                        //reset
                                        formArray = []
                                        isValid = false
                                    }

                                });
                                cb(null, '')
                            },
                            function (cb) {

                                if (isValid && formArray.length > 0) {

                                    //commit now
                                    self.$store.dispatch({
                                        type: 'entry/insertToInventory',
                                        itemsToInsert: formArray
                                    })

                                } else {
                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: 'Serial Number cannot be empty',
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'danger'
                                    }).show();
                                }
                                cb(null, '')
                            }
                        ])

                    } else {
                        series([
                            function (cb) {

                                let formObject = {
                                    itemId: entryVuexState.selectedItemToInsert.itemId,
                                    quantity: entryVuexState.selectedItemToInsert.quantity,
                                    serialNumber: ''
                                }

                                //push to array
                                formArray.push(formObject)

                                cb(null, '')
                            },
                            function (cb) {

                                //commit now
                                self.$store.dispatch({
                                    type: 'entry/insertToInventory',
                                    itemsToInsert: formArray
                                })

                                //reset

                                cb(null, '')
                            }
                        ])

                    }

                }
                else {
                    //alert quantity cannot be 0
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Invalid form. Items, branch office, purchase order, cannot be empty',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }
            }


        },
    }
</script>