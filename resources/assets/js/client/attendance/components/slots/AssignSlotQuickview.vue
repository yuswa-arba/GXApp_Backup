<template>
    <div class="quickview-wrapper" id="assignSlotQuickView">
        <div class="view-port clearfix">
            <div class="view bg-white">
                <div class="padding-10">
                    <p class="text-primary fs-16 pull-left padding-10">
                        Assign Slot
                    </p>
                    <a class="pg-close text-master link pull-right padding-10" data-toggle="quickview"
                       data-toggle-element="#assignSlotQuickView" href="#"></a>

                    <div class="navbar navbar-default navbar-sm m-b-0 p-b-20">
                        <div class="navbar-inner">
                            <div class="input-group transparent">
                                            <span class="input-group-addon">
                                                <i class="fa fa-search"></i>
                                            </span>
                                <input id="search-employee-box" type="text"
                                       placeholder="Name / Employee No / Job Position"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="list-view boreded no-top-border" id="filter-search-employee-container">
                        <div class="list-view-group-container">
                            <div class="list-view-group-header text-uppercase">
                                {{slotDetail.name}}
                            </div>
                            <div class="scrollable">
                                <ul class="filter-search-employee-item" v-for="employee in employeesToBeAssigned">
                                    <li class="alert-list p-l-5">
                                        <a href="javascript:;" class="align-items-center">
                                            <p class="">
                                                        <span class="text-complete fs-10"
                                                              :class="{'text-complete':!employee.hasSlotSchedule,'text-disabled':employee.hasSlotSchedule}"
                                                        >
                                                            <i class="fa fa-circle"></i>
                                                        </span>
                                            </p>
                                            <p class="p-l-10 overflow-ellipsis fs-14 max-w-150">
                                                <span class="text-master">
                                                    {{employee.name}}
                                                </span>
                                                <br>
                                                <span v-if="employee.hasSlotSchedule" class="fs-11 text-master link">
                                                    {{employee.slotSchedule.name}}
                                                </span>
                                            </p>


                                            <label class="label m-t-10 p-b-5 ml-auto fs-12 cursor"
                                                   v-if="employee.hasSlotSchedule">
                                                Remove
                                            </label>

                                            <label class="label label-success m-t-10 p-b-5 ml-auto fs-12 cursor"
                                                   v-else="" @click="assign(employee.id,slotDetail.id)">
                                                Assign
                                            </label>

                                        </a>
                                        <!--hidden input to be searched-->
                                        <span class="hidden">{{employee.employeeNo}}</span>
                                        <span class="hidden">{{employee.jobPosition}}</span>
                                    </li>


                                </ul>

                            </div>

                        </div>

                    </div>


                </div>
            </div>

        </div>
    </div>

    <!-- /.modal-dialog -->
</template>

<script>
    import {mapGetters} from 'vuex'
    export default{

        created(){

        },
        computed: {
            ...mapGetters('slots', {
                employeesToBeAssigned: 'employeesToBeAssigned',
                slotDetail: 'slotDetail'
            })
        },
        mounted(){
            // Search using Sieve plugins
            $('#filter-search-employee-container').sieve({
                searchInput: $('#search-employee-box'),
                itemSelector: ".filter-search-employee-item"
            })
        },

        methods: {
            assign(employeeId, slotId){
                this.$store.dispatch({
                    type: 'slots/assignSlotToEmployee',
                    employeeId: employeeId,
                    slotId: slotId
                })
            }
        },
    }
</script>