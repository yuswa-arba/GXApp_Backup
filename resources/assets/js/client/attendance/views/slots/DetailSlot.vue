<template>
    <div class="row">
        <div class="col-lg-12 m-b-10">
            <div id="calendar"></div>
        </div>
    </div>
</template>

<script>
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{
        created(){

        },
        mounted(){
            $('#calendar').fullCalendar({
                // put your options and callbacks here
            })
        }

    }
</script>