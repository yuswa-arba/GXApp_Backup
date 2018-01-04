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

           let currentDate = moment().format('DD/MM/YYYY')
           if(this.$store.state.timesheet.sortedDate){
               currentDate = this.$store.state.timesheet.sortedDate
           }
           $('#sortTimesheetDate').val(currentDate)
       }
    }
</script>