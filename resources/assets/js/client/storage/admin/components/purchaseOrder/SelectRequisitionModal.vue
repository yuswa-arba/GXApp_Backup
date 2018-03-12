<template>
    <div class="modal fade" id="modal-select-requisition" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="closeModal()">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <p class="text-left p-b-5 fs-16">Select Requisition</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="input-group">
                                <input type="text" style="height: 40px;"
                                       class="form-control"
                                       id="search-requisition-box"
                                       @keyup.enter="searchRequisition()"
                                       placeholder="Search Requisition"
                                       v-model="searchRequisitionText"
                                >
                                <span class="input-group-addon primary" @click="searchRequisition()"><i
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
                                                        <div class="col-lg-12 border-bottom-grey padding-10 select-hover-warning"
                                                             @click="selectRequisition(requisition)"
                                                             v-for="(requisition,index) in requisitions">
                                                            <div class="pull-right">
                                                                <p>by {{requisition.requestedBy}}
                                                                    @{{requisition.requestedAt}}</p>
                                                            </div>
                                                            <p class="text-black bold m-b-0 fs-16">
                                                                {{requisition.approvalNumber}}</p>
                                                            <p>{{requisition.description}}</p>

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
                searchRequisitionText: ''
            }
        },
        created(){
        },
        computed: {
            ...mapState('purchaseOrder', {
                requisitions: 'requisitions'
            })
        },
        mounted(){

        },

        methods: {
            closeModal(){
                $('#modal-select-requisition').modal("toggle"); // close modal
            },
            searchRequisition(){
                let self = this
                self.$store.commit({
                    type: 'purchaseOrder/searchRequisition',
                    searchRequisitionText: self.searchRequisitionText
                })
            },
            selectRequisition(requisition){

                let self  = this

                let purchaseOrderVuexState = this.$store.state.purchaseOrder
                purchaseOrderVuexState.selectedRequisition = requisition




                self.closeModal()


            }
        },
    }
</script>