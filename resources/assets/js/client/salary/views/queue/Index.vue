<template>
    <div class="row">
        <div class="col-lg-12">

            <div class="card card-bordered">

                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="pull-left">Salary Queue <i class="fa fa-question-circle fs-16 cursor" style="opacity: 0.7" @click="salaryQueueHelp()"></i></h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="pull-right">
                                <button class="btn btn-primary" @click="createQueue()"><i class="fa fa-plus"></i>
                                    Create Queue
                                </button>
                                <button class="btn btn-danger" @click="deleteAllQueue()"><i class="fa fa-trash"> Delete
                                    All</i></button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="scrollable">
                        <div style="height: 600px">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black p-t-5 p-b-5">ID</th>
                                        <th class="text-black p-t-5 p-b-5">Employee</th>
                                        <th class="text-black p-t-5 p-b-5">Bonus/Cut</th>
                                        <th class="text-black p-t-5 p-b-5">Value</th>
                                        <th class="text-black p-t-5 p-b-5">Notes</th>
                                        <th class="text-black p-t-5 p-b-5">Inserted</th>
                                        <th class="text-black p-t-5 p-b-5"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(queue,index) in salaryQueues">
                                        <td>{{queue.id}}</td>
                                        <td>{{queue.employeeName}}({{queue.divisionName}})</td>
                                        <td>{{queue.salaryBonusCutTypeName}}
                                            <label class="label label-success"
                                                   v-if="queue.salaryBonusCutTypeAddOrSub=='add'">Add</label>
                                            <label class="label label-danger"
                                                   v-else-if="queue.salaryBonusCutTypeAddOrSub=='sub'">Sub</label>
                                            <label v-else=""></label>
                                        </td>
                                        <td>{{queue.value}}</td>
                                        <td>{{queue.notes}}</td>
                                        <td>@<b>{{queue.insertedDate}}</b> by <b>{{queue.insertedBy}}</b></td>
                                        <td>
                                            <div>
                                                <button class="btn btn-outline-danger" @click="deleteQueue(queue.id,index)"><i
                                                        class="fa fa-trash"></i>
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <salary-queue-help-modal></salary-queue-help-modal>
    </div>
</template>
<script type="text/javascript">
    import{mapState, mapGetters} from 'vuex'
    import SalaryQueueHelpModal from '../../components/queue/SalaryQueueHelpModal.vue'
    export default{
        components: {
           'salary-queue-help-modal':SalaryQueueHelpModal
        },
        mounted(){

        },
        computed: {
            ...mapState('queue', {
                salaryQueues: 'salaryQueues'
            })
        },
        created(){
            this.$store.commit('queue/getSalaryQueueList')
        },
        methods: {
            deleteQueue(salaryQueueId,index){

                if(confirm('Are you sure to delete this salary queue?')){

                    if(salaryQueueId!=null&&index!=null){
                        this.$store.commit({
                            type:'queue/deleteSalaryQueue',
                            salaryQueueId:salaryQueueId,
                            index:index
                        })
                    } else {
                         $('.page-container').pgNotification({
                              style: 'flip',
                              message: 'An Error Occurred!',
                              position: 'top-right',
                              timeout: 3500,
                              type: 'danger'
                          }).show();
                    }
                }


            },
            deleteAllQueue(){
                if(confirm('[WARNING] Are you sure to delete ALL salary queues?')){
                    this.$store.commit({
                        type:'queue/deleteAllSalaryQueue'
                    })
                }
            },
            createQueue(){
                this.$router.push({name:'createQueue'})
            },
            salaryQueueHelp(){
                $('#modal-salary-queue-help').modal('show')
            }
        }
    }
</script>