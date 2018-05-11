<template>
    <div>
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
                                <div class="pull-left inline action link text-master">
                                    <div class="dropdown dropdown-default">
                                        <button class="btn dropdown-toggle text-center text-primary"
                                                style="padding-top: 2px;padding-bottom: 2px;border: none"
                                                type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            More
                                        </button>

                                        <div class="dropdown-menu">
                                            <a @click="goToAllNotifications()" class="dropdown-item pointer">
                                                Show all</a>
                                            <a class="dropdown-item pointer" @click="markAllAsRead()">
                                                Mark all as read</a>

                                        </div>

                                    </div>
                                </div>

                                <!-- END Header Controler !-->
                                <div class="view-heading">
                                    Notifications
                                </div>
                                <!-- BEGIN Header Controler !-->

                                <a href="javascript:;" class=" pull-right inline action p-r-15 link text-master"
                                   @click="closeQuickview()">
                                    <i class="fs-18 fa fa-times"></i>
                                </a>

                                <!-- END Header Controler !-->
                            </div>
                        </div>
                        <!-- END View Header !-->
                        <!-- BEGIN Alert List !-->
                        <div data-init-list-view="ioslist" class="list-view boreded no-top-border">
                            <div class="scrollable" v-if="unreadExists">
                                <div style="height: 1600px!important;">
                                    <div class="list-view-group-container"
                                         v-if="notification.notifData"
                                         v-for="(notification,indexList) in notificationList">

                                        <!-- BEGIN List Group Header!-->
                                        <div class="list-view-group-header text-uppercase" style="z-index: 0">
                                            {{notification.groupTypeName}}
                                        </div>
                                        <!-- END List Group Header!-->
                                        <ul>
                                            <!-- BEGIN List Group Item!-->
                                            <li class="alert-list" v-for="(notif,indexItem) in notification.notifData">
                                                <!-- BEGIN Alert Item Set Animation using data-view-animation !-->
                                                <a href="#" class="p-t-10 p-b-10 align-items-center"
                                                   data-navigate="view"
                                                   data-view-port="#chat" data-view-animation="push-parrallax"
                                                   @click="openUrl(notif.url,notif.id,indexList,indexItem)"
                                                   :class="{'cursor':notif.url}"
                                                   style="height: 60px!important;"
                                                >
                                                    <p class="">
                                                    <span v-if="notif.hasSeen==0" class="text-danger fs-10"><i
                                                            class="fa fa-circle"></i></span>
                                                        <span v-else="" class="text-master-light fs-10"><i
                                                                class="fa fa-circle"></i></span>
                                                    </p>
                                                    <p class="col overflow-ellipsis fs-12 p-l-10 p-r-20"
                                                       style="line-height:18px!important;width:255px!important">
                                                        <span class="text-black fs-14 "
                                                              :class="{'bold':notif.hasSeen==0}">{{notif.title}}<br></span>
                                                        <span class="text-master fs-14">{{notif.message}}<br></span>
                                                        <span class="text-master link fs-12">{{notif.sendAt}}<br></span>

                                                    </p>
                                                    <p class="pull-right">
                                                    <span v-if="notif.url" class="text-primary cursor"
                                                          style="padding-right: 15px">
                                                    <i class="fa fa-chevron-right fs-14"></i>
                                                </span>
                                                    </p>
                                                </a>
                                                <!-- END Alert Item!-->
                                            </li>
                                            <!-- END List Group Item!-->
                                        </ul>
                                        <div class="text-right text-black fs-14 bg-danger-lighter"
                                             style="opacity: 0.7;padding: 2px 10px" v-if="notification.totalNew>5">
                                            <span class="text-right"> <b>{{notification.totalNew}}</b> Unread Notifications</span>
                                        </div>
                                        <div class="text-right text-black fs-12"
                                             style="opacity: 0.7;padding: 2px 10px" v-else="">
                                            <span class="text-right text-primary cursor"> Show All </span>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div v-else="" class="text-center" style="padding-top: 250px">
                                <p class="text-master fs-18">
                                    There is no new notifications
                                </p>
                                <button class="btn btn-primary" @click="goToAllNotifications()">Show all</button>
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
    import {isWebUri} from 'valid-url'
    export default{
        created(){
            this.$store.dispatch({type: 'notification/initConfigsFirstTIme'})
            this.$store.dispatch({type: 'notification/getDataOnCreate'})
        },
        computed: {
            ...mapState('notification', {
                notificationList: 'notificationList',
                unreadExists: 'unreadExists'
            })
        },
        methods: {
            closeQuickview(){
                closeNotificationList()
            },
            openUrl(url, notificationId, indexList, indexItem){
                if (isWebUri(url)) {
                    window.open(url, '_blank')
                }

                this.$store.commit({
                    type: 'notification/seenNotification',
                    notificationId: notificationId,
                    indexList: indexList,
                    indexItem: indexItem
                })

            },
            markAllAsRead(){
                this.$store.commit({type: 'notification/seenNotificationList'})
            },
            goToAllNotifications(){
                window.open('/profile/notifications')
            }
        }
    }
</script>