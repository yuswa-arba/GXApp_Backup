<template>
    <div class="row">
        <div class="col-lg-12 m-b-20">
            <router-link to="/failedJobs" class="btn btn-primary">Checking Failed Jobs</router-link>
        </div>

        <!-- START card -->
        <div class="card card-default bg-white">
            <div class="card-header">
                <div class="col-md-12">
                    <div class="card-title">Queue Jobs</div>
                    <button class="btn btn-danger btn-cons m-l-5" @click="deleteAll()"><i class="fa fa-trash-o"></i>
                        Delete All
                    </button>
                    <div class="pull-right">
                        <div class="col-xs-12">
                            <input type="text" class="form-control pull-right" placeholder="Search">
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="card-block">
                <div class="table-responsive">
                    <table class="table table-hover demo-table-search " id="tableWithSearch">
                        <thead>
                        <tr>
                            <th>ID Queue</th>
                            <th>Queue</th>
                            <th>Payload</th>
                            <th>Attempts</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="ee in resultData">
                            <td>{{ ee.id }}</td>
                            <td>{{ ee.queue }}</td>
                            <td>{{ ee.payload }}</td>
                            <td>{{ ee.attempts }}</td>
                            <td>
                                <button class="btn btn-danger btn-xs m-t-10" @click="deleteId(ee.id)">Delete</button>
                                <!--<button class="btn btn-complete btn-xs m-t-10">Tried</button>-->
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- END card -->
    </div>

</template>
<script type="text/javascript">
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                resultData: {}
            }
        },
        watch: {
            '$route': ['getData']
        },
        created() {

        },
        mounted (){
            setInterval(this.getData, 100)
        },
        components: {},
        methods: {
            getData(){
                get(api_path+'developer/queue/job/list')
                    .then((response) => {
                        this.resultData = response.data;
                    })
            },
            retryId(id, queue){
                get(api_path+'developer/queue/retry/job?id='+id+'&queue='+queue)
                    .then((response) => {
                        this.getData();
                    })
            },
            deleteId(id){
                get(api_path+'developer/queue/delete/job?id='+id)
                    .then((response) => {
                        this.getData();
                        this.notify('ID ' + id + ' Successfully deleted!');
                    })
            },
            deleteAll(){
                if (confirm("Are you sure ?")) {
                    get(api_path+'developer/queue/delete/job')
                        .then((respond) => {
                            this.getData();
                            this.notify('Successfully Deleted!');
                        })
                }
            },
            notify(mess){
                $('body').pgNotification({
                    style: 'flip',
                    message: mess,
                    position: 'top-right',
                    timeout: 2000,
                    type: 'success'
                }).show();
            }
        }

    }
</script>