<template>
    <input id="sortTimesheetDate" type="text" class="form-control" name="sortTimesheetDate" required>
</template>

<script>
    export default{
       mounted:function(){
           $('#sortTimesheetDate').datepicker({
               format: 'dd/mm/yyyy',
               todayHighlight:true
           });
           $('#sortTimesheetDate').val(moment().format('DD/MM/YYYY'))
       }
    }
</script>