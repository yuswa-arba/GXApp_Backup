<template>
    <div class="input-daterange input-group" id="summary-datepicker-range">
        <input type="text" class="input-sm form-control" name="generateFromDate" :value="defaultFromDate"/>
        <div class="input-group-addon">to</div>
        <input type="text" class="input-sm form-control" name="generateToDate" :value="defaultToDate"/>
    </div>
</template>

<script type="text/javascript">
    import {mapGetters, mapState} from 'vuex'
    export default{
        mounted: function () {
            $('#summary-datepicker-range').datepicker({format: 'dd/mm/yyyy', autoclose: true})
        },
        computed:{
            ...mapGetters('report',{
                defaultFromDate:'defaultFromDate',
                defaultToDate:'defaultToDate'
            })
        }

    }
</script>