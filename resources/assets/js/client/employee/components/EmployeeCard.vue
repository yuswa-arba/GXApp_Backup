<template>
    <div class="row">
        <div class="col-lg-3 col-sm-6  d-flex flex-column"
             v-for="employee in employees">
            <!-- START ITEM -->
            <div class="card social-card share  full-width m-b-10 d-flex flex-1 full-height no-border sm-vh-75"
                 data-social="item"
                 @click="viewDetail(employee.id)"
            >
                <div class="card-header clearfix">
                    <div class="user-pic">
                        <img alt="Avatar" width="33" height="33"
                             data-src-retina="/core/img/profiles/avatar_small2x.jpg"
                             data-src="c/ore/img/profiles/avatar.jpg"
                             src="/core/img/profiles/avatar_small2x.jpg"
                        >
                    </div>
                    <h5>{{employee.givenName}} {{employee.surname}}</h5>
                    <h6>{{employee.jobPosition}} ({{employee.division}})</h6>
                </div>
            </div>
            <!-- END ITEM -->
        </div>
    </div>
</template>

<script type="text/javascript">
    import {get} from '../../helpers/api'
    import {api_path} from '../../helpers/const'
    export default{
        data(){
            return {
                employees: []
            }
        },
        created(){
            let self = this;
            get(api_path() + 'employee/list')
                .then((res) => {
                    this.employees = res.data.data;
                })
        },
        methods: {
            viewDetail(id){
                this.$router.push({name: 'detail', params: {id: id}})
            }

        },
        mounted(){

        }

    }
</script>