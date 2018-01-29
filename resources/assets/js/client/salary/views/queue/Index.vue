<template>
    <div class="row">
        <div class="col-lg-12">

            <div class="card card-bordered">

                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="pull-left">Salary Queue</h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="pull-right">
                                <button class="btn btn-complete" @click="createQueue()"><i class="fa fa-plus"></i>
                                    Create Queue
                                </button>
                                <button class="btn btn-primary" @click="calculateAllQueue()"><i
                                        class="fa fa-calculator"></i> Calculate All
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
                                    <tr v-for="queue in salaryQueues">
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
                                                <button class="btn btn-outline-primary"
                                                        @click="calculateQueue(queue.id)"><i class="fa fa-plus"></i>
                                                    Calculate
                                                </button>
                                                <button class="btn btn-outline-danger" @click="deleteQueue(queue.id)"><i
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
    </div>
</template>
<script type="text/javascript">
    import{mapState, mapGetters} from 'vuex'
    export default{
        components: {
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
            calculateQueue(id){
                console.log(id)
            },
            deleteQueue(id){
                console.log(id)
            },
            calculateAllQueue(){

            },
            deleteAllQueue(){

            },
            createQueue(){
                this.$router.push({name:'createQueue'})
            }
        }
    }
</script>