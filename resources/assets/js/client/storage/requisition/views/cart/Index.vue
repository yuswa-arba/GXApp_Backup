<template>
    <div class="row">
        <div class="col-lg-12 m-t-20">
            <div class="card card-default card-bordered">
                <div class="card-block " style="padding: 10px 20px">
                    <div class="row">
                        <div class="col-lg-1">
                            <div class="checkbox check-success ">
                                <input type="checkbox" id="all-item-cb" @change="checkAllItems()">
                                <label for="all-item-cb" class="fs-16" >All</label>
                            </div>
                        </div>
                        <div class="col-lg-4"><p class="text-black fs-16 p-t-10">Item</p></div>
                        <div class="col-lg-2"><p class="text-black fs-16 p-t-10">Amount</p></div>
                        <div class="col-lg-1"><p class="text-black fs-16 p-t-10">Unit</p></div>
                        <div class="col-lg-3"><p class="text-black fs-16 p-t-10">Notes</p></div>
                        <div class="col-lg-1">
                            <p class="text-danger fs-16 p-t-10 p-l-0 cursor" @click="removeAllItems()">
                                <i class="fa fa-times"></i> ALL
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card card-default card-bordered">
                <div class="card-block " style="padding: 10px 20px">
                    <div class="col-lg-12" v-for="(item,index) in itemInsideCart">
                        <div class="row">
                            <div class="col-lg-1 p-t-10">
                                <div class="checkbox check-success ">
                                    <input type="checkbox" :id="'item-cb-'+item.id">
                                    <label :for="'item-cb-'+item.id"></label>
                                </div>
                            </div>
                            <div class="col-lg-4 p-t-10">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="cursor" @click="viewImage('/images/storage/items/'+item.itemPhoto)">
                                            <img :src="'/images/storage/items/'+item.itemPhoto" height="60px" alt="">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-black fs-16 m-b-0">{{item.itemName}}</p>
                                        <p class="no-padding fs-14">{{item.itemCode}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 p-t-10">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-grey" @click="minusAmount(index)"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                    <input type="text" class="btn text-true-black"
                                           style="width: 60px;border-color: #b7b7b7"
                                           :value="item.amount">
                                    <button type="button" class="btn btn-grey"@click="plusAmount(index)"><i
                                            class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-1 p-t-10"><p class="text-black fs-16 p-t-10">{{item.itemUnit}}</p></div>
                            <div class="col-lg-3 p-t-10">
                                <input type="text" class="form-control" :value="item.notes">
                            </div>
                            <div class="col-lg-1 p-t-10"><i class="text-danger fa fa-times fs-16 cursor p-t-10"></i></div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script type="text/javascript">
    import {get} from '../../../../helpers/api'
    import {api_path} from '../../../../helpers/const'
    import {mapGetters, mapState} from 'vuex'
    export default{
        data(){
            return {}
        },
        created(){
            this.$store.dispatch({
                type: 'cart/getDataOnCreate'
            })

        },
        computed: {
            ...mapState('cart', {
                itemInsideCart: 'itemInsideCart'
            })
        },
        methods:{
            viewImage(url){
                window.open(url,'_blank')
            },
            plusAmount(index){
                let cartVuexState = this.$store.state.cart
                cartVuexState.itemInsideCart[index].amount++
            },
            minusAmount(index){
                let cartVuexState = this.$store.state.cart
                if (cartVuexState.itemInsideCart[index].amount > 0) {
                    cartVuexState.itemInsideCart[index].amount--
                }
            },
            checkAllItems(){

                let cartVuexState = this.$store.state.cart
                let totalItems = cartVuexState.itemInsideCart.length + 1 //total items in cart

                let allItemCb = $('#all-item-cb')

                if(allItemCb.prop('checked')){ // check all
                    for (let i = 0;i<totalItems;i++){
                        let cb = $('#item-cb-'+i)
                        cb.prop('checked',true)
                    }
                } else { //uncheck all
                    for (let i = 0;i<totalItems;i++){
                        let cb = $('#item-cb-'+i)
                        cb.prop('checked',false)
                    }
                }

            },
            removeAllItems(){
                if(confirm('Are you sure to remove all items from cart?')){

                }
            }
        }
    }
</script>