<template>
    <div class="col-lg-12 m-b-10 d-flex">
        <!-- START WIDGET widget_pendingComments.tpl-->
        <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
            <div class="card-header m-b-10">
                <h5 class="text-primary pull-left fs-14 bold no-margin">Live Clock In Feed <i
                        class="fa fa-circle text-complete fs-11"></i></h5>
                <div class="clearfix"></div>
            </div>
            <div class="auto-overflow widget-11-2-table" style="height: 380px">
                <div class="d-flex-not-important flex-column filter-item" v-for="feed in liveClockInFeeds">
                    <div class="card social-card share  m-b-0 full-width d-flex flex-1 full-height no-border "
                         data-social="item">
                        <div class="card-header clearfix">
                            <div class="user-pic">
                                <img alt="Avatar" width="33" height="33"
                                     :data-src-retina="'/images/attendances/'+feed.photo"
                                     :data-src="'/images/attendances/'+feed.photo"
                                     :src="'/images/attendances/'+feed.photo">
                            </div>
                            <h5 class="fs-16 m-b-5">{{feed.employeeName}} ({{feed.divisionName}})</h5>
                            <h6 class="fs-14">@<span class="bold text-true-black">{{feed.time}}</span>
                                via <span class="text-primary bold">{{feed.via}}({{feed.viaDesc}})</span>
                                on shift <span class="bold">{{feed.shiftName}}</span> <i class="fa fa-clock-o text-danger" v-if="feed.isLate"></i>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="padding-25 mt-auto">
                <p class="small no-margin">
                    <a href="#"><i class="fa fs-16 fa-arrow-circle-o-down text-success m-r-10"></i></a>
                    <span class="hint-text ">Show all</span>
                </p>
            </div>
        </div>
        <!-- END WIDGET -->
    </div>

</template>

<script>
    import {mapGetters} from 'vuex'
    export default{
        mounted: function () {

        },
        computed: {
            ...mapGetters('dashboard', {
                liveClockInFeeds:'liveClockInFeeds'
            }),

        },
    }
</script>