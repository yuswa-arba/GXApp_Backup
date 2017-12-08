<template>
    <div class="modal fade slide-right" id="assignSlotModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                            class="pg-close fs-14 p-t-10"></i>
                    </button>
                    <div class="container-xs-height full-height">
                        <div class="row-xs-height">
                            <div class="modal-body text-center padding-10">
                                <div class="navbar navbar-default navbar-sm m-b-0" style="padding: 25px 0">
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
                                            {{slotAssignModal.name}}
                                        </div>
                                        <ul class="filter-search-employee-item" v-for="employee in employeesToBeAssigned">
                                            <li class="alert-list">
                                                <a href="javascript:;" class="align-items-center">
                                                    <p class="">
                                                        <span class="text-complete fs-10"
                                                              :class="{'text-complete':!employee.hasSlotSchedule,'text-disabled':employee.hasSlotSchedule}"
                                                        >
                                                            <i class="fa fa-circle"></i>
                                                        </span>
                                                    </p>
                                                    <p class="p-l-10 overflow-ellipsis fs-12 max-w-150">
                                                        <span class="text-master">{{employee.name}}</span>
                                                    </p>


                                                    <select class="btn btn-disabled p-r-10 ml-auto fs-12"
                                                            v-if="employee.hasSlotSchedule">
                                                        <option value="" selected hidden disabled>Assigned</option>
                                                        <option value="">Remove</option>
                                                    </select>

                                                    <select class="btn btn-outline-primary p-r-10 ml-auto fs-12"
                                                            v-else="">
                                                        <option value="" selected disabled hidden>Select</option>
                                                        <option value="">Assign</option>
                                                    </select>

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
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</template>

<script>
    import {mapGetters} from 'vuex'
    export default{

        created(){

        },
        computed:{
            ...mapGetters('slots',{
                employeesToBeAssigned:'employeesToBeAssigned',
                slotAssignModal:'slotAssignModal'
            })
        },
        mounted(){
            // Search using Sieve plugins
            $('#filter-search-employee-container').sieve({
                searchInput: $('#search-employee-box'),
                itemSelector: ".filter-search-employee-item"
            })
        },

        methods: {},
    }
</script>