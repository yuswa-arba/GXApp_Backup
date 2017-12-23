<template>
    <div class="row">
        <div class="col-lg-8 m-b-10">
            <div class="card no-border">
                <div class="card-block">
                    <gmap-map
                            :center="{lat:10, lng:10}"
                            :zoom="7"
                            map-type-id="terrain"
                            style="width: 100%; height: 300px"
                    ></gmap-map>

                </div>
            </div>
        </div>

        <div class="col-lg-4 m-b-10">
            <div class="card card-transparent">
                <div class="card-block">
                    <form id="geofence-form">
                        <h4>Geofence Form</h4>
                        <div class="form-group ">
                            <label>Name</label>
                            <input type="text" class="form-control" placeholder="GlobalXtreme Bali Office">
                        </div>
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input type="text" class="form-control">
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="form-group ">
                            <label>Radius <span class="help">(in meters)</span></label>
                            <input type="number" class="form-control">
                        </div>
                        <div class="form-group form-group-default-select2">
                            <label class="">Apply for </label>
                            <select class="full-width select2" data-placeholder="Select Branch Office">
                                <option value="Bali">Bali</option>
                                <option value="Bali">Balikpapan</option>
                                <option value="Bali">Samarinda</option>
                                <option value="Bali">Malang</option>
                            </select>
                        </div>
                        <button class="btn btn-complete pull-right" type="button">Save</button>
                    </form>
                    <div class="clearfix"></div>
                    <br>
                </div>
            </div>
        </div>
        <div class="col-lg-12 m-b-10">

            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <h4>Geofence List</h4>
                    <div class="scrollable">
                        <div class=" h-350">

                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-text-center settingDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black">ID</th>
                                        <th class="text-black">Name</th>
                                        <th class="text-black">Latitude</th>
                                        <th class="text-black">Longitude</th>
                                        <th class="text-black">Applied for</th>
                                        <th class="text-black">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="index in 10">
                                        <td>{{index}}</td>
                                        <td>Lorem ipsum</td>
                                        <td>-8.12431</td>
                                        <td>115.12343</td>
                                        <td>Bali</td>
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
    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../../../helpers/api'
    export default{
        created(){

        },

    }
</script>