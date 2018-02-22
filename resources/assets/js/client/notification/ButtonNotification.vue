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
    import {isNotificationListOpen,openNotificationList,closeNotificationList} from './utils/util'
    export default{
        created(){

        },
        methods: {
            openOrCloseNotificationList(){
                if(isNotificationListOpen()){
                    closeNotificationList()
                } else {
                    openNotificationList()
                }
            }
        }
    }
</script>