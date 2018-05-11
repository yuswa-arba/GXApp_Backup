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
                <div class="card-header ">
                    <div class="card-title">Long term medication</div>

                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-lg-12 employee-details">
                            <label>Long term medication</label>
                            <br>
                            <input type="radio" id="long-term-medication-yes" value="1" v-model="form.hasLongTermMedication">
                            <label for="long-term-medication-yes">Yes</label>
                            <br>
                            <input type="radio" id="long-term-medication-no" value="0" v-model="form.hasLongTermMedication">
                            <label for="long-term-medication-no">No</label>
                        </div>
                        <div class="col-lg-6 employee-details">
                            <label>Type of Disease</label>
                            <input type="text" class="form-control" v-model="form.typeOfDisease" placeholder="">
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Since When</label>
                            <input type="text" class="form-control" v-model="form.medicationSinceWhen" placeholder="dd/mm/yyyy">
                        </div>
                        <div class="col-lg-6 employee-details">
                            <label>Type of drug</label>
                            <input type="text" class="form-control" v-model="form.typeOfDrug" placeholder="">
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
                        <div class="col-lg-12 employee-details">
                            <label>Is A Smoker?</label>
                            <br>
                            <input type="radio" id="is-a-smoker-yes" value="1" v-model="form.isASmoker">
                            <label for="is-a-smoker-yes">Yes</label>
                            <br>
                            <input type="radio" id="is-a-smoker-no" value="0" v-model="form.isASmoker">
                            <label for="is-a-smoker-no">No</label>
                        </div>
                        <div class="col-lg-6 employee-details">
                            <label>Amount per day</label>
                            <input type="text" class="form-control" v-model="form.smokeAmountPerDay" placeholder="">
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Since When</label>
                            <input type="text" class="form-control" v-model="form.smokingSinceWhen" placeholder="dd/mm/yyyy">
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
                        <div class="col-lg-12 employee-details">
                            <label>Is A Drinker?</label>
                            <br>
                            <input type="radio" id="is-a-drinker-yes" value="1" v-model="form.isADrinker">
                            <label for="is-a-drinker-yes">Yes</label>
                            <br>
                            <input type="radio" id="is-a-drinker-no" value="0" v-model="form.isADrinker">
                            <label for="is-a-drinker-no">No</label>
                        </div>
                        <div class="col-lg-6 employee-details">
                            <label>Amount per day</label>
                            <input type="text" class="form-control" v-model="form.drinkAmountPerDay" placeholder="">
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Since When</label>
                            <input type="text" class="form-control" v-model="form.drinkingSinceWhen" placeholder="dd/mm/yyyy">
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
                        <div class="col-lg-12 employee-details">
                            <label>Had An Accident?</label>
                            <br>
                            <input type="radio" id="had-an-accident-yes" value="1" v-model="form.hadAnAccident">
                            <label for="had-an-accident-yes">Yes</label>
                            <br>
                            <input type="radio" id="had-an-accident-no" value="0" v-model="form.hadAnAccident">
                            <label for="had-an-accident-no">No</label>
                        </div>
                        <div class="col-lg-6 employee-details">
                            <label>Date</label>
                            <input type="text" class="form-control" v-model="form.accidentDate" placeholder="dd/mm/yyyy">
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Type of Accident</label>
                            <input type="text" class="form-control" v-model="form.typeOfAccident" placeholder="">
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
                        <div class="col-lg-12 employee-details">
                            <label>Had A Surgery?</label>
                            <br>
                            <input type="radio" id="had-an-surgery-yes" value="1" v-model="form.hadASurgery">
                            <label for="had-an-surgery-yes">Yes</label>
                            <br>
                            <input type="radio" id="had-an-surgery-no" value="0" v-model="form.hadASurgery">
                            <label for="had-an-surgery-no">No</label>
                        </div>
                        <div class="col-lg-6 employee-details">
                            <label>Date</label>
                            <input type="text" class="form-control" v-model="form.surgeryDate" placeholder="dd/mm/yyyy">
                        </div>

                        <div class="col-lg-6 employee-details" >
                            <label>Type of Surgery</label>
                            <input type="text" class="form-control" v-model="form.typeOfSurgery" placeholder="">
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

                        <div class="col-lg-12 employee-details">
                            <label>Has Hospitalized?</label>
                            <br>
                            <input type="radio" id="has-hopitalized-yes" value="1" v-model="form.hasHospitalized">
                            <label for="had-an-surgery-yes">Yes</label>
                            <br>
                            <input type="radio" id="has-hopitalized-no" value="0" v-model="form.hasHospitalized">
                            <label for="had-an-surgery-no">No</label>
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Date</label>
                            <input type="text" class="form-control" v-model="form.dateHospitalized" placeholder="dd/mm/yyyy">
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Type of Medication</label>
                            <input type="text" class="form-control" v-model="form.typeOfMedication" placeholder="">
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
                            <input type="text" class="form-control" v-model="form.dietaryHabit" placeholder="">
                        </div>
                        <div class="col-lg-6 employee-details">
                            <label>Type of Sport</label>
                            <input type="text" class="form-control" v-model="form.typeOfSport" placeholder="">
                        </div>

                        <div class="col-lg-6 employee-details">
                            <label>Sport activity per week</label>
                            <input type="text" class="form-control" v-model="form.sportAmountPerWeek" placeholder="">
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Body Height</label>
                            <input type="text" class="form-control" v-model="form.bodyHeight" placeholder="">
                        </div>
                        <div class="col-lg-6 employee-details">
                            <label>Wear Glasses</label>
                            <input type="text" class="form-control" v-model="form.wearGlasses" placeholder="">
                        </div>
                        <div class="col-lg-6 employee-details">
                            <label>Glasses Size</label>
                            <input type="text" class="form-control" v-model="form.glassesSize" placeholder="">
                        </div>
                        <div class="col-lg-12 employee-details">
                            <label>Notes</label>
                            <input type="text" class="form-control" v-model="form.extraNotes" placeholder="">
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
                form: {},
            }
        },
        created(){
            get(api_path + 'employee/edit/medicalRecords/' + this.$route.params.id)
                .then((res) => {

                    //set current value
                    this.form = res.data.detail.data
                    this.form.employeeId = this.$route.params.id

                })
        },
        methods: {
            save(){
                delete this.form.formComponents // remove form components during submit
                this.$bus.$emit('save:medical_records_detail',this.form)
            }
        }
    }
</script>