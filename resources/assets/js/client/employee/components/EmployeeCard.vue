<template>
    <div class="row">
        <div class="col-lg-3 col-sm-6 d-flex-not-important flex-column filter-item"
             v-for="employee in employees">
            <!-- START ITEM -->
            <div class="card social-card share  full-width m-b-10 d-flex flex-1 full-height no-border sm-vh-75"
                 data-social="item"
                 @click="viewDetail(employee.id)"
            >
                <div class="card-header clearfix">
                    <div class="user-pic">
                        <img v-if="employee.employeePhoto"
                             alt="None"
                             :src="`/images/employee/${employee.employeePhoto}`"
                             width="38" height="38"/>

                        <img v-else
                             alt="None"
                             src="/core/img/profiles/avatar_small2x.jpg"
                             width="38" height="38"
                        />
                    </div>
                    <h5 class="fs-18">{{employee.givenName}}</h5>
                    <h6 class="fs-14" style="opacity: .7">{{employee.surname}}</h6>
                    <h6 class="text-primary" style="margin-top: 3px">{{employee.jobPosition}}</h6>
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
            get(api_path + 'employee/list')
                .then((res) => {
                    this.employees = res.data.data;
                })
        },
        methods: {
            viewDetail(id){
                this.$router.push({name: 'detailMaster', params: {id: id}})
            }

        },
        mounted(){

        }

    }
</script>