<template>
    <div class="modal fade stick-up" id="modal-shift-edit" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                            class="pg-close fs-14"></i>
                    </button>
                    <h5>Edit Shift </h5>

                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Select Shift</label>
                                    <select class="btn btn-outline-primary h-35 w-100"
                                            id="selectShift">
                                        <option value="" disabled selected>Select</option>
                                        <option v-if="shift.id!=1"
                                                :selected="shift.id==selectedShiftDetail.id"
                                                :value="shift.id"
                                                v-for="shift in shifts">
                                            {{shift.name}} ({{shift.workStartAt}} - {{shift.workEndAt}})
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox check-success ">
                                    <input type="checkbox" v-model="deleteShift" id="deleteShiftEventCb">
                                    <label for="deleteShiftEventCb">Remove Shift</label>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="row">
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5"
                                    @click="save(selectedShiftDetail.slotShiftScheduleId)">
                                Save
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</template>

<script>
    import {mapGetters, mapState} from 'vuex'

    export default{
        data(){
            return {
                deleteShift: false,
                selectShiftId: ''
            }
        },
        created(){

        },
        computed: {
            ...mapGetters('slots', {
                shifts: 'shifts',
                selectedShiftDetail: 'selectedShiftDetail'
            })
        },
        mounted(){

        },
        methods: {
            save(slotShiftScheduleId){
                let self = this
                if (this.deleteShift) {
                    this.$store.dispatch({
                        type: 'slots/removeShift',
                        id: slotShiftScheduleId
                    })

                    //reset check box
                    this.deleteShift = false
                } else {

                    self.selectShiftId = $('#selectShift').val()

                    if (self.selectShiftId) {
                        this.$store.dispatch({
                            type: 'slots/editShift',
                            slotShiftScheduleId: slotShiftScheduleId,
                            shiftId: self.selectShiftId,

                        })

                        //reset form
                        self.selectShiftId = ''
                    } else {
                        $('#modal-shift-edit').modal('toggle')
                    }
                }
            }
        }
    }
</script>