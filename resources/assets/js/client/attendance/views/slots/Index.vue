<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <div class="pull-left m-r-15 m-b-10">
                <button class="btn btn-primary all-caps">Assign <i class="fa fa-plus"></i></button>
            </div>

            <div class="pull-right m-r-15 m-b-10">
                <div class="dropdown dropdown-default">
                    <button class="btn btn-outline-primary dropdown-toggle text-center" type="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Status: {{statusBy.name}}
                    </button>

                    <div class="dropdown-menu">
                        <a class="dropdown-item pointer" @click="sortBy(relatedBy.id,'')">
                            Show all</a>
                        <a class="dropdown-item pointer" @click="sortBy(relatedBy.id,'assigned')">
                            Assigned</a>
                        <a class="dropdown-item pointer" @click="sortBy(relatedBy.id,'unassigned')">
                            Unassigned
                        </a>
                    </div>

                </div>
            </div>

            <div class="pull-right m-r-15 m-b-10">
                <div class="form-group">
                    <select class="btn btn-outline-primary h-35 w-100" v-model="relatedBy.id"
                            @change="sortBy(relatedBy.id,statusBy.id)">
                        <option value="">Show all</option>
                        <option :value="jobPosition.id" v-for="jobPosition in jobPositions">{{jobPosition.name}}
                        </option>
                    </select>
                </div>
            </div>


        </div>
        <div class="col-lg-12 m-b-10">
            <div class="widget-11-2 card card-bordered card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="table-responsive">
                        <table class="table table-hover slotDT">
                            <thead class="bg-master-lighter">
                            <tr>
                                <th class="text-black">ID</th>
                                <th class="text-black">Name</th>
                                <th class="text-black">Order</th>
                                <th class="text-black">Allow Multiple</th>
                                <th class="text-black">Assigned to</th>
                                <th class="text-black">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="slot in slots" class="filter-item">
                                <td class="padding-10 p-l-15">{{slot.id}}</td>
                                <td class="padding-10 p-l-15">{{slot.name}}</td>
                                <td class="padding-10 p-l-15">{{slot.positionOrder}}</td>
                                <td class="padding-10 p-l-15">

                                    <p v-if="slot.allowMultipleAssign" class="text-primary bold">Yes</p>
                                    <p v-else class="text-danger bold">No</p>

                                </td>
                                <td class="padding-10">
                                    <span class="badge badge-important">25</span>
                                </td>
                                <td class="padding-10">
                                    <i class="fs-14 fa fa-calendar pointer" @click="viewSlotDetail(slot.id)"></i>
                                    &nbsp;
                                    <!--TODO: fix isTrue class binding with real data-->
                                    <i class="fs-14 fa fa-circle pointer" :class="{'text-complete':isTrue}" @click="assignSlot(slot.id)"></i>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <assign-slot-modal></assign-slot-modal>
    </div>
</template>

<script>
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    import AssignSlotModal from '../../components/slots/AssignSlotModal.vue'
    export default{
        components:{
            "assign-slot-modal":AssignSlotModal
        },
        data(){
            return {
                isTrue:true,
                relatedBy: {id: '', name: 'All'},
                statusBy: {id: '', name: 'All'},
                jobPositions: [],
                slots: []
            }
        },
        created(){
            let self = this

            get(api_path() + 'component/list/jobPosition')
                .then((res) => {
                    self.jobPositions = res.data.data
                })


            get(api_path() + 'attendance/slot/list')
                .then((res) => {
                    self.slots = res.data.data

                    // fix datatables Bug displaying "no data available"
                    if (!_.isEmpty(self.slots)) {
                        $('.dataTables_empty').hide()
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
        methods: {

            sortBy(relatedById, statusById){

                let self = this;

                //set value for display
                self.relatedBy.id = relatedById
                self.statusBy.id = statusById
                if (statusById == 'assigned') {
                    self.statusBy.name = 'Assigned'
                } else if (statusById == 'unassigned') {
                    self.statusBy.name = 'Unassigned'
                } else {
                    self.statusBy.name = 'All'
                }


                get(api_path() + 'attendance/slot/list?' + 'statusBy=' + statusById + '&relatedBy=' + relatedById)
                    .then((res) => {
                        self.slots = res.data.data

                        // fix datatables Bug displaying "no data available"
                        if (!_.isEmpty(self.slots)) {
                            $('.dataTables_empty').hide()
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

            viewSlotDetail(id){
                this.$router.push({name: 'detailSlot', params: {id: id}})
            },

            assignSlot(id){
                this.$bus.$emit('assign:slot', id)
            }

        }


    }
</script>