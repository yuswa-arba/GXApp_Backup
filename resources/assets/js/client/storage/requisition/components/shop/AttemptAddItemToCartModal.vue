<template>
    <div class="modal fade" id="modal-attempt-add-item-to-cart" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" @click="closeModal()">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <p class="text-left p-b-5">Item Code: {{itemToAdd.itemCode}}</p>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="text-left dark-title p-l-0 p-t-0 p-b-5 p-r-0 no-margin"
                                style="line-height: 22px!important;"> {{itemToAdd.name}}</h4>
                            <p class="no-padding no-margin fs-16">Unit: {{itemToAdd.unitFormat}}</p>
                            <p class="no-padding no-margin fs-16">Status: {{itemToAdd.statusName}}</p>
                            <p class="no-padding no-margin fs-16">Stock: 0</p>
                            <!-- get current stock from stock storage table-->
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group pull-right">
                                <button type="button" class="btn btn-grey" @click="minusAmount()"><i
                                        class="fa fa-minus"></i>
                                </button>
                                <input type="text"
                                       class="btn text-true-black"
                                       style="width: 60px;border-color: #b7b7b7"
                                       id="item-add-to-cart-amount"
                                       v-model="addItemToCartAmount">
                                <button type="button" class="btn btn-grey" @click="plusAmount()"><i
                                        class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" @click="addToCart()">
                                Add To Cart
                            </button>
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
            return {}
        },
        created(){
        },
        computed: {
            ...mapState('shop', {
                addItemToCartAmount: 'addItemToCartAmount',
                itemToAdd: 'itemToAdd'
            })
        },
        mounted(){

        },

        methods: {
            closeModal(){
                $('#modal-attempt-add-item-to-cart').modal("toggle"); // close modal
                let shopVuexState = this.$store.state.shop
                shopVuexState.addItemToCartAmount = 1 //reset to default
            },
            addToCart(){

                let shopVuexState = this.$store.state.shop
                shopVuexState.addItemToCartAmount = $('#item-add-to-cart-amount').val()

                //commit vuex add item to cart
                this.$store.commit({
                    type: 'shop/addToCart'
                })

            },
            plusAmount(){
                let shopVuexState = this.$store.state.shop
                shopVuexState.addItemToCartAmount++
            },
            minusAmount(){
                let shopVuexState = this.$store.state.shop
                if (shopVuexState.addItemToCartAmount > 0) {
                    shopVuexState.addItemToCartAmount--
                }
            }

        },
    }
</script>