<template>
    <div class="modal fade stick-up" id="modal-attempt-copy-slot" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        <i class="pg-close"></i>
                    </button>
                    <!--<div id="mh-role"></div>-->
                    <h5 class="text-left dark-title p-b-5">Copy Slot</h5>
                </div>
                <div class="modal-body">
                    <form role="form">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Copy from </label>
                                    <h4 class="no-margin">{{copyFromSlotName}}</h4>
                                </div>
                                <div class="form-group">
                                    <label>Copy to </label>
                                    <p class="text-danger fs-12" v-if="slotNameEmpty">Slot name cannot be empty</p>
                                    <input type="text" :placeholder="defaultCopiedSlotName + ' or add last number by 1'" class="form-control"
                                           v-model="copyToName">
                                </div>
                                <div class="form-group">
                                    <label>Add days by: </label> <span class="help fs-12">(Day off add by _ from the source being copied)</span>
                                    <p class="text-danger fs-12" v-if="addDayEmpty">Add day cannot be empty</p>
                                    <input type="number" min="0" placeholder="Enter Slot Name" class="form-control"
                                           v-model="copyAddBy">
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-8">

                        </div>
                        <div class="col-md-4 m-t-10 sm-m-t-10">
                            <button type="button" class="btn btn-primary btn-block m-t-5" @click="copySlotNow()">
                                Copy
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
                copyToName: '',
                copyAddBy:0,
                slotNameEmpty: false,
                addDayEmpty:false,

            }
        },
        created(){
            let self = this
        },
        computed: {
            ...mapState('slots', {
                copyFromSlotId: 'copyFromSlotId',
                copyFromSlotName: 'copyFromSlotName'
            }),
            ...mapGetters('slots',{
                defaultCopiedSlotName:'defaultCopiedSlotName'
            })
        },
        mounted(){

        },

        methods: {

            closeModal(){
                $('#modal-attempt-copy-slot').modal("toggle"); // close modal
            },
            copySlotNow(){
                let self = this

                /* Reset error */
                self.slotNameEmpty = false
                self.addDayEmpty = false

                /* Check name */
                if (self.copyToName=='') {
                    self.slotNameEmpty = true
                }

                /* Check add by */
                if (self.copyAddBy=='' && self.copyAddBy!=0) {
                    self.addDayEmpty = true
                }

                /* All field is filled*/
                if(!self.addDayEmpty && !self.slotNameEmpty){
                    self.$store.dispatch({
                        type:'slots/startCopySlot',
                        slotName:self.copyToName,
                        addBy:self.copyAddBy
                    })
                }


            }

        },
    }
</script>