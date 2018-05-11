<template>
    <div class="modal  fade stick-up" id="modal-edit-item-price" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
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

                        <div class="col-lg-12">
                            <h4 class="text-left dark-title p-l-0 p-t-0 p-b-5 p-r-0 no-margin"
                                style="line-height: 22px!important;"> {{selectedItem.itemName}}
                            </h4>
                            <p class="text-left p-b-5">Item Code: {{selectedItem.itemCode}}</p>
                        </div>

                        <div class="col-lg-12">
                            <h4 class="text-left dark-title p-l-0 p-t-0 p-b-5 p-r-0 no-margin"
                                style="line-height: 22px!important;"> Latest Sell Price
                            </h4>
                            <div class="form-group">
                                <input type="text" class="form-control" v-model="selectedItem.sellingPrice">
                            </div>
                        </div>

                        <div class="col-lg-12 m-t-5">
                            <h4 class="text-left dark-title p-l-0 p-t-0 p-b-5 p-r-0 no-margin"
                                style="line-height: 22px!important;"> Latest Purchased Price
                            </h4>
                            <div class="form-group">
                                <input type="text" class="form-control" v-model="selectedItem.purchasedPrice">
                            </div>
                        </div>

                        <div class="col-lg-12 m-t-5">
                            <h4 class="text-left dark-title p-l-0 p-t-0 p-b-5 p-r-0 no-margin"
                                style="line-height: 22px!important;"> Fine Price
                            </h4>
                            <div class="form-group">
                                <input type="text" class="form-control" v-model="selectedItem.finePrice">
                            </div>
                        </div>

                        <div class="col-lg-12 m-t-10">
                            <button class="btn btn-primary pull-right" @click="saveItemPrice()">Save</button>
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
            return {}
        },
        mounted(){

        },
        created(){
        },
        computed: {
            ...mapState('items', {
                selectedItem: 'selectedItem'
            })
        },
        methods: {
            closeModal(){
                $('#modal-edit-item-price').modal('toggle')
            },
            saveItemPrice(){

                this.$store.commit({
                    type:'items/saveEditItemPrice',
                })

            }


        },
    }
</script>