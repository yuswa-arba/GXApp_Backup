<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <!--<div class="pull-left m-r-15 m-b-10">-->
            <!--<button class="btn btn-primary all-caps">Calendar <i class="fa fa-calendar"></i></button>-->
            <!--</div>-->
            <div class="pull-left m-r-15 m-b-10">
                <button class="btn btn-info all-caps" @click="shiftMapping()">Shift Mapping <i
                        class="fa fa-clock-o"></i></button>
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

            <div class="pull-right m-r-15 m-b-10">
                <div class="checkbox check-success ">
                    <input id="cbGetOnlyCurrYear" type="checkbox" v-model="getOnlyCurrentYear"
                           @change="sortByOnCbClick()">
                    <label for="cbGetOnlyCurrYear">Get only current year</label>
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
                                <th class="text-black">Job Related</th>
                                <th class="text-black" style="width: 100px;">Allow Multiple</th>
                                <th class="text-black" style="width: 100px">Assigned to</th>
                                <th class="text-black" style="width: 100px">Shift Option</th>
                                <th class="text-black" style="width:120px">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="slot in slots" class="filter-item">
                                <td class="padding-10 p-l-15">{{slot.id}}</td>
                                <td class="padding-10 p-l-15">{{slot.name}}</td>
                                <td class="padding-10 p-l-15">{{slot.positionOrder}}</td>
                                <td class="padding-10 p-l-15">
                                        <span v-if="slot.slotMaker.job_position&&slot.slotMaker.relatedToJobPosition">
                                            {{slot.slotMaker.job_position.name}}
                                        </span>
                                    <span v-else="">-</span>
                                </td>
                                <td class="padding-10 p-l-15">

                                    <p v-if="slot.allowMultipleAssign" class="text-primary bold">Yes</p>
                                    <p v-else class="text-danger bold">No</p>

                                </td>
                                <td class="padding-10">
                                    <!--if its general slot show 'Default'-->
                                    <span v-if="slot.id==1">
                                        Default
                                    </span>
                                    <span v-else-if="slot.assignedTo.total==1&&slot.assignedTo.name!=null">{{slot.assignedTo.name}}</span>
                                    <span v-else="" class="badge badge-important">{{slot.assignedTo.total}}</span>


                                </td>
                                <td class="padding-10">
                                    <div class="dropdown dropdown-default" v-if="slot.id!=1">
                                        <button class="btn btn-xs btn-outline-primary dropdown-toggle text-center"
                                                type="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                            <span v-if="slot.isUsingMapping">Mapping</span>
                                            <span v-else="">Default</span>

                                        </button>

                                        <div class="dropdown-menu">
                                            <a class="dropdown-item pointer" @click="editShiftOption(slot.id,0)">
                                                Use Default</a>
                                            <a class="dropdown-item pointer" @click="editShiftOption(slot.id,1)">
                                                Use Mapping </a>
                                        </div>

                                    </div>

                                </td>
                                <td class="padding-10">

                                    <i class="fs-14 fa fa-calendar pointer" @click="viewSlotDetail(slot.id)"></i>
                                    &nbsp;
                                    <!--if its not general then show assign button-->
                                    <i v-if="slot.id!=1"
                                       class="fs-14 fa fa-circle pointer"
                                       :class="{'text-complete':slot.availableForAssign}"
                                       @click="assignSlot(slot.id)"
                                       @dblclick.prevent=""></i>

                                    &nbsp;
                                    <!--if its not general then show delete button-->
                                    <i v-if="slot.id!=1"
                                       class="fs-14 fa fa-times text-danger pointer"
                                       @click="deleteSlot(slot.id)"
                                       @dblclick.prevent=""
                                    ></i>
                                    &nbsp;
                                    <!--if its not general then show copy button-->
                                    <i v-if="slot.id!=1"
                                       class="fs-14 fa fa-clipboard pointer"
                                       @click="copySlot(slot.id,slot.name)"
                                       @dblclick.prevent=""
                                    ></i>


                                </td>

                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <assign-slot-quickview></assign-slot-quickview>
        <attempt-shift-mapping-modal></attempt-shift-mapping-modal>
        <attempt-copy-slot-modal></attempt-copy-slot-modal>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import AssignSlotQuickview from '../../components/slots/AssignSlotQuickview.vue'
    import AttemptShiftMappingModal from '../../components/slots/AttemptShiftMappingModal.vue'
    import AttemptCopySlotModal from '../../components/slots/AttemptCopySlotModal.vue'
    export default{
        components: {
            "assign-slot-quickview": AssignSlotQuickview,
            "attempt-shift-mapping-modal": AttemptShiftMappingModal,
            "attempt-copy-slot-modal" : AttemptCopySlotModal
        },
        data(){
            return {
                isTrue: true,
                getOnlyCurrentYear: true,
                relatedBy: {id: '', name: 'All'},
                statusBy: {id: '', name: 'All'},
            }
        },
        computed: {
            ...mapGetters('slots', {
                jobPositions: 'jobPositions',
                slots: 'slots'
            })
        },
        created(){
            this.$store.dispatch('slots/getDataOnCreate')
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

                // checkbox model
                let getCurYearParam = 0
                if(self.getOnlyCurrentYear){
                    getCurYearParam = 1
                }

                // get slot data
                this.$store.commit({
                    type: 'slots/getSlots',
                    statusById: statusById,
                    relatedById: relatedById,
                    getOnlyCurrentYear:getCurYearParam
                })

            },
            sortByOnCbClick(){

                let self = this;

                // checkbox model
                let getCurYearParam = 0
                if(self.getOnlyCurrentYear){
                    getCurYearParam = 1
                }

                // get slot data
                this.$store.commit({
                    type: 'slots/getSlots',
                    statusById: self.statusBy.id,
                    relatedById: self.relatedBy.id,
                    getOnlyCurrentYear: getCurYearParam
                })

            },

            viewSlotDetail(id){
                this.$router.push({name: 'detailSlot', params: {id: id}})
            },
            assignSlot(slotId){
                this.$store.dispatch('slots/getDataOnAssignSlot', slotId)
            },
            deleteSlot(slotId){
                if(confirm("Are you sure to delete this slot?")){
                    this.$store.commit('slots/deleteSlot',slotId)
                }
            },
            copySlot(slotId,slotName){
              this.$store.dispatch({
                  type:'slots/attemptCopySlot',
                  slotId:slotId,
                  slotName:slotName
              });
            },
            shiftMapping(){
                this.$store.dispatch('slots/attempShiftMapping')
            },
            editShiftOption(slotId, isUsingMapping){

                this.$store.dispatch({
                    type: 'slots/editSlotUseMapping',
                    slotId: slotId,
                    isUsingMapping: isUsingMapping
                })
            }

        }


    }
</script>