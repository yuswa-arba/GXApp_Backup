<template>
    <div class="container-fluid container-fixed-lg">
        <div class="row">
            <div class="col-lg-12 m-b-10">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-header">
                        <p class="card-title text-uppercase text-black" style="opacity: 1">Supplier Form</p>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group-attached">
                                    <div class="form-group form-group-default required">
                                        <label> Name </label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label> Address </label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label>Country</label>
                                        <select name="" id="" class="form-control"></select>
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label>City</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label>Postal Code</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default required">
                                        <label>Telephone Number</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-4">
                                <div class="form-group-attached">
                                    <div class="form-group form-group-default">
                                        <label> Contact Person 1</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label> Mobile Number 1</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label> Email 1</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label> Contact Person 2</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label> Mobile Number 2</label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label> Email 2</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-4">
                                <div class="form-group-attached">
                                    <div class="form-group form-group-default">
                                        <label> Accounting Number </label>
                                        <input type="text" class="form-control">
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Notes</label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-12">
                                <button class="btn btn-complete pull-right" type="button" @click="createSupplier()">
                                    Create
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 m-b-10">
                <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                    <div class="card-block">
                        <input type="text" style="height: 40px;" class="form-control" id="search-suppliers-box"
                               placeholder="Search Suppliers">
                        <div class="scrollable">
                            <div class="" style="height:700px">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover ">
                                        <thead class="bg-master-lighter">
                                        <tr>
                                            <th class="text-black">Name</th>
                                            <th class="text-black">Address</th>
                                            <th class="text-black">Telephone</th>
                                            <th class="text-black">Contact 1</th>
                                            <th class="text-black">Contact 2</th>
                                            <th class="text-black">Accounting No.</th>
                                            <th class="text-black">Notes</th>
                                            <th class="text-black">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="filter-item-suppliers">
                                            <td></td>
                                            <td></td>
                                            <td></td>
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
        </div>
    </div>
</template>

<script type="text/javascript">
    export default{
        created(){

        },
        methods: {
            createSupplier(){

            }
        }
    }

</script>