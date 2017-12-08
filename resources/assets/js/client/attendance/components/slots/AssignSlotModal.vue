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
                                            {{slot.name}}
                                        </div>
                                        <ul class="filter-search-employee-item" v-for="employee in employees">
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
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                employees: [],
                slot: {}
            }
        },
        created(){
            let self = this

            self.$bus.$on('assign:slot', function (id) {

                // get slot detail
                get(api_path() + 'component/slot/' + id)
                    .then((res) => {
                        self.slot = res.data.data
                    })
                    .catch((err) => {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
                            position: 'top-right',
                            timeout: 0,
                            type: 'danger'
                        }).show();
                    })

                // get employee list detail
                get(api_path() + 'attendance/slot/assign/employee?slotId=' + id)
                    .then((res) => {

                        self.employees = res.data.data

                    })
                    .catch((err) => {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
                            position: 'top-right',
                            timeout: 0,
                            type: 'danger'
                        }).show();
                    })


                // show modal if data is not empty
                if (!_.isEmpty(self.employees)) {
                    $('#assignSlotModal').modal('show')
                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: "Unable to find employees data for this slot",
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }

            })

        },
        methods: {},
        mounted(){
            // Search using Sieve plugins
            $('#filter-search-employee-container').sieve({
                searchInput: $('#search-employee-box'),
                itemSelector: ".filter-search-employee-item"
            })
        }
    }
</script>