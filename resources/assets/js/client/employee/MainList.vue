<template>
    <div class="container-fluid container-fixed-lg">
        <router-view>

            <div slot="go-back-and-view-menu">
                <button class="btn btn-outline-primary m-r-15 m-b-10 pull-left"
                        @click="goBack()"><i class="pg-arrow_left"></i>
                    Go Back
                </button>
                <div class="pull-left m-r-15 m-b-10">
                    <div class="dropdown dropdown-default">
                        <button class="btn btn-primary all-caps dropdown-toggle text-center" type="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            View
                        </button>

                        <div class="dropdown-menu">
                            <a class="dropdown-item pointer" @click="viewMasterDetail()">
                                Master</a>
                            <a class="dropdown-item pointer" @click="viewEmploymentDetail()">
                                Employment</a>
                            <a class="dropdown-item pointer" @click="viewFaceAPIDetail()">
                                Face API</a>
                            <a class="dropdown-item pointer" @click="viewFaceDetail()">
                                Login Details
                            </a>
                        </div>

                    </div>
                </div>
                <button class="btn btn-danger m-b-10 pull-right"
                        @click="edit()">
                    Edit
                </button>
            </div>

            <div slot="cancel-menu">
                <button class="btn btn-outline-danger m-r-15 m-b-10 pull-left"
                        @click="cancel()"><i class="pg-close"></i>
                    Cancel
                </button>
            </div>

        </router-view>
    </div>
</template>
<script type="text/javascript">
    import {get, post} from '../helpers/api'
    import {api_path} from '../helpers/const'
    export default{
        created(){
            let self = this;

            this.$bus.$on('save:master_detail',function(form){
                self.save(form,'master')
            })

            this.$bus.$on('save:employment_detail', function (form) {
                self.save(form, "employment")
            })

            this.$bus.$on('save:login_detail',function (form) {
              self.save(form,'login')
            })


        },
        methods: {
            viewMasterDetail(){
                $('#errors-container').addClass('hide');
                this.$router.push({name: 'detailMaster', params: {id: this.$route.params.id}})
            },
            viewEmploymentDetail(){
                $('#errors-container').addClass('hide');
                this.$router.push({name: 'detailEmployment', params: {id: this.$route.params.id}})
            },
            viewLoginDetail(){
                $('#errors-container').addClass('hide');
                this.$router.push({name: 'detailLogin', params: {id: this.$route.params.id}})
            },
            viewFaceAPIDetail(){
                $('#errors-container').addClass('hide');
                this.$router.push({name: 'detailFaceAPI', params: {id: this.$route.params.id}})
            },
            goBack(){
                $('#errors-container').addClass('hide');
                this.$router.push('/')
            },
            edit(){
                switch (this.$route.name) {
                    case 'detailMaster':
                        this.$router.push({name: 'editMaster', params: {id: this.$route.params.id}})
                        break;
                    case 'detailEmployment':
                        this.$router.push({name: 'editEmployment', params: {id: this.$route.params.id}})
                        break;
                    case 'detailLogin':
                        this.$router.push({name: 'editLogin', params: {id: this.$route.params.id}})
                        break;
                    default:
                        return null;
                }
            },
            save(form, type){
                switch (type) {
                    case 'master':
                        this.saveMaster(form)
                        break;
                    case 'employment':
                        this.saveEmployment(form)
                        break;
                    case 'login':
                        this.saveLogin(form)
                        break;
                    default:
                        return null;
                }
            },
            cancel(){
                switch (this.$route.name) {
                    case 'editMaster':
                        this.viewMasterDetail()
                        break;
                    case 'editEmployment':
                        this.viewEmploymentDetail()
                        break;
                    case 'editLogin':
                        this.viewLoginDetail()
                        break;
                    default:
                        return null;
                }
            },
            saveMaster(form){
                let self = this;
                post(api_path + 'employee/edit/master', form)
                    .then((res) => {
                        if (!res.data.isFailed) {

                            // remove errors alert
                            $('#errors-container').addClass('hide');

                            /* Show success notification*/
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'info'
                            }).show();

                            //redirect
                            self.$router.push({name: 'detailMaster', params: {id: self.$route.params.id}})

                        }
                        else {
                            /* Show error notification */
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 0,
                                type: 'danger'
                            }).show();

                        }
                    })
                    .catch((err) => {
                        let errorsResponse = err.message + '</br>';

                        _.forEach(err.response.data.errors, function (value, key) {
                            errorsResponse += value[0] + ' ';
                        })

                        $('#errors-container').removeClass('hide').addClass('show')
                        $('#errors-value').html(errorsResponse)
                        errorsResponse = '' // reset value
                        /* Scroll to top*/
                        $('html, body').animate({
                            scrollTop: $(".jumbotron").offset().top
                        }, 500);

                    })
            },
            saveEmployment(form){
                let self = this;
                post(api_path + 'employee/edit/employment', form)
                    .then((res) => {
                        if (!res.data.isFailed) {

                            // remove errors alert
                            $('#errors-container').addClass('hide');

                            /* Show success notification*/
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'info'
                            }).show();

                            //redirect
                            self.$router.push({name: 'detailEmployment', params: {id: self.$route.params.id}})

                        }
                        else {
                            /* Show error notification */
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 0,
                                type: 'danger'
                            }).show();

                        }
                    })
                    .catch((err) => {
                        let errorsResponse = err.message + '</br>';

                        _.forEach(err.response.data.errors, function (value, key) {
                            errorsResponse += value[0] + ' ';
                        })

                        $('#errors-container').removeClass('hide').addClass('show')
                        $('#errors-value').html(errorsResponse)
                        errorsResponse = '' // reset value
                        /* Scroll to top*/
                        $('html, body').animate({
                            scrollTop: $(".jumbotron").offset().top
                        }, 500);

                    })
            },
            saveLogin(form){
                let self = this;
                post(api_path + 'employee/edit/login', form)
                    .then((res) => {
                        if (!res.data.isFailed) {

                            // remove errors alert
                            $('#errors-container').addClass('hide');

                            /* Show success notification*/
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 3500,
                                type: 'info'
                            }).show();

                            //redirect
                            self.$router.push({name: 'detailLogin', params: {id: self.$route.params.id}})

                        }
                        else {
                            /* Show error notification */
                            $('.page-container').pgNotification({
                                style: 'flip',
                                message: res.data.message,
                                position: 'top-right',
                                timeout: 0,
                                type: 'danger'
                            }).show();

                        }
                    })
                    .catch((err) => {
                        let errorsResponse = err.message + '</br>';

                        _.forEach(err.response.data.errors, function (value, key) {
                            errorsResponse += value[0] + ' ';
                        })

                        $('#errors-container').removeClass('hide').addClass('show')
                        $('#errors-value').html(errorsResponse)
                        errorsResponse = '' // reset value
                        /* Scroll to top*/
                        $('html, body').animate({
                            scrollTop: $(".jumbotron").offset().top
                        }, 500);

                    })
            }

        },
    }
</script>