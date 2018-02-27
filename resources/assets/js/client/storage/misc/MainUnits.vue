<template>
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-8 m-b-10">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block">
                        <input type="text" style="height: 40px;" class="form-control" id="search-units-box"
                               placeholder="Search Categories">
                        <div class="scrollable">
                            <div class="" style="height:700px">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover ">
                                        <thead class="bg-master-lighter">
                                        <tr>
                                            <th class="text-black">ID</th>
                                            <th class="text-black">Format</th>
                                            <th class="text-black">Description</th>
                                            <th class="text-black">Type</th>
                                            <th class="text-black">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="filter-item-units">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
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
                <div class="card card-bordered">
                    <div class="card-block">
                        <form id="warehouse-form">
                            <h4>Unit of Measurement Form</h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Format</label>
                                        <input type="text" class="form-control" name="" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <input type="text" class="form-control" name="" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="" id="" class="form-control"></select>
                                    </div>
                                    <button class="btn btn-complete pull-right" type="button" @click="createUnitOfMeasurement()">Create</button>

                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    export default{
        created(){

        },
        methods: {
            createUnitOfMeasurement(){

            }
        }
    }
</script>