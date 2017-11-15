<template>
    <div>
        <span class="text-primary pointer"
              @click="goBack()"><i class="pg-arrow_left"></i>
            Go Back
        </span>
        <div class="col-lg-12"></div>
        <div class="col-lg-6">
            <label class="label label-info">
                ID: {{$route.params.id}}
            </label>
            <div class="card card-default">
                <div class="card-header ">
                    <div class="card-title">Personal Information</div>

                </div>
                <div class="card-block">
                    <div class="row row-same-height">
                        <div class="col-lg-4">
                            <img src="http://i.dailymail.co.uk/i/pix/2016/05/23/22/348B850600000578-3605456-image-m-32_1464040491071.jpg"
                                 alt="" width="200px" height="200px">
                        </div>
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
                            <h5>{{detail.city}}</h5>

                            <label>Education level</label>
                            <h5>{{detail.educationLevel}}</h5>
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

                detail: [],
                employment:[]

            }
        },
        created(){
            get(api_path() + 'employee/detail/' + this.$route.params.id)
                .then((res) => {
                    console.log(res)
                    this.detail = res.data.detail.data
                    this.employment = res.data.detail.data.employment.data
                })
        },
        methods: {
            goBack(){
                this.$router.push('/')
            }
        }
    }
</script>