<template>
    <div class="row">
        <div class="col-lg-12 m-t-20">
            <div class="card card-default card-bordered">
                <div class="card-block " style="padding: 10px 20px">
                    <div class="row">
                        <div class="col-lg-1">
                            <div class="checkbox check-success ">
                                <input type="checkbox" id="all-item-cb" @change="checkAllItems()">
                                <label for="all-item-cb" class="fs-16">All</label>
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

        <!--items in cart-->
        <div class="col-lg-12">
            <div class="card card-default card-bordered">
                <div class="card-block " style="padding: 10px 20px" v-if="itemInsideCart.length>0">
                    <div class="col-lg-12" v-for="(item,index) in itemInsideCart">
                        <div class="row">
                            <div class="col-lg-1 p-t-10">
                                <div class="checkbox check-success ">
                                    <input type="checkbox" :id="'item-cb-'+index"
                                           @change="toggleItemCb(index,item.id)">
                                    <label :for="'item-cb-'+index"></label>
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
                                    <button type="button" class="btn btn-grey" @click="minusAmount(item.id,index)"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                    <input type="number" class="btn text-true-black"
                                           style="width: 60px;border-color: #b7b7b7"
                                           :id="'input-amount-'+item.id"
                                           @change="editInputAmount(item.id,index)"
                                           :value="item.amount">
                                    <button type="button" class="btn btn-grey" @click="plusAmount(item.id,index)"><i
                                            class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-1 p-t-10"><p class="text-black fs-16 p-t-10">{{item.itemUnit}}</p></div>
                            <div class="col-lg-3 p-t-10">
                                <div class="btn-group">
                                    <input type="text"
                                           class="form-control"
                                           :id="'item-notes-'+item.id"
                                           :value="item.notes"
                                           @focus="notesOnFocus(item.id,index)">
                                    <button type="button"
                                            class="btn"
                                            style="display: none"
                                            :id="'save-btn-notes-'+item.id"
                                            @click="saveNotes(item.id,index)"
                                    >
                                           SAVE
                                    </button>
                                </div>

                            </div>
                            <div class="col-lg-1 p-t-10" @click="removeItem(item.id,index)"><i class="text-danger fa fa-times fs-16 cursor p-t-10"></i>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                    </div>
                </div>
                <div class="card-block" v-else="">
                    <h4 class="text-center">Your cart is empty</h4>
                </div>
            </div>
        </div>
        <!--end of items in cart-->

        <!--footer total items-->
        <div class="col-lg-12">
            <div class="card card-default card-bordered ">
                <div class="card-block " style="padding: 10px 20px">
                    <div class="row">
                        <div class="col-lg-2">
                            <p class="text-black fs-24 m-t-10"> Total: {{selectedItemsIdToRequest.length}} </p>
                        </div>
                        <div class="col-lg-10">
                            <button class="m-t-5 pull-right btn btn-primary text-uppercase fs-18" @click="createRequisition()">
                                Create Requisition <i class="fa fa-angle-right fs-20"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end of footer total items-->

    </div>
</template>

<script type="text/javascript">
    import {get} from '../../../../helpers/api'
    import {api_path} from '../../../../helpers/const'
    import {mapGetters, mapState} from 'vuex'
    export default{
        data(){
            return {
            }
        },
        created(){

            this.$store.dispatch({
                type: 'cart/getDataOnCreate'
            })

        },
        computed: {
            ...mapState('cart', {
                itemInsideCart: 'itemInsideCart',
                selectedItemsIdToRequest:'selectedItemsIdToRequest'
            })
        },
        methods: {
            viewImage(url){
                window.open(url, '_blank')
            },
            notesOnFocus(itemCartId,index){
               $('#save-btn-notes-'+itemCartId).show();
            },
            saveNotes(itemCartId,index){
                let notes = $('#item-notes-'+itemCartId).val()

                let cartVuexState = this.$store.state.cart
                cartVuexState.itemInsideCart[index].notes = notes

                //commit vuex to save it to DB
                this.$store.commit({
                    type:'cart/updateItemNotesInCart',
                    itemCartId:itemCartId,
                    notes: notes
                })

                //hide button
                $('#save-btn-notes-'+itemCartId).hide();
            },
            editInputAmount(itemCartId,index){

                let cartVuexState = this.$store.state.cart

                let inputAmount = $('#input-amount-'+itemCartId)
                cartVuexState.itemInsideCart[index].amount = inputAmount.val()

                setTimeout(()=>{
                    //commit vuex to save it to DB
                    this.$store.commit({
                        type:'cart/updateItemAmountInCart',
                        itemCartId:itemCartId,
                        amount:cartVuexState.itemInsideCart[index].amount
                    })

                },2000)

            },
            plusAmount(itemCartId,index){

                let cartVuexState = this.$store.state.cart
                cartVuexState.itemInsideCart[index].amount++

                setTimeout(()=>{
                    //commit vuex to save it to DB
                    this.$store.commit({
                        type:'cart/updateItemAmountInCart',
                        itemCartId:itemCartId,
                        amount:cartVuexState.itemInsideCart[index].amount
                    })

                },1000)

            },
            minusAmount(itemCartId,index){
                let cartVuexState = this.$store.state.cart
                if (cartVuexState.itemInsideCart[index].amount > 0) {
                    cartVuexState.itemInsideCart[index].amount--
                }

                setTimeout(()=>{
                    //commit vuex to save it to DB
                    this.$store.commit({
                        type:'cart/updateItemAmountInCart',
                        itemCartId:itemCartId,
                        amount:cartVuexState.itemInsideCart[index].amount
                    })

                },1000)

            },
            toggleItemCb(index, itemCartId){

                let self  = this
                let cartVuexState = this.$store.state.cart
                let itemCb = $('#item-cb-' + index)

                if (itemCb.prop('checked')) {

                    cartVuexState.selectedItemsIdToRequest.push(itemCartId) //push to array

                } else {

                    let itemIndex = _.findIndex(cartVuexState.selectedItemsIdToRequest, (o) => { // get index of this item id
                        return o == itemCartId
                    })

                    cartVuexState.selectedItemsIdToRequest.splice(itemIndex,1) //remove from array

                    //unchecked all item cb
                    $('#all-item-cb').prop('checked',false)
                }

            },
            checkAllItems(){
                let self = this

                let cartVuexState = this.$store.state.cart
                let totalItems = cartVuexState.itemInsideCart.length + 1 //total items in cart
                let allItemCb = $('#all-item-cb')

                //reset the first time
                cartVuexState.selectedItemsIdToRequest = []

                if (allItemCb.prop('checked')) { // check all

                    for (let i = 0; i < totalItems; i++) {

                        let cb = $('#item-cb-' + i)
                        cb.prop('checked', true)

                        if(i<totalItems-1){ // do not include the last one
                            cartVuexState.selectedItemsIdToRequest.push(cartVuexState.itemInsideCart[i].id)
                        }

                    }

                } else { //uncheck all
                    for (let i = 0; i < totalItems; i++) {
                        let cb = $('#item-cb-' + i)
                        cb.prop('checked', false)
                    }

                    cartVuexState.selectedItemsIdToRequest = []

                }
            },
            removeItem(itemCartId,index){

                if (confirm('Are you sure to remove this item from cart?')) {

                    //remove all item in cart
                    this.$store.commit({
                        type:'cart/removeItem',
                        itemCartId:itemCartId,
                        index:index
                    })


                }
            },
            removeAllItems(){
                if (confirm('Are you sure to remove all items from cart?')) {

                    //remove all item in cart
                    this.$store.commit({
                        type:'cart/removeAllItems'
                    })


                }
            },
            createRequisition(){

                let self = this
                let cartVuexState = this.$store.state.cart
                
                if(cartVuexState.selectedItemsIdToRequest.length>0){

                    // start create requisition
                    this.$store.dispatch({
                        type: 'cart/getDataOnRequisitionForm'
                    })

                    // move to requisition form
                    // add delay 0.3 sec to fetch item details from server first
                    setTimeout(()=>{
                        this.$router.push({name:'requisitionForm'})
                    },300)

                    
                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'There is no item selected',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();  
                }
            }
        }
    }
</script>