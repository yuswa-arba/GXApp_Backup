<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <div class="pull-left m-r-15 m-b-10">
                <button class="btn btn-info text-uppercase" @click="goToPurchaseOrderForm()">
                    Create New PO <i class="fa fa-pencil"></i>
                </button>
            </div>
        </div>

        <infinite-loading @infinite="infiniteHandler"
                          spinner="waveDots"
                          class="margin-center"
                          ref="infiniteLoading">
                                        <span slot="no-more">
                                          <!--There is no more Items-->
                                        </span>
        </infinite-loading>
    </div>
</template>

<script type="text/javascript">
    import {get} from '../../../../helpers/api'
    import {api_path} from '../../../../helpers/const'
    import {mapGetters, mapState} from 'vuex'
    import InfiniteLoading from 'vue-infinite-loading';
    export default{
        components: {
            InfiniteLoading,
        },
        data(){
            return {

            }
        },
        created(){

            // get necessary data on create for this page
            this.$store.dispatch({
                type:'purchaseOrder/getDataOnCreate'
            })

        },
        computed: {
            ...mapState('purchaseOrder', {

            })
        },
        methods: {
            infiniteHandler($state) { //getting item list data from server using vue-infinit-scroll

            },
            goToPurchaseOrderForm(){
                this.$router.push({name:'createNewPO'})
            }

        }
    }
</script>