<template>
    <div class="row">
        <div class="col-lg-12">

            <div class="card card-bordered">

                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6">
                            <h4 class="pull-left">Salary Queue</h4>
                        </div>
                        <div class="col-lg-6">
                            <div class="pull-right">
                                <button class="btn btn-primary"><i class="fa fa-plus"></i> Calculate All</button>
                                <button class="btn btn-danger"><i class="fa fa-trash"> Delete All</i></button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="scrollable">
                        <div style="height: 600px">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black p-t-5 p-b-5">ID</th>
                                        <th class="text-black p-t-5 p-b-5">Employee</th>
                                        <th class="text-black p-t-5 p-b-5">Bonus/Cut</th>
                                        <th class="text-black p-t-5 p-b-5">Value</th>
                                        <th class="text-black p-t-5 p-b-5">Notes</th>
                                        <th class="text-black p-t-5 p-b-5">Inserted</th>
                                        <th class="text-black p-t-5 p-b-5"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Kevin Purwono (CSO)</td>
                                        <td>Postponed Salary Add <label class="label label-success">Add</label></td>
                                        <td>3000000</td>
                                        <td>Postponed salry from last month</td>
                                        <td>@<b>20/02/2018</b> by <b>Kevin</b></td>
                                        <td>
                                            <div>
                                                <button class="btn btn-outline-primary"><i class="fa fa-plus"></i>
                                                    Calculate
                                                </button>
                                                <button class="btn btn-outline-danger"><i class="fa fa-trash"></i>
                                                    Delete
                                                </button>
                                            </div>
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

    export default{
        components: {},
        mounted(){

        }
    }
</script>