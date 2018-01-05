<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card no-border widget-loader-bar m-b-10 bg-transparent">
                <div class="container-xs-height full-height">
                    <div class="row-xs-height">
                        <div class="col-xs-height col-top">
                            <div class="p-l-20 p-t-20 p-b-20 p-r-20">
                                <h3 class="no-margin">
                                    <span class="left-0"><i class="fa fa-circle text-complete fs-16"></i></span>
                                    {{currentDayDateTime}}
                                    <span class="help pull-right ">
                                        ( Week {{currentWeek}})
                                    </span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-flex flex-column">
            <div class="row">
                <live-clock-in-feed></live-clock-in-feed>
            </div>
        </div>
        <div class="col-lg-6 d-flex flex-column">
            <div class="row">
                <live-clock-out-feed></live-clock-out-feed>
            </div>
        </div>
    </div>

</template>

<script>
    import {mapGetters} from 'vuex'
    import LiveClockInFeed from '../../components/dashboard/LiveClockInFeed.vue'
    import LiveClockOutFeed from '../../components/dashboard/LiveClockOutFeed.vue'

    export default{
        components: {
            'live-clock-in-feed':LiveClockInFeed,
            'live-clock-out-feed':LiveClockOutFeed

        },
        data(){
            return {
                currentDayDateTime: '',
                currentWeek: ''
            }
        },

        created(){

            let self = this
            this.listenToEcho()
            this.initTimes()
            this.$store.dispatch('dashboard/getDataOnCreate')

        },
        methods: {
            listenToEcho(){
                echo.channel('attendance')
                    .listen('Attendance.Events.EmployeeClocked', (data) => {
                        console.log(data)

                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: data.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'info'
                        }).show();
                    })

            },
            initTimes(){
                let self = this
                self.currentDayDateTime = moment().format("ddd, MMM Do YYYY, HH:mm")
                self.currentWeek = moment().format('W')
                setTimeout(self.initTimes, 30000)
            }
        }
    }
</script>