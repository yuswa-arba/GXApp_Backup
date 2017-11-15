<template>
    <div>
        <span class="text-primary pointer"
              @click="goBack()"
        ><i class="pg-arrow_left"></i>Go Back</span>
        <h3>
            {{$route.params.id}}
        </h3>
    </div>

</template>
<script type="text/javascript">
    export default{
        created(){

        },
        methods:{
            goBack(){
                this.$router.push('/')
            }
        }
    }
</script>