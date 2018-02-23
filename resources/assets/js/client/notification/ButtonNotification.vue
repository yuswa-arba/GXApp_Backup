<template>
<div>
    <a href="javascript:;" id="notification-center" class="header-icon pg pg-world"
       @click="openOrCloseNotificationList()">
        <span class="bubble hide"></span>
    </a>
</div>
</template>

<script type="text/javascript">
    import{mapState, mapGetters} from 'vuex'
    import {isNotificationListOpen,openNotificationList,closeNotificationList,hideNotificationBubble} from './utils/util'
    export default{
        created(){

        },
        methods: {
            openOrCloseNotificationList(){
                if(isNotificationListOpen()){

                    closeNotificationList() //UI

                } else {

                    openNotificationList() //UI

                    //get data
                    this.$store.commit({type:'notification/getNotificationList'})

                    hideNotificationBubble()
                }
            }
        }
    }
</script>