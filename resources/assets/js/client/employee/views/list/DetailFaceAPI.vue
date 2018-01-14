<template>
    <div class="row row-same-height">

        <div class="col-lg-12 m-b-10 m-t-10">

            <slot name="go-back-and-view-menu-without-edit"></slot>

        </div>


        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Employee Profile</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12 employee-details">
                            <label>Employee ID</label>
                            <p class="text-primary">{{detail.employeeId}}</p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Employee No</label>
                            <p class="text-primary">{{detail.employeeNo}}</p>
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Full Name</label>
                            <p class="text-primary">{{detail.employeeFullName}}</p>
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Person ID</label>
                            <p class="text-primary">{{detail.personId}}</p>
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Person Group ID</label>
                            <p class="text-primary">{{detail.personGroupId}}</p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Face API Forms</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12">
                            <p class="all-caps bold text-black">Create Person</p>
                            <button class="btn btn-primary"
                                    id="createPersonBtn"
                                    v-if="detail.personId=='-'&&detail.personGroupId=='-'"
                                    @click="createPerson()"
                            >
                                Create
                            </button>
                            <button class="btn" v-else="" disabled>Completed</button>
                            <br> <br>
                            <span class="help m-t-10">Create person to get Person ID and Person Group ID</span>
                            <hr>
                        </div>
                        <div class="col-lg-12 m-t-10">
                            <p class="all-caps bold text-black">Add Person Face
                            </p>

                            <input id="inputFace" type="file" @change="inputPersonFace($event)"
                                   v-if="detail.personId!='-' && detail.personGroupId!='-'">
                            <p v-else="">Required Person Id and Person Group Id</p>

                            <button class="btn btn-primary"
                                    id="addPersonFaceBtn"
                                    v-if="personFaceData"
                                    @click="addPersonFace()"
                            >
                                Add
                            </button>
                            <button v-else="" class="btn" disabled> Face Data Empty</button>
                            <br>
                            <span class="help">Choose File to Add Person Face. It may take a while to convert image</span>
                            <hr>
                        </div>
                        <div class="col-lg-12 m-t-10">
                            <p class="all-caps bold text-black">Person Details
                            </p>
                            <p>Person Id</p>
                            <p class="text-primary">{{personDetail.personId}}</p>
                            <p>Name</p>
                            <p class=" text-primary">{{personDetail.name}}</p>
                            <p>Persisted Face Ids</p>
                            <div v-for="persistedFace in personDetail.persistedFaceIds">
                                <p class=" text-primary">{{persistedFace}} &nbsp; &nbsp;
                                    <i class="fs-14 text-danger fa fa-times pointer"
                                       @click="deleteFace(persistedFace)"></i>
                                    &nbsp; &nbsp;
                                    <i class="fs-14 fa fa-eye pointer" data-toggle="modal"
                                       :href="'#img'+persistedFace" aria-expanded="false"></i>
                                </p>
                                <div class="clearfix"></div>
                                <div class="modal fade" :id="'img'+persistedFace">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header"></div>
                                            <div class="modal-body">
                                                <div class="center-margin">
                                                    <img :src="'/images/faces/'+persistedFace+'.png'" alt=""
                                                         height="300px" style="margin: 0 auto; display: block">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
    import {get, post, del, faceGet, facePut, facePost, faceDel, facePostOctet} from '../../../helpers/api'
    import {api_path, faceBaseUrl, faceSubKey , microsoftPersonGroupId} from '../../../helpers/const'
    import {makeBlob, objectToFormData} from'../../../helpers/utils'
    export default{
        data(){
            return {
                detail: [],
                personFaceData: '', // for send to microsoft API
                personFaceFile: '', // for upload image to local server
                personDetail: {}
            }
        },
        created(){
            let self = this
            get(api_path + 'employee/detail/faceapi/' + this.$route.params.id)
                .then((res) => {
                    this.detail = res.data.detail.data
                    self.getPersonDetail()
                })


        },
        methods: {
            createPerson(){
                let self = this

                //TODO : change this personGroupId when on production!
                let personGroupId = microsoftPersonGroupId;

                if (self.detail.employeeId && self.detail.employeeFullName) {

                    $('#createPersonBtn').html('...')
                    $('#createPersonBtn').attr('disabled', 'disabled');

                    facePost(faceBaseUrl + 'persongroups/' + personGroupId + '/persons', {name: self.detail.employeeFullName})
                        .then((res) => {
                            let receivedPeronId = res.data.personId;
                            //save to DB
                            if (receivedPeronId) {
                                post(api_path + 'employee/edit/faceapi/person',
                                    {
                                        personId: receivedPeronId,
                                        employeeId: self.detail.employeeId,
                                        personGroupId: personGroupId
                                    }
                                )
                                    .then((res) => {
                                        if (!res.data.isFailed) {
                                            //update user data
                                            self.detail.personId = receivedPeronId
                                            self.detail.personGroupId = personGroupId

                                            $('.page-container').pgNotification({
                                                style: 'flip',
                                                message: res.data.message,
                                                position: 'top-right',
                                                timeout: 3500,
                                                type: 'info'
                                            }).show();

                                            $('#createPersonBtn').html('Completed')
                                            self.getPersonDetail()
                                            self.trainPersonGroup()

                                        } else {
                                            $('.page-container').pgNotification({
                                                style: 'flip',
                                                message: res.data.message,
                                                position: 'top-right',
                                                timeout: 3500,
                                                type: 'danger'
                                            }).show();


                                            $('#createPersonBtn').html('Error')
                                        }


                                    })
                                    .catch((err) => {
                                        $('.page-container').pgNotification({
                                            style: 'flip',
                                            message: err.message,
                                            position: 'top-right',
                                            timeout: 3500,
                                            type: 'danger'
                                        }).show();

                                        $('#createPersonBtn').html('Error')
                                    })
                            } else {
                                $('#createPersonBtn').html('Error')
                            }
                        })
                        .catch((err) => {
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: err.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();

                            $('#createPersonBtn').html('Error')

                        })
                }
            },
            addPersonFace(){
                let self = this

                $('#addPersonFaceBtn').attr('disabled', 'disabled')


                facePostOctet(faceBaseUrl + 'persongroups/' + self.detail.personGroupId + '/persons/' + self.detail.personId + '/persistedFaces', self.personFaceData)
                    .then((res) => {
                        if (res.status == 200 && res.data.persistedFaceId) {


                            let formObject = {}
                            formObject.persistedFaceId = res.data.persistedFaceId
                            formObject.facePhoto = self.personFaceFile

                            // save photo to local srever
                            post(api_path + 'employee/edit/faceapi/savePhoto', objectToFormData(formObject))
                                .then((res) => {
                                    if (!res.data.isFailed) {

                                        $('.page-container').pgNotification({
                                            style: 'flip',
                                            message: res.data.message,
                                            position: 'top-right',
                                            timeout: 3500,
                                            type: 'info'
                                        }).show();

                                        // push ID to personDetail
                                        if (self.personDetail) {
                                            self.personDetail.persistedFaceIds.push(formObject.persistedFaceId)
                                        }

                                        // Train personGroup
                                        self.trainPersonGroup()


                                    } else {

                                        $('.page-container').pgNotification({
                                            style: 'flip',
                                            message: res.data.message,
                                            position: 'top-right',
                                            timeout: 3500,
                                            type: 'danger'
                                        }).show();
                                    }


                                    /*Reset data*/
                                    self.personFaceData = ''
                                    self.personFaceFile = ''
                                    $('#inputFace').val('')
                                    $('#addPersonFaceBtn').removeAttr('disabled')

                                })
                                .catch((err) => {
                                    $('.page-container').pgNotification({
                                        style: 'flip',
                                        message: err.message,
                                        position: 'top-right',
                                        timeout: 3500,
                                        type: 'danger'
                                    }).show();


                                    /*Reset data*/
                                    self.personFaceData = ''
                                    self.personFaceFile = ''
                                    $('#inputFace').val('')
                                    $('#addPersonFaceBtn').removeAttr('disabled')


                                })
                        }
                    })
                    .catch((err) => {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();


                        /*Reset data*/
                        self.personFaceData = ''
                        self.personFaceFile = ''
                        $('#inputFace').val('')
                        $('#addPersonFaceBtn').removeAttr('disabled')
                    })
            },
            inputPersonFace(event){
                /* Convert file to base64 then convert it to Blob*/

                let self = this
                let FR = new FileReader();
                let base64Result = ''

                self.personFaceFile = event.target.files[0] //for save to local server

                FR.addEventListener("load", function (e) {
                    base64Result = e.target.result
                    self.personFaceData = makeBlob(base64Result) // for microsoft api request
                });

                FR.readAsDataURL(event.target.files[0]);
            },
            getPersonDetail(){
                let self = this
                if (self.detail.personGroupId!='-' && self.detail.personId) {
                    faceGet(faceBaseUrl + 'persongroups/' + self.detail.personGroupId + '/persons/' + self.detail.personId)
                        .then((res) => {
                            if (res.data) {
                                self.personDetail = res.data
                            }
                        }).catch((err) => {

                        /* Error Notification */
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();

                    })
                }
            },
            deleteFace(persistedFaceId){
                let self = this

                if (confirm('Are you sure to delete this persisted face?')) {
                    faceDel(faceBaseUrl + 'persongroups/' + self.detail.personGroupId + '/persons/' + self.detail.personId
                        + '/persistedFaces/' + persistedFaceId)
                        .then((res) => {
                            if (res.status == 200) {

                                // delete photo from server storage
                                del(api_path + 'employee/edit/faceapi/deletePhoto/' + persistedFaceId)
                                    .then((res) => {

                                    })
                                    .catch((err) => {
                                        /* Error Notification */
                                        $('.page-container').pgNotification({
                                            style: 'flip',
                                            message: err.message,
                                            position: 'top-right',
                                            timeout: 3500,
                                            type: 'danger'
                                        }).show();
                                    })

                                /* Success Notification */
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: 'Persisted Face Deleted',
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'info'
                                }).show();


                                let PIFIndex = _.findIndex(self.personDetail.persistedFaceIds, (o) => {
                                    return o == persistedFaceId
                                })
                                self.personDetail.persistedFaceIds.splice(PIFIndex, 1)
                                // Train personGroup
                                self.trainPersonGroup()
                            }

                        }).catch((err) => {

                        /* Error Notification */
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();

                    })
                }

            },
            trainPersonGroup(){
                let self = this
                let personGroupId = self.detail.personGroupId
                if (personGroupId) {
                    facePost(faceBaseUrl + 'persongroups/' + personGroupId + '/train')
                        .then((res) => {
                            // okay
                        })
                        .catch((err) => {
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: err.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'danger'
                            }).show();
                        })
                }

            },

        }
    }
</script>