<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <slot name="go-back-menu"></slot>
        </div>
        <div class="col-lg-12">
            <resigned-employee-card></resigned-employee-card>
        </div>
    </div>
</template>
<script type="text/javascript">
    import ResignedEmployeeCard from '../../components/ResignedEmployeeCard.vue'
    export default{
        components:{
            "resigned-employee-card":ResignedEmployeeCard
        },
        mounted(){

        }
    }
</script>