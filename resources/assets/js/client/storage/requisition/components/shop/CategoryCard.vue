<template>
    <div class="row">
        <div class="col-lg-12 m-b-10">
            <h4>Categories</h4>
        </div>
        <div class="col-lg-12 m-b-10">
            <div class="scrollable">
                <div style="height: 700px">
                    <div class="row">

                        <!-- ALL-->
                        <div class="col-lg-12 col-sm-6 d-flex-not-important flex-column" @click="sortByCategory('')">
                            <!-- START ITEM -->
                            <div class="card social-card share  full-width m-b-10 d-flex flex-1 full-height no-border sm-vh-75"
                                 data-social="item">
                                <div class="card-header clearfix">
                                    <h5 class="fs-16 overflow-ellipsis">ALL</h5>
                                </div>
                            </div>
                            <!-- END ITEM -->
                        </div>

                        <!-- CATEGORIES -->
                        <div class="col-lg-12 col-sm-6 d-flex-not-important flex-column"
                             v-for="(category,index) in categories" @click="sortByCategory(category.code)">
                            <!-- START ITEM -->
                            <div class="card social-card share  full-width m-b-10 d-flex flex-1 full-height no-border sm-vh-75"
                                 data-social="item">
                                <div class="card-header clearfix">
                                    <h5 class="fs-16 overflow-ellipsis">{{category.name}}</h5>
                                </div>
                            </div>
                            <!-- END ITEM -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script type="text/javascript">
    import {get} from '../../../../helpers/api'
    import {api_path} from '../../../../helpers/const'
    export default{
        data(){
            return {
                categories: []
            }
        },
        created(){
            let self = this
            //get data on create
            get(api_path + 'storage/itemCategory/list')
                .then((res) => {
                    if (!res.data.isFailed) {
                        self.categories = res.data.categories.data
                    }
                })
                .catch((err) => {
                })

        },
        methods: {
            sortByCategory(categoryCode){

                let shopVuexState = this.$store.state.shop
                shopVuexState.isSearchingItem = true

                this.$store.commit({
                    type:'shop/getItemList',
                    sortCategoryCode:categoryCode

                })

            }
        },
        mounted(){

        }

    }
</script>