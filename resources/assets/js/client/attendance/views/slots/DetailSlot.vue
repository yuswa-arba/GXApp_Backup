<template>
    <div class="row">

        <div class="col-lg-12 m-b-10 m-t-10">
            <slot name="go-back-menu"></slot>
        </div>


        <div class="col-lg-12 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block padding-30">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                calendarEventSource: []
            }
        },
        created(){
            let self = this

            get(api_path() + 'attendance/slot/detail/calendar?' + 'slotId=' + this.$route.params.id)
                .then((res) => {
                    self.calendarEventSource = res.data.data
                    $('#calendar').fullCalendar('addEventSource', self.calendarEventSource);
                })
                .catch((err) => {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: err.message,
                        position: 'top',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                })
        },
        mounted(){

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today removeSource',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                selectable: true,
                selectHelper: true,
                select: function(start, end) {
//                  alert(moment(start).format('DD/MM/YYYY'))
                },
                eventRender: function(event, element, view ) {
                    element.on('click',()=>{
                        console.log(moment(event.start).format('DD/MM/YYYY'))
                    })
                },
            })
        }

    }
</script>