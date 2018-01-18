<template>
    <div class="container-fluid container-fixed-lg">
        <router-view>

            <div slot="go-back-menu">
                <button class="btn btn-outline-primary m-r-15 m-b-10 pull-left"
                        @click="goBack()"><i class="pg-arrow_left"></i>
                    Go Back
                </button>
            </div>

            <div slot="edit-menu">
                <button class="btn btn-danger m-b-10 pull-right"
                        @click="edit()">
                    Edit
                </button>
            </div>

        </router-view>
    </div>
</template>

<script type="text/javascript">
    export default{
        created(){

        },
        methods: {
            goBack(){
                $('#errors-container').addClass('hide');
                this.$router.go(-1)
            },
            edit(){

            },
            save(){

            },
            cancel(){

            }
        }
    }
</script>