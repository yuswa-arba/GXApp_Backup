<template>
    <div class="row">
        <div class="col-lg-8 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-350">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-text-center settingDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black">ID</th>
                                        <th class="text-black">Description</th>
                                        <th class="text-black">Battery Power</th>
                                        <th class="text-black">Charging</th>
                                        <th class="text-black">Enabled</th>
                                        <th class="text-black">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="index in 10">
                                        <td>{{index}}</td>
                                        <td>Lorem ipsum lorem ipsum lorem ipsum</td>
                                        <td>{{50+index}}</td>
                                        <td>
                                            <i class="fs-16 text-complete fa fa-check"></i>
                                        </td>
                                        <td>
                                            <i class="fs-16 text-danger fa fa-times"></i>
                                        </td>
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
                    <form id="kiosk-form">
                        <h4>Kiosk Form</h4>
                        <div class="form-group ">
                            <label>Description</label>
                            <input type="text" class="form-control" placeholder="e.q 2nd Floor near meeting room ">
                        </div>
                        <div class="form-group ">
                            <label>API Token</label>
                            <input type="text" class="form-control">
                        </div>
                        <div class="form-group form-group-default-select2">
                            <label class="">Enabled</label>
                            <select class="full-width select2" data-placeholder="Enable Device">
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
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