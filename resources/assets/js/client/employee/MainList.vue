<template>
    <div class="container-fluid container-fixed-lg">
        <router-view>

            <div slot="go-back-and-view-menu">
                <button class="btn btn-outline-primary m-r-15 m-b-10 pull-left"
                        @click="goBack()"><i class="pg-arrow_left"></i>
                    Go Back
                </button>
                <div class="pull-left m-r-15 m-b-10">
                    <div class="dropdown dropdown-default">
                        <button class="btn btn-primary all-caps dropdown-toggle text-center" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            View
                        </button>

                        <div class="dropdown-menu">
                            <a class="dropdown-item pointer" @click="viewMasterDetail()">
                                Master</a>
                            <a class="dropdown-item pointer" @click="viewEmploymentDetail()">
                                Employment</a>
                            <a class="dropdown-item pointer" @click="viewLoginDetail()">
                                Login Details
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </router-view>

    </div>
</template>
<script type="text/javascript">
    export default{
        methods: {
            viewMasterDetail(){
                this.$router.push({name: 'detailMaster', params: {id: this.$route.params.id}})
            },
            viewEmploymentDetail(){
                this.$router.push({name: 'detailEmployment', params: {id: this.$route.params.id}})
            },
            viewLoginDetail(){
                this.$router.push({name: 'detailLogin', params: {id: this.$route.params.id}})
            },
            goBack(){
                this.$router.push('/')
            }

        },
    }
</script>