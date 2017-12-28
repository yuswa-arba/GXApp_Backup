<template>
    <div class="row">
        <div class="col-lg-8 m-b-10 m-t-10">
            <!--empty-->
        </div>
        <div class="col-lg-4 m-b-10 m-t-10">
            <div class="card card-bordered">
                <div class="card-block">
                    <form id="shift-form">
                        <h4>Person Group Form</h4>
                        <div>
                            <div class="form-group  required">
                                <label>Person Group ID</label>
                                <input type="text" class="form-control" required placeholder="gx_employee_all"
                                       v-model="formPersonGroupId">
                            </div>
                            <div class="form-group  required">
                                <label>Person Group Name</label>
                                <input type="text" class="form-control" required placeholder="GX Employee All"
                                       v-model="formPersonGroupName">
                            </div>
                        </div>
                        <p>Person group ID format refer to <a target="_blank"
                                href="https://westus.dev.cognitive.microsoft.com/docs/services/563879b61984550e40cbbe8d/operations/563879b61984550f30395244">this</a>
                        </p>
                        <button class="btn btn-complete pull-right" type="button" @click="creatPersonGroup()">Save
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-500">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover settingDT">
                                    <thead class="bg-master-lighter">
                                    <tr>
                                        <th class="text-black">ID</th>
                                        <th class="text-black">Name</th>
                                        <th class="text-black">User Data</th>
                                        <th class="text-black">Training Status</th>
                                        <th class="text-black">Training Action</th>
                                        <th class="text-black">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="personGroup in personGroups">
                                        <td>{{personGroup.personGroupId}}</td>
                                        <td>{{personGroup.name}}</td>
                                        <td>{{personGroup.userData}}</td>
                                        <td class="fs-11" style="width: 300px">
                                            {{personGroup.trainingStatus}}
                                        </td>
                                        <td style="width: 200px">
                                            <span class="label label-xs label-success pointer"
                                                    :id="'trainBtn_'+personGroup.personGroupId"
                                                    @click="trainPersonGroup(personGroup.personGroupId)">Train</span>
                                            <span class="label label-xs label-warning pointer"
                                                  :id="'trainBtn_'+personGroup.personGroupId"
                                                  @click="getPersonGroupTrainingStatus(personGroup.personGroupId)">Refresh</span>
                                        </td>
                                        <td>
                                            <!--<i class="fs-14 fa fa-pencil pointer" v-if="shift.id!=1"></i>-->
                                            &nbsp; &nbsp;
                                            <i class="fs-14 text-danger fa fa-times pointer"
                                               @click="deletePersonGroup(personGroup.personGroupId)"></i>

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
    import {get, post, faceGet, facePost, facePut, faceDel, facePutOctet} from '../../helpers/api'
    import {api_path, faceBaseUrl} from '../../helpers/const'
    export default{
        data(){
            return {
                personGroups: [],
                formPersonGroupId: '',
                formPersonGroupName: ''
            }
        },
        created(){
            let self = this
            faceGet(faceBaseUrl + 'persongroups')
                .then((res) => {
                    self.personGroups = res.data
                    /*Get Train Status*/
                    _.forEach(self.personGroups, function (value, key) {
                        self.getPersonGroupTrainingStatus(value.personGroupId)
                    })

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
        },
        methods: {
            creatPersonGroup(){
                let self = this
                if (!_.isEmpty(self.formPersonGroupId) && !_.isEmpty(self.formPersonGroupName)) {
                    facePut(faceBaseUrl + 'persongroups/' + self.formPersonGroupId, {name: self.formPersonGroupName})
                        .then((res) => {

                            if (res.status == 200) {
                                self.personGroups.push({
                                    personGroupId: self.formPersonGroupId,
                                    name: self.formPersonGroupName,
                                    userData: ''
                                })

                                // Refresh data
                                self.formPersonGroupId = ''
                                self.formPersonGroupName = ''
                            }

                        })
                        .catch((err) => {
                            if (err.response.status == 409) {
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: 'Person group ID already exist',
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'danger'
                                }).show();
                            } else {
                                $('.page-container').pgNotification({
                                    style: 'flip',
                                    message: err.message,
                                    position: 'top-right',
                                    timeout: 3500,
                                    type: 'danger'
                                }).show();
                            }
                        })
                } else {
                    $('.page-container').pgNotification({
                        style: 'flip',
                        message: 'Unable to create, form is not complete or invalid',
                        position: 'top-right',
                        timeout: 3500,
                        type: 'danger'
                    }).show();
                }
            },
            deletePersonGroup(personGroupId){
                let self = this
                if (confirm("Are you sure to delete this Person Group?")) {
                    faceDel(faceBaseUrl + 'persongroups/' + personGroupId)
                        .then((res) => {
                            if (res.status == 200) {
                                //remove from person group
                                const personGroupIndex = _.findIndex(self.personGroups, {personGroupId: personGroupId})
                                self.personGroups.splice(personGroupIndex, 1)

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
                        })
                }

            },
            trainPersonGroup(personGroupId){

                let self = this

                $('#trainBtn_' + personGroupId).html('....')
                $('#trainBtn_' + personGroupId).attr('disabled', 'disabled')

                facePost(faceBaseUrl + 'persongroups/' + personGroupId + '/train')
                    .then((res) => {
                        if (res.status == 202) {
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: 'Train has been completed',
                                position: 'top-right',
                                timeout: 3500,
                                type: 'success'
                            }).show();
                        }

                        $('#trainBtn_' + personGroupId).html('Train')
                        $('#trainBtn_' + personGroupId).removeAttr('disabled')

                        self.getPersonGroupTrainingStatus(personGroupId)
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
            },
            getPersonGroupTrainingStatus(personGroupId){

                let self = this

                faceGet(faceBaseUrl + 'persongroups/' + personGroupId + '/training')
                    .then((res) => {
                        if (res.status == 200 && res.data != null) {

                            const personGroup = _.find(self.personGroups, {personGroupId: personGroupId})
                            const personGroupIndex = _.findIndex(self.personGroups, {personGroupId: personGroupId})

                            personGroup.trainingStatus = res.data

                            self.personGroups.splice(personGroupIndex, 1, personGroup)

                        }
                    })
            }
        },
        computed: {}
    }
</script>