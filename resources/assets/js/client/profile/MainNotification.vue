<template>
    <div>
        <!-- START SECONDARY SIDEBAR MENU-->
        <nav class="secondary-sidebar light">
            <p class="menu-title text-uppercase">Group Types</p>
            <ul class="main-menu">
                <li class="" v-for="(groupType,index) in notificationGroupTypes"
                    @click="changeGroupType(groupType.id,index)">
                    <a href="#">
                        <span class="title"><i class="fa fa-circle fs-11"></i>{{groupType.name}}</span>
                        <span class="badge pull-right" v-if="groupType.totalNew>0">{{groupType.totalNew}}</span>
                    </a>
                </li>
            </ul>

        </nav>
        <!-- END SECONDARY SIDEBAR MENU -->
        <!-- START INNER CONTENT -->
        <div class="inner-content full-height">
            <!-- START CONTAINER FLUID -->

            <div class="container-fluid container-fixed-lg">
                <!-- BEGIN PlACE PAGE CONTENT HERE -->
                <div class="widget-11-2 card bg-transparent no-border">
                    <div class="card-header m-b-10 p-l-5 p-t-20">
                        <div class="card-title">{{currentGroupTypeName}}</div>
                        <div class="pull-right">
                            <select v-model="sortYear" class="btn btn-outline-primary h-35 w-100"
                                    @change="sortNotificationList()">
                                <option :value="year" v-for="year in yearsList">{{year}}</option>
                            </select>
                        </div>

                        <div class="pull-right m-r-15">
                            <select v-model="sortMonth" class="btn btn-outline-primary h-35 w-100"
                                    @change="sortNotificationList()">
                                <option :value="month.number" v-for="month in months">{{month.name}}</option>
                            </select>
                        </div>

                        <div class="pull-right">
                            <button class="btn btn-primary m-r-15" @click="seenAllNotification()">Mark all as read</button>
                        </div>

                    </div>
                    <div class="auto-overflow widget-11-2-table" style="height: 1600px">

                        <div class="d-flex-not-important flex-column filter-item"
                             v-for="(notification,index) in notificationList">
                            <div class="card social-card share  m-b-0 full-width d-flex flex-1 full-height bg-transparent"
                                 data-social="item">
                                <div class="card-header clearfix"
                                     :class="{
                                     'bg-warning-lighter-important':notification.hasSeen==0,
                                     'bg-transparent':notification.hasSeen==1
                                     }"
                                     @click="openUrl(notification.url,notification.id,index)"
                                     >
                                    <h6 class="fs-14 pull-right">{{notification.sendAt}} by {{notification.sendBy}}</h6>
                                    <h5 class="fs-16 text-primary m-b-5">{{notification.title}}</h5>
                                    <h5 class="fs-16 m-b-5">{{notification.message}}</h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- END PLACE PAGE CONTENT HERE -->
            </div>
            <!-- END CONTAINER FLUID -->
        </div>
        <!--END INNER CONTENT-->
    </div>
</template>

<script type="text/javascript">
    import {get, post} from'../helpers/api'
    import {api_path} from '../helpers/const'
    import {isWebUri} from 'valid-url'
    export default{
        data(){
            return {
                currentGroupTypeId: 1, //default
                currentGroupTypeName: 'General', //default
                sortMonth: moment().format('MM'), //default
                sortYear: moment().format('YYYY'),
                notificationGroupTypes: [],
                notificationList: [],
                months: [],
                yearsList: [2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023, 2024, 2025, 2026, 2027, 2028]

            }
        },
        created(){
            let self = this

            //get months
            get(api_path + 'component/list/months')
                .then((res) => {
                    self.months = res.data
                })

            //get group types
            self.getGroupTypes()

            //get notification
            self.getNotificationListOf(self.currentGroupTypeId)


        },
        methods: {
            getGroupTypes(){
                let self  = this
                get(api_path + 'profile/notification/recipient/groupTypes')
                    .then((res) => {
                        if (!res.data.isFailed) {

                            // insert to array
                            self.notificationGroupTypes = res.data.groupTypes

                        } else {
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();
                        }
                    })
                    .catch((err) => {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    })
            },
            getNotificationListOf(groupTypeId){
                let self = this

                let param = '?groupTypeId=' + groupTypeId
                param += '&month=' + self.sortMonth
                param += '&year=' + self.sortYear

                //get notifications
                get(api_path + 'profile/notification/listOf' + param)
                    .then((res) => {

                        if (!res.data.isFailed) {

                            self.notificationList = res.data.notifications.data

                        } else {
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();
                        }
                    })
                    .catch((err) => {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    })
            },
            seenAllNotification(){
                let self = this
                if(confirm("Are you sure to mark all as read")){
                    get(api_path + 'profile/notification/seenAll')
                        .then((res) => {
                        })
                        .catch((err) => {
                        })

                    self.getGroupTypes()
                    self.getNotificationListOf(self.currentGroupTypeId)
                }
            },
            seenNotification(notificationId,index){
                let self = this
                get(api_path + 'profile/notification/seen?notificationId=' + notificationId)
                    .then((res) => {
                        if (!res.data.isFailed) {
                            self.notificationList[index].hasSeen=1
                            self.getGroupTypes() // update group types
                        }
                    })
                    .catch((err) => {
                    })
            },
            changeGroupType(groupTypeId, index){
                let self = this
                self.currentGroupTypeId = groupTypeId
                self.currentGroupTypeName = self.notificationGroupTypes[index].name
                self.getNotificationListOf(groupTypeId)
            },
            sortNotificationList(){
                let self = this
                self.getNotificationListOf(self.currentGroupTypeId)
            },
            openUrl(url,notificationId,index){

                let self =this

                self.seenNotification(notificationId,index)

                if (isWebUri(url)) {
                    window.open(url, '_blank')
                }
            }
        }
    }
</script>