<template>
    <div class="row row-same-height">

        <div class="col-lg-12 m-b-10 m-t-10">

            <slot name="go-back-and-view-menu"></slot>

        </div>


        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Long term medication</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 employee-details">
                            <label>Long term medication</label>
                            <p class="text-primary" v-if="detail.hasLongTermMedication">Yes</p>
                            <p class="text-danger" v-else="">No</p>
                        </div>
                        <div class="col-lg-6 employee-details" v-if="detail.hasLongTermMedication">
                            <label>Type of Disease</label>
                            <p class="text-primary">{{detail.typeOfDisease}}</p>
                        </div>

                        <div class="col-lg-6 employee-details" v-if="detail.hasLongTermMedication">
                            <label>Since When</label>
                            <p class="text-primary">{{detail.medicationSinceWhen}}</p>
                        </div>
                        <div class="col-lg-6 employee-details" v-if="detail.hasLongTermMedication">
                            <label>Type of drug</label>
                            <p class="text-primary">{{detail.typeOfDrug}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Smoker Status</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 employee-details">
                            <label>Is A Smoker?</label>
                            <p class="text-primary" v-if="detail.isASmoker">Yes</p>
                            <p class="text-danger" v-else="">No</p>
                        </div>
                        <div class="col-lg-6 employee-details"  v-if="detail.isASmoker">
                            <label>Amount per day</label>
                            <p class="text-primary">{{detail.smokeAmountPerDay}}</p>
                        </div>

                        <div class="col-lg-6 employee-details"  v-if="detail.isASmoker">
                            <label>Since When</label>
                            <p class="text-primary">{{detail.smokingSinceWhen}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Drinker Status</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 employee-details">
                            <label>Is A Drinker?</label>
                            <p class="text-primary" v-if="detail.isADrinker">Yes</p>
                            <p class="text-danger" v-else="">No</p>
                        </div>
                        <div class="col-lg-6 employee-details"  v-if="detail.isADrinker">
                            <label>Amount per day</label>
                            <p class="text-primary">{{detail.drinkAmountPerDay}}</p>
                        </div>

                        <div class="col-lg-6 employee-details"  v-if="detail.isADrinker">
                            <label>Since When</label>
                            <p class="text-primary">{{detail.drinkingSinceWhen}}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-6">

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Accident Record</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 employee-details">
                            <label>Had An Accident?</label>
                            <p class="text-primary" v-if="detail.hadAnAccident">Yes</p>
                            <p class="text-danger" v-else="">No</p>
                        </div>
                        <div class="col-lg-6 employee-details" v-if="detail.hadAnAccident">
                            <label>Date</label>
                            <p class="text-primary">{{detail.accidentDate}}</p>
                        </div>

                        <div class="col-lg-6 employee-details" v-if="detail.hadAnAccident">
                            <label>Type of Accident</label>
                            <p class="text-primary">{{detail.typeOfAccident}}</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Surgery Record</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 employee-details">
                            <label>Had A Surgery?</label>
                            <p class="text-primary" v-if="detail.hadASurgery">Yes</p>
                            <p class="text-danger" v-else="">No</p>
                        </div>
                        <div class="col-lg-6 employee-details"  v-if="detail.hadASurgery">
                            <label>Date</label>
                            <p class="text-primary">{{detail.surgeryDate}}</p>
                        </div>

                        <div class="col-lg-6 employee-details"  v-if="detail.hadASurgery">
                            <label>Type of Surgery</label>
                            <p class="text-primary">{{detail.typeOfSurgery}}</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Hospitalized Record</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-6 employee-details">
                            <label>Has Hospitalized?</label>
                            <p class="text-primary" v-if="detail.hasHospitalized">Yes</p>
                            <p class="text-danger" v-else="">No</p>
                        </div>
                        <div class="col-lg-6 employee-details" v-if="detail.hasHospitalized">
                            <label>Date</label>
                            <p class="text-primary">{{detail.dateHospitalized}}</p>
                        </div>

                        <div class="col-lg-6 employee-details" v-if="detail.hasHospitalized">
                            <label>Type of Medication</label>
                            <p class="text-primary">{{detail.typeOfMedication}}</p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="card card-default filter-item">
                <div class="card-header ">
                    <div class="card-title">Others</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12 employee-details">
                            <label>Dietary Habits</label>
                            <p class="text-black">{{detail.dietaryHabit}}</p>
                        </div>
                        <div class="col-lg-6 employee-details">
                            <label>Type of Sport</label>
                            <p class="text-primary">{{detail.typeOfSport}}</p>
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Sport activity per week</label>
                            <p class="text-primary">{{detail.sportAmountPerWeek}}</p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Body Height</label>
                            <p class="text-black">{{detail.bodyHeight}}</p>
                        </div>
                        <div class="col-lg-6 employee-details">
                            <label>Wear Glasses</label>
                            <p class="text-primary" v-if="detail.wearGlasses">Yes</p>
                            <p class="text-danger" v-else="">No</p>
                        </div>
                        <div class="col-lg-6 employee-details">
                            <label>Glasses Size</label>
                            <p class="text-primary"  v-if="detail.wearGlasses">{{detail.glassesSize}}</p>
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Notes</label>
                            <p class="text-black">{{detail.extraNotes}}</p>
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
                detail: []
            }
        },
        created(){
            get(api_path + 'employee/detail/medicalRecords/' + this.$route.params.id)
                .then((res) => {
                this.detail = res.data.detail.data
            })
        }
    }
</script>