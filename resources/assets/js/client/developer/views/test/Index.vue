<template>
    <div class="row">

        <!-- STAR REGISTER -->
        <div class="col-lg-6">
            <!-- START card -->
            <div class="card card-default">
                <div class="card-header ">
                    <div class="card-title">
                        Register #one
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group form-group-default required">
                                <label>Create Group</label>
                                <input type="text" placeholder="Create Group" class="form-control" id="selectGroup1">
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            OR
                        </div>
                        <div class="col-md-5">
                            <div class="form-group form-group-default required">
                                <label class="">Select Group</label>
                                <select class="form-control" id="selectGroup2">
                                    <option value="">- pilih group -</option>
                                    <option value="test_login">test_login</option>
                                    <option value="test_login1">test_login1</option>
                                    <option value="test_login2">test_login2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-default required ">
                                <label>Name Employee</label>
                                <input type="text" placeholder="Name Employee" id="personName" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12 text-center m-b-10">
                            <button class="btn btn-danger btn-xs" onclick="createPerson()">Create Person</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group form-group-default required">
                                <label>Auto Get Unic Number</label>
                                <input id="personId" type="text" readonly class="form-control" placeholder="Unic Number">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  form-group-default">
                                <label>Data Binary Picture <span class="pull-right"><a href="#/" style="font-size: 16px;" class="fa fa-camera text-danger" @click="activeCamera"></a></span></label>
                                <input type="text" id="urlImage" readonly v-model="photo" class="form-control" placeholder="data:image/jpeg;base64">
                            </div>
                        </div>
                        <div class="col-md-12 text-center m-b-10">
                            <button class="btn btn-primary btn-xs" onclick="addPersonFace()">Add Person</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group  form-group-default">
                                <label>Response Script</label>
                                <textarea id="responsePerson" style="width:100%" class="form-control" placeholder="text response"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group form-group-default">
                                <label>Take Picture</label>
                                <img :src="photo" id="sourcesPerson" alt="" style="width:100%;height:100%">
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-success btn-xs" onclick="printPerson()" disabled id="addPerson">Trying Person</button>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END card -->
        </div>
        <!-- END REGISTER -->


        <!-- STAR CHECK FACE -->
        <div class="col-lg-6">
            <!-- START card -->
            <div class="card card-default">
                <div class="card-header ">
                    <div class="card-title">
                        Check Face #two
                    </div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group  form-group-default">
                                <label>Check Data Binary Picture <span class="pull-right"><a href="#/" style="font-size: 16px;" class="fa fa-camera text-danger" @click="modalcameraCheck"></a></span></label>
                                <input type="text"  id="urlIdentify" readonly v-model="checkPhoto" class="form-control" placeholder="data:image/jpeg;base64">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group  form-group-default">
                                <label>Response Script</label>
                                <textarea id="responseIdentify" rows="15" style="width:100%" class="form-control" placeholder="text response"></textarea>
                            </div>
                        </div>
                        <div class="col-md-6 text-center m-b-10">
                            <div class="form-group form-group-default">
                                <label>Check Picture</label>
                                <img :src="checkPhoto" id="sourcesIdentify" alt="" style="width:100%;height:100%">
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-success btn-xs" onclick="addIdentify()" >CHECK</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END card -->
        </div>
        <!-- END CHECK FACE -->

        <div class="modal fade fill-in show" id="modalFillIn" tabindex="-1" role="dialog" aria-hidden="true">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="pg-close"></i>
            </button>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <vue-webcam ref='webcam' v-if="openMethodWebcam == 1" :width="400" :height="400"></vue-webcam>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-center p-b-5">
                                <button type="button" @click="take_photo"  class="btn btn-primary btn-lg btn-large fs-15">Take Picture</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>
<script type="text/javascript">
    import VueWebcamGetPicture from 'vue-webcam'
    export default {
        components: {VueWebcamGetPicture},
        data(){
            return {
                takeImage: '',
                photo: null,
                checkPhoto:null,
                cekOncamera1: 1,
                cekOncamera2: 1,
                openMethodWebcam: 0
            }
        },
        methods:{
            uploadImg(){
                var self = this
                var dataImput = {
                    'fullName' : self.fullName,
                    'email' : self.email,
                    'company' : self.companyName,
                    'file' : self.photo
                }
                axios.post('../api/masterWebcam/addData', dataImput)
                    .then((response) => {
                        console.log(response)
                        self.fullName = ''
                        self.email = ''
                        self.companyName = ''
                        self.photo = ''
                        $('#myModal').modal('hide')
                    })
            },
            activeCamera(){
                this.cekOncamera1 = 1;
                $('#modalFillIn').modal('show')
            },
            take_photo(){
                $('#modalFillIn').modal('hide');
                this.photo = this.$refs.webcam.getPhoto();
                console.log(this.$refs.webcam.getCanvas())
                this.cekOncamera1 = 0;
                this.cekOncamera2 = 0;
            },
            modalcameraCheck(){
                this.cekOncamera2 = 1;
                $('#cameraCheckFace').modal('show')
            },
            takePhotoForCheck(){
                $('#cameraCheckFace').modal('hide')
                this.checkPhoto = this.$refs.webcam2.getPhoto();
                this.cekOncamera2 = 0;
                this.cekOncamera1 = 0;
            }
        }}
</script>