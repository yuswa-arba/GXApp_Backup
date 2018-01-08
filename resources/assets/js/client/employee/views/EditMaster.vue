<template>
    <div class="row row-same-height">

        <div class="col-lg-12 m-b-10 m-t-10">

            <slot name="cancel-menu"></slot>
            <button class="btn btn-primary m-r-15 m-b-10 pull-left"
                    @click="save()">
                Save
            </button>

        </div>


        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12 employee-details">
                            <label>Employee ID</label>
                            <p class="text-primary">{{$route.params.id}}</p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Employee No</label>
                            <p class="text-primary">{{form.employeeNo}}</p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Personal Information</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-4">
                            <!--<div style="">-->
                                <!--<img :src="`/images/employee/${form.employeePhoto}`"-->
                                     <!--alt="No Image" class="img-responsive" style="width:100%; height:auto;">-->
                            <!--</div>-->

                            <input type="file" name="employeePhoto" id="editEmployeePhoto"
                                   @change="insertEmployeePhotoToForm($event)"
                                   value="" required/>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-4 employee-details">

                            <label>Surname/Given name</label>
                            <h5>{{form.surname}}/{{form.givenName}}</h5>

                            <label>Birthday</label>
                            <h5>{{form.birthDate}}</h5>

                            <label>Gender</label>
                            <h5>{{form.gender}}</h5>


                        </div>
                        <div class="col-lg-4 employee-details">
                            <label>Religion</label>
                            <select class="form-control" v-model="form.religionId">
                                <option v-for="religion in religions"
                                        :value="religion.id">
                                    {{religion.name}}
                                </option>
                            </select>

                            <label>Hometown</label>
                            <h5>{{form.hometown}}</h5>

                            <label>Education level</label>
                            <select class="form-control" v-model="form.educationLevelId">
                                <option v-for="educationLevel in educationLevels"
                                        :value="educationLevel.id">
                                    {{educationLevel.name}}
                                </option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Contact Information</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 employee-details">

                            <label>Address</label>
                            <input type="text" class="form-control" v-model="form.address">

                            <label>City</label>
                            <input type="text" class="form-control" v-model="form.city">

                            <label>Phone Number</label>
                            <input type="text" class="form-control" v-model="form.phoneNo">

                        </div>
                        <div class="col-lg-6 employee-details">

                            <label>E-mail address</label>
                            <h5>{{form.email}}</h5>

                            <label>Alt. E-mail address</label>
                            <input type="text" class="form-control" v-model="form.altEmail">

                        </div>

                    </div>
                </div>
            </div>
            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">ID Card Information</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-4 employee-details">

                            <!--<div style="">-->
                                <!--<img :src="`/images/employee/${form.idCardPhoto}`"-->
                                     <!--alt="No Image" class="img-responsive" style="width:100%; height:auto;">-->
                            <!--</div>-->

                            <input id="editIdCardPhoto"
                                   type="file"
                                   name="idCardPhoto"
                                   @change="insertIDCardPhotoToForm($event)"
                                   accept="image/*"
                                   required/>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-8 employee-details">

                            <label>ID Card Number</label>
                            <input type="number" class="form-control" v-model="form.idCardNumber">

                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Bank Information</div>

                </div>
                <div class="card-block">
                    <div class="row">

                        <div class="col-lg-4 employee-details">
                            <label>Bank Name</label>
                            <select class="form-control" v-model="form.bankId">
                                <option v-for="bank in banks"
                                        :value="bank.id">
                                    {{bank.name}}
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Bank Branch</label>
                            <input type="text" class="form-control" v-model="form.bankBranch">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Bank City</label>
                            <input type="text" class="form-control" v-model="form.bankCity">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Bank Account Name</label>
                            <input type="text" class="form-control" v-model="form.bankHolderName">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Bank Account Number</label>
                            <input type="text" class="form-control" v-model="form.bankAccNo">
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Marriage</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-4 employee-details">
                            <label>Marital Status</label>
                            <select class="form-control" v-model="form.maritalStatusId">
                                <option v-for="maritalStatus in maritalStatuses"
                                        :value="maritalStatus.id">
                                    {{maritalStatus.name}}
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Spouse's Name</label>
                            <input type="text" class="form-control" v-model="form.spousesName">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Number of children</label>
                            <input type="text" class="form-control" v-model="form.totalChildren">
                        </div>

                    </div>
                </div>
            </div>


            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Family</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-4 employee-details">
                            <label>Father's Name</label>
                            <input type="text" class="form-control" v-model="form.fatherName">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Father's Address</label>
                            <input type="text" class="form-control" v-model="form.fatherAddress">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Father's City</label>
                            <input type="text" class="form-control" v-model="form.fatherCity">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Father's Phone Number</label>
                            <input type="text" class="form-control" v-model="form.fatherPhoneNo">
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Father's Marital Status</label>
                            <select class="form-control" v-model="form.fatherMaritalStatusId">
                                <option v-for="maritalStatus in maritalStatuses"
                                        :value="maritalStatus.id">
                                    {{maritalStatus.name}}
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Mother's Name</label>
                            <input type="text" class="form-control" v-model="form.motherName">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Mother's Address</label>
                            <input type="text" class="form-control" v-model="form.motherAddress">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Mother's City</label>
                            <input type="text" class="form-control" v-model="form.motherCity">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Mother's Phone Number</label>
                            <input type="text" class="form-control" v-model="form.motherPhoneNo">
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Mother's Marital Status</label>
                            <select class="form-control" v-model="form.motherMaritalStatusId">
                                <option v-for="maritalStatus in maritalStatuses"
                                        :value="maritalStatus.id">
                                    {{maritalStatus.name}}
                                </option>
                            </select>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Number of Siblings</label>
                            <input type="text" class="form-control" v-model="form.numberOfSiblings">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Sibling's Name</label>
                            <input type="text" class="form-control" v-model="form.siblingName">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Sibling's Address</label>
                            <input type="text" class="form-control" v-model="form.siblingAddress">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Sibling's City</label>
                            <input type="text" class="form-control" v-model="form.siblingCity">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Sibling's Phone Number</label>
                            <input type="text" class="form-control" v-model="form.siblingPhoneNo">
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Sibling's Marital Status</label>
                            <select class="form-control" v-model="form.siblingMaritalStatusId">
                                <option v-for="maritalStatus in maritalStatuses"
                                        :value="maritalStatus.id">
                                    {{maritalStatus.name}}
                                </option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Emergency Contact Information</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-4 employee-details">
                            <label>Contact Person Name</label>
                            <input type="text" class="form-control" v-model="form.emergencyContact">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Relationship</label>
                            <input type="text" class="form-control" v-model="form.emergencyRelationship">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Address</label>
                            <input type="text" class="form-control" v-model="form.emergencyAddress">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>City</label>
                            <input type="text" class="form-control" v-model="form.emergencyCity">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" v-model="form.emergencyPhoneNo">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Alt Phone Number</label>
                            <input type="text" class="form-control" v-model="form.emergencyAltPhoneNo">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Email</label>
                            <input type="text" class="form-control" v-model="form.emergencyEmailAddress">
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Previous Employment Information</div>
                </div>
                <div class="card-block">
                    <div class="row">

                        <div class="col-lg-4 employee-details">
                            <label>Company Name</label>
                            <input type="text" class="form-control" v-model="form.prevCompanyName">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Company Address</label>
                            <input type="text" class="form-control" v-model="form.prevCompanyAddress">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Company Phone Number</label>
                            <input type="text" class="form-control" v-model="form.prevCompanyPhoneNo">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Position</label>
                            <input type="text" class="form-control" v-model="form.prevPosition">
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Length of Employment</label>
                            <input type="text" class="form-control" v-model="form.prevLengthEmployment">
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../../helpers/api'
    import {api_path} from '../../helpers/const'
    export default{
        data(){
            return {
                form: {},
                maritalStatuses: [],
                banks: [],
                educationLevels: [],
                religions: []

            }
        },
        created(){
            get(api_path + 'employee/edit/master/' + this.$route.params.id)
                .then((res) => {
                    //set current value
                    this.form = res.data.detail.data
                    this.form.id = this.$route.params.id

                    //form components
                    this.maritalStatuses = this.form.formComponents.maritalStatuses
                    this.banks = this.form.formComponents.banks
                    this.educationLevels = this.form.formComponents.educationLevels
                    this.religions = this.form.formComponents.religions
                })
        },
        methods: {
            save(){
                let self = this
                delete self.form.formComponents // remove form components during submit
                self.$bus.$emit('save:master_detail',this.form)
            },
            insertEmployeePhotoToForm(e){
                this.form.employeePhoto = e.target.files[0]
                console.log(e.target.files[0])
            },
            insertIDCardPhotoToForm(e){
                this.form.idCardPhoto = e.target.files[0]
                console.log(e.target.files[0])
            }
        }
    }
</script>