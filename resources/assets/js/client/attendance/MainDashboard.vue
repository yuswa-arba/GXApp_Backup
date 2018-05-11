<template>
    <div class="container-fluid container-fixed-lg sm-gutter">
        <router-view>
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
            }
        }
    }
</script>