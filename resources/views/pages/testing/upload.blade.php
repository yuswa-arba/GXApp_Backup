@extends('layouts.main')

@push('child-styles')
<!-- push needed plugins for this page-->
@endpush

@push('child-scripts-plugins')
<!-- push needed plugins for this page -->
@endpush

@push('child-page-controller')
<script src="{{mix('js/client/testing/main.js')}}"></script>
@endpush

@section('content')

    <div class="content">
        <!-- START JUMBOTRON -->
        <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
                <div class="inner">
                    <!-- START BREADCRUMB -->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Barebone</a></li>
                        <li class="breadcrumb-item active">Layout</li>
                    </ol>
                    <!-- END BREADCRUMB -->
                </div>
            </div>
        </div>
        <!-- END JUMBOTRON -->
        <!-- START CONTAINER FLUID -->
        <div class="container-fluid container-fixed-lg">
            {{--<form id="testUploadForm">--}}
                {{--{{csrf_field()}}--}}

                {{--<label>Contact Photo</label>--}}

                {{--<label for="">Name</label>--}}
                {{--<label>--}}
                    {{--<input type="text" name="contactName" value="" id="contactName">--}}
                {{--</label>--}}
                {{--<label for="">Employee Photo</label>--}}
                {{--<input type="file" name="employeePhoto" id="employeePhoto"--}}
                       {{--value="" required/>--}}
                {{--<button type="submit" id="submitBtn">Submit</button>--}}

            {{--</form>--}}
            <form id="frm" class="dx-fieldset" method="post">
                <div class="dx-field">
                    <div class="dx-field-label" data-bind="text: L['SURNAME']">Name</div>
                    <input type="text" name="name" id="employeeName">
                </div>
                <br>
                <div class="dx-field">
                    <div class="dx-field-label" data-bind="text: L['EMAIL']">Employee photo</div>
                    <input type="file" name="employeePhoto" id="employeePhoto">
                    <br>
                    <img src="" alt="" id="img-preview" height="200px" width="200px">
                </div>
                <br>
                <button type="button" id="submitBtn">Submit</button>

            </form>

            <h4>Image</h4>
            <div class="row">
                @foreach($datas as $data)
                    <div class="col-md-3">
                        <label for="">{{$data->name}}</label>
                        <br>
                        <img src="{{asset('images/'.$data->employeePhoto)}}" alt="" height="200px" width="200px">
                    </div>
                @endforeach
            </div>


        </div>
        <!-- END CONTAINER FLUID -->
    </div>
    <!-- END PAGE CONTENT -->

@endsection