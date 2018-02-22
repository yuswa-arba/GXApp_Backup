<template>
    <div>
        <a class="btn-link quickview-toggle" data-toggle-element="#quickview-notification" data-toggle="quickview"><i
                class="pg-close"></i></a>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- BEGIN Alerts !-->
            <div class="tab-pane active no-padding" id="quickview-alerts">
                <div class="view-port clearfix" id="alerts">
                    <!-- BEGIN Alerts View !-->
                    <div class="view bg-white">
                        <!-- BEGIN View Header !-->
                        <div class="navbar navbar-default navbar-sm">
                            <div class="navbar-inner">
                                <!-- BEGIN Header Controler !-->
                                <a href="javascript:;" class=" inline action p-l-10 link text-master"
                                   @click="closeQuickview()">
                                    <i class="fs-18 fa fa-arrow-circle-right"></i>
                                </a>
                                <!-- END Header Controler !-->
                                <div class="view-heading">
                                    Notifications
                                </div>
                                <!-- BEGIN Header Controler !-->
                                <a href="#" class="inline action p-r-10 pull-right link text-master">
                                    <i class="pg-search"></i>
                                </a>
                                <!-- END Header Controler !-->
                            </div>
                        </div>
                        <!-- END View Header !-->
                        <!-- BEGIN Alert List !-->
                        <div data-init-list-view="ioslist" class="list-view boreded no-top-border">

                            <div class="list-view-group-container" v-for="notification in notificationList">
                                <div v-if="notification.notifData">
                                    <!-- BEGIN List Group Header!-->
                                    <div class="list-view-group-header text-uppercase">
                                        {{notification.groupTypeName}}
                                    </div>
                                    <!-- END List Group Header!-->

                                    <ul>
                                        <!-- BEGIN List Group Item!-->
                                        <li class="alert-list" v-for="notif in notification.notifData">
                                            <!-- BEGIN Alert Item Set Animation using data-view-animation !-->
                                            <a href="#" class="p-t-10 p-b-10 align-items-center" data-navigate="view"
                                               data-view-port="#chat" data-view-animation="push-parrallax"
                                               :class="{'cursor':notif.url}"
                                               style="height: 60px!important;"
                                            >
                                                <p class="">
                                                    <span v-if="notif.hasSeen==0" class="text-danger fs-10"><i class="fa fa-circle"></i></span>
                                                    <span v-else="" class="text-master-light fs-10"><i class="fa fa-circle"></i></span>
                                                </p>
                                                <p class="col overflow-ellipsis fs-12 p-l-10 p-r-20" style="line-height:18px!important;width:255px!important">
                                                    <span class="text-black fs-14 " :class="{'bold':notif.hasSeen==0}">{{notif.title}}<br></span>
                                                    <span class="text-master fs-14">{{notif.message}}<br></span>
                                                    <span class="text-master link fs-12">{{notif.sendAt}}<br></span>

                                                </p>
                                                <p class="pull-right">
                                                    <span v-if="notif.url" class="text-primary cursor" style="padding-right: 15px">
                                                    <i class="fa fa-chevron-right fs-14"></i>
                                                </span>
                                                </p>
                                            </a>
                                            <!-- END Alert Item!-->
                                        </li>
                                        <!-- END List Group Item!-->
                                    </ul>

                                </div>

                            </div>
                        </div>
                        <!-- END Alert List !-->
                    </div>
                    <!-- EEND Alerts View !-->
                </div>
            </div>
            <!-- END Alerts !-->
        </div>
    </div>
</template>

<script type="text/javascript">
    import{mapState, mapGetters} from 'vuex'
    import {closeNotificationList} from './utils/util'
    export default{
        created(){
            this.$store.dispatch({type: 'notification/initConfigsFirstTIme'})
            this.$store.dispatch({type: 'notification/getDataOnCreate'})
        },
        computed: {
            ...mapState('notification', {
                notificationList: 'notificationList'
            })
        },
        methods: {
            closeQuickview(){
                closeNotificationList()
            }
        }
    }
</script>