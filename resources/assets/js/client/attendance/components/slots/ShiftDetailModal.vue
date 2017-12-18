<template>
    <div class="modal fade stick-up" id="modal-shift-detail" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                            class="pg-close fs-14"></i>
                    </button>
                    <h5>Shift Detail <b>{{selectedShiftDetail.name}}</b></h5>

                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Work Start</label>
                                    <input type="text"
                                           class="form-control text-black"
                                           :value="selectedShiftDetail.workStartAt"
                                           readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Work End</label>
                                    <input type="text"
                                           class="form-control text-black"
                                           :value="selectedShiftDetail.workEndAt"
                                           readonly>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="checkbox check-success " >
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
                deleteShift:false
            }
        },
        created(){

        },
        computed: {
            ...mapGetters('slots', {
                selectedShiftDetail: 'selectedShiftDetail'
            })
        },
        mounted(){

        },
        methods: {
            save(id){
                if(this.deleteShift){
                    this.$store.dispatch({
                        type:'slots/removeShift',
                        id:id
                    })

                    //reset check box
                    this.deleteShift=false
                } else {
                    $('#modal-shift-detail').modal('toggle')
                }
            }
        }
    }
</script>