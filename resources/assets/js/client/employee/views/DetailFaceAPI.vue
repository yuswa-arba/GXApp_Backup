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
                            <p class=" text-primary" v-for="persistedFace in personDetail.persistedFaceIds">
                                {{persistedFace}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>
<script type="text/javascript">
    import {get, post, faceGet, facePut, facePost, facePutOctet, facePostOctet} from '../../helpers/api'
    import {api_path, faceBaseUrl, faceSubKey} from '../../helpers/const'
    import {makeBlob} from'../../helpers/utils'
    export default{
        data(){
            return {
                detail: [],
                personFaceData: '',
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
                let personGroupId = 'gx_development';

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
                                            self.getPersonDetail().

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
                console.log(self.personFaceData)

                $('#addPersonFaceBtn').html('...')
                $('#addPersonFaceBtn').attr('disabled', 'disabled')


                facePostOctet(faceBaseUrl + 'persongroups/' + self.detail.personGroupId + '/persons/' + self.detail.personId + '/persistedFaces', self.personFaceData)
                    .then((res) => {
                        if (res.status == 200 && res.data.persistedFaceId) {
                            console.log(res.data.persistedFaceId)

                            /*Reset data*/
                            self.personFaceData = ''
                            $('#inputFace').val('')
                            $('#addPersonFaceBtn').html('Face Data Empty')
                            $('#addPersonFaceBtn').removeAttr('disabled')
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
                        $('#inputFace').val('')
                        $('#addPersonFaceBtn').html('Face Data Empty')
                        $('#addPersonFaceBtn').removeAttr('disabled')
                    })
            },
            inputPersonFace(event){
                /* Convert file to base64 then convert it to Blob*/

                let self = this
                let FR = new FileReader();
                let base64Result = ''

                FR.addEventListener("load", function (e) {
                    base64Result = e.target.result
                    self.personFaceData = makeBlob(base64Result)
                });

                FR.readAsDataURL(event.target.files[0]);
            },
            getPersonDetail(){
                let self = this
                if (self.detail.personGroupId && self.detail.personId) {
                    faceGet(faceBaseUrl + 'persongroups/' + self.detail.personGroupId + '/persons/' + self.detail.personId)
                        .then((res) => {
                            if (res.data){
                                self.personDetail = res.data
                            }
                        }).catch((err) => {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: err.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
                    })
                }
            }
        }
    }
</script>