<template>

    <div class="col-lg-7">
        <div class="card card-default">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-default no-border">
                        <div class="card-block">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button class="btn btn-info pull-right">Add Item <i class="fa fa-plus"></i></button>
                                </div>
                                <div class="col-lg-12 p-t-10 border-bottom-grey select-hover-warning" v-for="index in 5">
                                    <div class="row">
                                        <div class="col-lg-2 m-t-5">
                                            <p class="m-b-0 fs-16"> Amount : <span class="text-black">2</span></p>
                                            <p class="m-b-0 fs-16"> Unit : ea</p>
                                        </div>
                                        <div class="col-lg-3 m-t-5">
                                            <p class="text-black fs-16 m-b-0 bold"> Xiaomi Mi 4</p>
                                            <p class="m-b-10"> CE-00224-003</p>
                                        </div>
                                        <div class="col-lg-3 m-t-5">
                                            <p class="m-b-0">per item</p>
                                            <p class="text-black m-b-10 fs-16">IDR 5.500.000</p>
                                        </div>
                                        <div class="col-lg-3 m-t-5">
                                            <p class="m-b-0">sub total</p>
                                            <p class="text-black m-b-10 fs-16 bold">IDR 11.000.000</p>
                                        </div>
                                        <div class="col-lg-1 m-t-5">
                                            <p><i class="fa fa-trash text-hover-danger fs-16 cursor m-t-10"></i></p>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 border-bottom-grey" style="padding-top: 20px; padding-bottom: 20px">
                                    <div class="row">

                                        <div class="col-lg-8 m-t-5">
                                            <button class="btn btn-default">Add Shipping Fee <i class="fa fa-plus"></i></button>
                                        </div>
                                        <div class="col-lg-3 m-t-5">
                                            <p class="m-b-0 fs-16">Total</p>
                                            <p class="fs-18 text-primary bold text-left">
                                                IDR 55.000.000
                                            </p>
                                        </div>
                                        <div class="col-lg-1"></div> <!--empty space for UI -->

                                    </div>
                                </div>
                                <div class="col-lg-12" style="margin-top: 20px">
                                    <button class="btn btn-primary fs-16 pull-right">Create PO <i class="fa fa-file"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</template>

<script>
    import {mapGetters, mapState} from 'vuex'
    export default{
        data(){
            return {}
        },
        created(){
            let self = this


        },
        computed: {
            ...mapState('purchaseOrder', {})
        },
        mounted(){

        },

        methods: {},
    }
</script>