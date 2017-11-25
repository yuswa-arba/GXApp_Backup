<template>
    <div class="row">
        <div class="col-lg-8 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <!--<div class="card-header"></div>-->
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-350">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-text-center settingDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black">Date</th>
                                        <th class="text-black">Name</th>
                                        <th class="text-black">General</th>
                                        <th class="text-black">Religion</th>
                                        <th class="text-black">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="index in 10">
                                        <td>23/12/2017</td>
                                        <td>Lorem ipsum lorem ipsum lorem ipsum</td>
                                        <td>
                                            <i class="fs-16 text-complete fa fa-check"></i>
                                        </td>
                                        <td> Kristen</td>
                                        <td>
                                            <i class="fs-14 fa fa-pencil pointer"></i>
                                            &nbsp; &nbsp;
                                            <i class="fs-14 text-danger fa fa-trash pointer"></i>
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
                    <form id="pub-holiday-form">
                        <h4>Public Holiday Form</h4>

                        <div class="form-group">
                            <label>Date Start - Date End </label>
                            <div class="input-daterange input-group" id="holiday-datepicker-range">
                                <input type="text" class="input-sm form-control" name="start"/>
                                <div class="input-group-addon">to</div>
                                <input type="text" class="input-sm form-control" name="end"/>
                            </div>
                        </div>
                        <div class="form-group ">
                            <label>Holiday name</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group form-group-default-select2">
                            <label class="">Religion</label>
                            <select class="full-width select2" data-placeholder="Select Religion">
                                <option value="All">All</option>
                                <option value="test">Test</option>
                                <option value="test">Test</option>
                                <option value="test">Test</option>
                                <option value="test">Test</option>v
                                <option value="test">Test</option>
                            </select>
                        </div>
                        <p> If ALL religion is selected, then this holiday will be applied to all employees, otherwise it will be applied
                            to employees with selected religion.
                        </p>
                        <button class="btn btn-complete pull-right" type="button">Save</button>
                    </form>
                    <div class="clearfix"></div>
                    <br>
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