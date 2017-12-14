<template>
    <div class="modal fade slide-up disable-scroll" id="modal-mapping-shift" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="pg-close fs-14"></i>
                        </button>
                        <h5>Shift Mapping</h5>
                        <p class="p-b-10">We need payment information inorder to process your order</p>
                    </div>
                    <div class="modal-body">
                        <form role="form">
                            <div class="form-group-attached">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Select Slot</label>
                                            <select class="btn btn-outline-primary h-35 w-100">
                                                <option value="" disabled selected>Select</option>
                                                <option :value="slot.id"
                                                        v-for="slot in slotsBeingMap">
                                                    {{slot.name}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Date Start</label>
                                            <input id="dateStart"
                                                   type="text"
                                                   class="form-control"
                                                   :value="dateStartToAssign">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Date End</label>
                                            <input id="dateEnd"
                                                   type="text"
                                                   class="form-control"
                                                   :value="dateEndToAssign">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </form>
                        <div class="row">
                            <div class="col-md-8">

                            </div>
                            <div class="col-md-4 m-t-10 sm-m-t-10">
                                <button type="button" class="btn btn-primary btn-block m-t-5">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</template>

<script>
    import {mapGetters, mapState} from 'vuex'

    export default{
        data(){
            return {
                selectedSlotToAssign: {},
                selectedDateStart: '',
                selectedDateEnd: ''
            }
        },
        created(){

        },
        computed: {
            ...mapGetters('slots', {
                slotsBeingMap: 'slotsBeingMap',
                dateStartToAssign: 'dateStartToAssign',
                dateEndToAssign: 'dateEndToAssign'
            })
        },
        mounted(){
            $('#dateStart').datepicker({format: 'dd/mm/yyyy', todayHighlight: false});
            $('#dateEnd').datepicker({format: 'dd/mm/yyyy', todayHighlight: false});
        },

        methods: {},
    }
</script>