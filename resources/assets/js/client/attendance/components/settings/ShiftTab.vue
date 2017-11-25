<template>
    <div class="row">
        <div class="col-lg-8 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-350">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover settingDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black">Name</th>
                                        <th class="text-black">Time Start</th>
                                        <th class="text-black">Time End</th>
                                        <th class="text-black">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="index in 10">
                                        <td>8to17</td>
                                        <td>08:00</td>
                                        <td>17:00</td>
                                        <td>
                                            <i class="fs-14 fa fa-pencil pointer"></i>
                                            &nbsp; &nbsp;
                                            <i class="fs-14 text-danger fa fa-times pointer"></i>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        <div class="col-lg-4 m-b-10">
            <div class="card card-transparent">
                <div class="card-block">
                    <form id="shift-form">
                        <h4>Shift Form</h4>
                        <div>
                            <div class="row clearfix">
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label>Time Start</label>
                                        <div class="input-group bootstrap-timepicker">
                                            <input id="timestart" type="text" class="form-control">
                                            <span class="input-group-addon"><i class="pg-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group required">
                                        <label>Time End</label>
                                        <div class="input-group bootstrap-timepicker">
                                            <input id="timeend" type="text" class="form-control">
                                            <span class="input-group-addon"><i class="pg-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group  required">
                                <label>Shift name</label>
                                <input type="text" class="form-control" required>
                            </div>
                        </div>
                        <p>If time end is smaller than time start, the system will automatically registered it as a new date/tomorrow's date</p>
                        <button class="btn btn-complete pull-right" type="button">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../../../helpers/api'
    export default{
        created(){

        }
    }
</script>