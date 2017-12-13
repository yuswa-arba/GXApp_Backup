<template>
    <div class="modal fade stick-up" id="modal-attempt-shift-mapping" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <h5 class="text-left dark-title p-b-5">Shifts Mapping</h5>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox check-success  ">
                                    <input type="checkbox" :value="true" id="same-parent-cb"
                                           v-model="withSameParent" @change="getSlotsCb">
                                    <label for="same-parent-cb">With same parent</label>
                                </div>
                                <div class="form-group">
                                    <label>Select Parent</label>
                                    <select class="btn btn-outline-primary h-35 w-100"
                                            v-model="selectedOptions"
                                            :disabled="!withSameParent"
                                            @change="getSlotsCb()">
                                        <option value="" disabled selected>Select</option>
                                        <option :value="{slotMakerId:slotMaker.id,jobPositionId:slotMaker.jobPositionId}"
                                                v-if="slotMaker.id!=1"
                                                v-for="slotMaker in slotMakers">
                                            {{slotMaker.name}}
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label> Job Position</label>
                                    <select class="btn btn-outline-primary h-35 w-100"
                                            :disabled="withSameParent"
                                            v-model="selectedOptions.jobPositionId"
                                            @change="getSlotsCb()">
                                        <option value="" disabled hidden selected>Select</option>
                                        <option :value="jobPosition.id"
                                                v-for="jobPosition in jobPositions">
                                            {{jobPosition.name}}
                                        </option>
                                    </select>
                                </div>
                                <div class="checkbox check-success " v-for="slot in cbMappingSlots">
                                    <input type="checkbox" :value="slot.id" v-model="selectedSlots"
                                           :id="'cbSlot'+slot.id">
                                    <label :for="'cbSlot'+slot.id">{{slot.name}}</label>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" @click="startMapping()">
                                Start Mapping
                            </button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <!-- /.modal-dialog -->
</template>

<script>
    import {mapGetters, mapState} from 'vuex'

    export default{
        data(){
            return {
                withSameParent: true,
                selectedOptions: {},
                slotsCb: [],
                selectedSlots: []
            }
        },
        created(){
        },
        computed: {
            ...mapGetters('slots', {
                jobPositions: 'jobPositions',
                slotMakers: 'slotMakers',
                cbMappingSlots: 'cbMappingSlots'
            }),
        },
        mounted(){

        },

        methods: {
            startMapping(){
                let self = this

                if (!this.withSameParent) {
                    delete this.selectedOptions.slotMakerId
                }

                if (!_.isEmpty(this.selectedSlots)) {

                    // close modal
                    self.closeModal()

                    this.$store.dispatch({
                        type: 'slots/starShiftMapping',
                        slotIds: self.selectedSlots,
                        refreshCb:true // get checkboxes first time
                    })


                    this.$router.push({name: 'shiftMapping'})


                } else {
                    $('.page-container').pgNotification({
                        style: 'bar',
                        message: "Unable to start mapping, slot is empty",
                        position: 'bottom',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }


            },
            closeModal(){
                $('#modal-attempt-shift-mapping').modal("toggle"); // close modal
            },
            getSlotsCb(){

                let self = this

                // reset first time so it wont duplicatd
                self.selectedSlots = []

                if (this.withSameParent) {
                    this.$store.dispatch({
                        type: 'slots/getSlotsMapping',
                        by: 'withSameParent',
                        slotMakerId: this.selectedOptions.slotMakerId,
                        jobPositionId: this.selectedOptions.jobPositionId
                    })
                } else {
                    this.$store.dispatch({
                        type: 'slots/getSlotsMapping',
                        jobPositionId: this.selectedOptions.jobPositionId
                    })
                }

                // push result to local selected slots
                _.forEach(this.$store.state.slots.cbMappingSlots, function (value, key) {
                    self.selectedSlots.push(value.id)
                })


            }

        },
    }
</script>