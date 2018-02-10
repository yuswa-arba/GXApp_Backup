<template>
    <div class="row">
        <div class="alert alert-danger bottom-float-full" v-if="offline">
            <p>No Internet Connection</p>
        </div>
    </div>
</template>

<script>
    export default{
        data(){
            return {
                offline: false,
                lastHeartBeatReceivedAt: moment(),
            }
        },
        created(){
            this.listenToEcho()
            setInterval(this.determineConnectionStatus, 1000);
        },
        methods: {
            listenToEcho(){
                let self = this
                echo.channel('connection')
                    .listen('Components.Events.HeartBeat', (data) => {

                        self.lastHeartBeatReceivedAt = moment()

                    })
            },
            determineConnectionStatus() {

                const lastHeartBeatReceivedSecondsAgo = moment().diff(this.lastHeartBeatReceivedAt, 'seconds');
                this.offline = lastHeartBeatReceivedSecondsAgo > 125;

            },

        }
    }
</script>