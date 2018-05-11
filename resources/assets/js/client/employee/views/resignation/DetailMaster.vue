<template>
    <div class="row row-same-height">

        <div class="col-lg-12 m-b-10 m-t-10">

            <button class="btn btn-outline-primary m-r-15 m-b-10 pull-left"
                    @click="goBackToResignedList()"><i class="pg-arrow_left"></i>
                Go Back
            </button>

        </div>

        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Resignation Information</div>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-4 m-b-10">
                            <div class="cursor" style="" @click="viewImage('/images/resignation/'+resignationDetail.resignationLetter)">
                                <img :src="`/images/resignation/${resignationDetail.resignationLetter}`"
                                     alt="No Image" class="img-responsive" style="width:100%; height:auto;">
                            </div>
                        </div>
                        <div class="col-lg-4 employee-details">
                            <label>Submission Date</label>
                            <p class="text-primary">{{resignationDetail.submissionDate}}</p>
                        </div>
                        <div class="col-lg-4 employee-details">
                            <label>Effective Date</label>
                            <p class="text-primary">{{resignationDetail.effectiveDate}}</p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Professionalism</label>
                            <p class="text-primary">{{resignationDetail.professionalism}}</p>
                        </div>
                        <div class="col-lg-4 employee-details" v-if="resignationDetail.reason">
                            <label>Reason</label>
                            <p class="text-primary">{{resignationDetail.reason}}</p>
                        </div>
                        <div class="col-lg-4 employee-details" v-if="resignationDetail.notes">
                            <label>Notes</label>
                            <p class="text-primary">{{resignationDetail.notes}}</p>
                        </div>
                        <div class="col-lg-4 employee-details">
                            <label>Submitted By</label>
                            <p class="text-primary">{{resignationDetail.submittedBy}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6"></div>
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
                            <p class="text-primary">{{detail.employeeNo}}</p>
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
                            <div class="cursor" style="" @click="viewImage('/images/employee/'+detail.employeePhoto)">
                                <img :src="`/images/employee/${detail.employeePhoto}`"
                                     alt="No Image" class="img-responsive" style="width:100%; height:auto;">
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-4 employee-details">

                            <label>Surname/Given name</label>
                            <h5>{{detail.surname}}/{{detail.givenName}}</h5>

                            <label>Birthday</label>
                            <h5>{{detail.birthDate}}</h5>

                            <label>Gender</label>
                            <h5>{{detail.gender}}</h5>


                        </div>
                        <div class="col-lg-4 employee-details">
                            <label>Religion</label>
                            <h5>{{detail.gender}}</h5>

                            <label>Hometown</label>
                            <h5>{{detail.hometown}}</h5>

                            <label>Education level</label>
                            <h5>{{detail.educationLevel}}</h5>
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
                            <h5>{{detail.address}}</h5>

                            <label>City</label>
                            <h5>{{detail.city}}</h5>

                            <label>Phone Number</label>
                            <h5>{{detail.phoneNo}}</h5>

                        </div>
                        <div class="col-lg-6 employee-details">

                            <label>E-mail address</label>
                            <h5>{{detail.email}}</h5>

                            <label>Alt. E-mail address</label>
                            <h5>{{detail.altEmail}}</h5>
                            <h5 v-if="!detail.altEmail">-</h5>

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

                            <div class="cursor" style="" @click="viewImage('/images/employee/'+detail.idCardPhoto)">
                                <img :src="`/images/employee/${detail.idCardPhoto}`"
                                     alt="No Image" class="img-responsive" style="width:100%; height:auto;">
                            </div>

                        </div>
                        <div class="clearfix"></div>
                        <div class="col-lg-8 employee-details">

                            <label>ID Card Number</label>
                            <h5>{{detail.idCardNumber}}</h5>

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
                            <h5>{{detail.bank}}</h5>
                            <h5 v-if="!detail.bank">-</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Bank Branch</label>
                            <h5>{{detail.bankBranch}}</h5>
                            <h5 v-if="!detail.bankBranch">-</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Bank City</label>
                            <h5>{{detail.bankCity}}</h5>
                            <h5 v-if="!detail.bankCity">-</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Bank Account Name</label>
                            <h5>{{detail.bankHolderName}}</h5>
                            <h5 v-if="!detail.bankHolderName">-</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Bank Account Number</label>
                            <h5>{{detail.bankAccNo}}</h5>
                            <h5 v-if="!detail.bankAccNo">-</h5>
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
                            <h5>{{detail.maritalStatus}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Spouse's Name</label>
                            <h5>{{detail.spousesName}}</h5>
                            <h5 v-if="!detail.spousesName">-</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Number of children</label>
                            <h5>{{detail.totalChildren}}</h5>
                            <h5 v-if="!detail.totalChildren">-</h5>
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
                            <h5>{{detail.fatherName}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Father's Address</label>
                            <h5>{{detail.fatherAddress}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Father's City</label>
                            <h5>{{detail.fatherCity}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Father's Phone Number</label>
                            <h5>{{detail.fatherPhoneNo}}</h5>
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Father's Marital Status</label>
                            <h5>{{detail.fatherMaritalStatus}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Mother's Name</label>
                            <h5>{{detail.motherName}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Mother's Address</label>
                            <h5>{{detail.motherAddress}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Mother's City</label>
                            <h5>{{detail.motherCity}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Mother's Phone Number</label>
                            <h5>{{detail.motherPhoneNo}}</h5>
                        </div>

                        <div class="col-lg-12 employee-details">
                            <label>Mother's Marital Status</label>
                            <h5>{{detail.motherMaritalStatus}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Number of Siblings</label>
                            <h5>{{detail.numberOfSiblings}}</h5>
                        </div>
                        <div class="clearfix"></div>
                        <div v-if="detail.siblings.data" class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12 employee-details" v-for="(sibling,index) in detail.siblings.data">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            No. {{index+1}}
                                        </div>
                                        <div class="col-lg-4 employee-details">
                                            <label>Sibling's Name</label>
                                            <h5>{{sibling.name}}</h5>
                                            <h5 v-if="!sibling.name">-</h5>
                                        </div>

                                        <div class="col-lg-4 employee-details">
                                            <label>Sibling's Address</label>
                                            <h5>{{sibling.address}}</h5>
                                            <h5 v-if="!sibling.address">-</h5>
                                        </div>

                                        <div class="col-lg-4 employee-details">
                                            <label>Sibling's City</label>
                                            <h5>{{sibling.city}}</h5>
                                            <h5 v-if="!sibling.city">-</h5>
                                        </div>

                                        <div class="col-lg-4 employee-details">
                                            <label>Sibling's Phone Number</label>
                                            <h5>{{sibling.phoneNumber}}</h5>
                                            <h5 v-if="!sibling.phoneNumber">-</h5>
                                        </div>
                                    </div>

                                </div>

                            </div>

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
                            <h5>{{detail.emergencyContact}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Relationship</label>
                            <h5>{{detail.emergencyRelationship}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Address</label>
                            <h5>{{detail.emergencyAddress}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>City</label>
                            <h5>{{detail.emergencyCity}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Phone Number</label>
                            <h5>{{detail.emergencyPhoneNo}}</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Alt Phone Number</label>
                            <h5>{{detail.emergencyAltPhoneNo}}</h5>
                            <h5 v-if="!detail.emergencyAltPhoneNo">-</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Email</label>
                            <h5>{{detail.emergencyEmailAddress}}</h5>
                            <h5 v-if="!detail.emergencyEmailAddress">-</h5>
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
                            <h5>{{detail.prevCompanyName}}</h5>
                            <h5 v-if="!detail.prevCompanyName">-</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Company Address</label>
                            <h5>{{detail.prevCompanyAddress}}</h5>
                            <h5 v-if="!detail.prevCompanyAddress">-</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Company Phone Number</label>
                            <h5>{{detail.prevCompanyPhoneNo}}</h5>
                            <h5 v-if="!detail.prevCompanyPhoneNo">-</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Position</label>
                            <h5>{{detail.prevPosition}}</h5>
                            <h5 v-if="!detail.prevPosition">-</h5>
                        </div>

                        <div class="col-lg-4 employee-details">
                            <label>Length of Employment</label>
                            <h5>{{detail.prevLengthEmployment}}</h5>
                            <h5 v-if="!detail.prevLengthEmployment">-</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
    export default{
        data(){
            return {
                detail: [],
                resignationDetail: []
            }
        },
        created(){
            get(api_path + 'employee/detail/master/' + this.$route.params.id)
                .then((res) => {
                    this.detail = res.data.detail.data
                })

            get(api_path + 'employee/detail/resignation/' + this.$route.params.id)
                .then((res) => {
                    this.resignationDetail = res.data.detail.data
                })


        },
        methods: {
            goBackToResignedList(){
                this.$router.push('/list')
            },
            viewImage(url){
                window.open(url,'_blank')
            }
        }
    }
</script>