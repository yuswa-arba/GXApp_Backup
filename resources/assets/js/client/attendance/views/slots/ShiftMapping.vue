<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <slot name="go-back-menu"></slot>

        </div>
        <div class="col-lg-3 m-b-10 padding-10 bg-white">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p class="padding-5 text-danger bold fs-16" v-if="isProcessing">
                        Processing.. Please wait..
                    </p>
                    <div class="clearfix"></div>
                    <h5 class="f-w-400">Slot List</h5>
                    <label class="help fs-12 m-b-20" style="line-height: 15px">Click on the slot button below <br> to
                        toggle view in calendar</label>
                </div>

                <div class="col-lg-12  text-center" v-for="(slot,index) in cbSlotsBeingMap">
                    <button class="btn fs-12 m-b-5 cursor overflow-ellipsis bold text-white"
                            :style="{background:'#'+shiftMapPalette[index]}"
                            @click="sortCalendarBySlot(slot.id)">
                        {{slot.name}}
                    </button>
                    <!--<i class="fa fa-clock-o cursor fs-24 p-l-5" :style="{color:'#'+shiftMapPalette[index]}"></i>-->
                </div>
            </div>

        </div>
        <div class="col-lg-9 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block padding-30">
                    <div id="calendar-shift-mapping"></div>
                </div>
            </div>
        </div>
        <assign-shift-modal></assign-shift-modal>
        <edit-shift-modal></edit-shift-modal>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import waterfall from 'async/waterfall';
    import series from 'async/series';
    import AssignShiftModal from '../../components/slots/AssignShiftModal.vue'
    import EditShiftModal from '../../components/slots/EditShiftModal.vue'
    export default{
        created(){

            if (_.isEmpty(this.$store.state.slots.slotsBeingMap)) {
                this.$router.push('/')
            }
        },
        components: {
            'assign-shift-modal': AssignShiftModal,
            'edit-shift-modal': EditShiftModal
        },
        data(){
            return {
                isProcessing: false,
                slotIdsBeingMap: _.map(this.$store.state.slots.slotsBeingMap, 'id'),
            }
        },
        computed: {
            ...mapGetters('slots', {
                cbSlotsBeingMap: 'cbSlotsBeingMap',
                shiftMapPalette: 'shiftMapPalette'
            })
        },
        methods: {
            sortCalendarBySlot(slotId){
                let self = this

                waterfall([
                    function (cb) {
                        self.isProcessing = true
                        cb(null)
                    },
                    function (cb) {
                        /* Pluck & Insert Logic to simluate toggle*/
                        let affectedCbIndex = _.findIndex(self.slotIdsBeingMap, function (o) {
                            return o == slotId
                        })

                        if (affectedCbIndex != -1) {
                            self.slotIdsBeingMap.splice(affectedCbIndex, 1, 'plucked_' + slotId)
                        }

                        else {
                            let pluckedCbIndex = _.findIndex(self.slotIdsBeingMap, function (o) {
                                return o == 'plucked_' + slotId
                            })
                            self.slotIdsBeingMap.splice(pluckedCbIndex, 1, slotId)
                        }


                        cb(null)
                    },
                    function (cb) {
                        setTimeout(function () {
//                            let filterCalendar = _.filter(self.$store.state.slots.calendarShiftMappingEventSource, {slotId: slotId})
//
//                            _.forEach(filterCalendar, function (value, key) {
//                                $('#calendar-shift-mapping').fullCalendar('removeEvents', value.id)
//                            })

                            self.$store.dispatch({
                                type: 'slots/startShiftMapping',
                                slotIds: self.slotIdsBeingMap,
                                refreshCb: false, //do not refresh checkboxes
                                affectedCbSlotId: slotId
                            })

                            cb(null)
                        }, 2000)

                    }
                ], function (err, result) {
                    self.isProcessing = false
                })
            }
        },
        mounted(){
            let self = this

            $('#calendar-shift-mapping').fullCalendar({
                header: {
                    left: 'prev,next today removeSource',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                selectable: true,
                selectHelper: true,
                timeFormat: 'H:mm',
                select: function (start, end) {
                    console.log((moment(start).format('DD/MM/YYYY')))
                    console.log((moment(end).format('DD/MM/YYYY')))

                    self.$store.dispatch({
                        type: 'slots/attemptAssignShift',
                        dateStartToAssign: moment(start).format('DD/MM/YYYY'),
                        dateEndToAssign: moment(end).subtract(1, 'days').format('DD/MM/YYYY')
                    })
                },
                eventRender: function (event, element, view) {
                    element.on('click', function () {

                        if (event.eventType == 'shiftSchedule') {

                            series([
                                function (cb) {
                                    self.$store.dispatch({
                                        type: 'slots/getShiftDetail',
                                        shiftId: event.shiftId,
                                        slotShiftScheduleId: event.id,
                                        calendarEvent:event
                                    })

                                    cb(null)
                                },
                                function (cb) {
                                    $('#modal-shift-edit').modal('show')
                                    cb(null)
                                }
                            ])

                        }

//
//                        console.log(event.slotId)
//                        console.log(moment(event.start).format('DD/MM/YYYY'))
                    })
                },
            })
        },
    }
</script>