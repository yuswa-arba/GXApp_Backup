<template>
    <div class="row">
        <div class="col-lg-12 m-b-10">
            <p>
                <i class="fa fa-info-circle"></i>
                To search employee you may use the search box on the header &nbsp;
                <i class="fa fa-info-circle"></i>
                You may search by typing their Name / Employee No / Job Position
            </p>
        </div>
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
                    <h5 class="fs-14 pull-right" style="opacity: 0.7">{{employee.employeeNo}}</h5>
                    <h5 class="fs-16 overflow-ellipsis">{{employee.givenName}}</h5>
                    <h6 class="fs-14" style="opacity: .7">{{employee.surname}}</h6>
                    <h6 class="text-primary" style="margin-top: 3px">{{employee.jobPosition}}</h6>
                </div>
            </div>
            <!-- END ITEM -->
        </div>
    </div>
</template>

<script type="text/javascript">
    import {get} from '../../../helpers/api'
    import {api_path} from '../../../helpers/const'
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
                this.$router.push({name: 'detailSalary', params: {id: id}})
            }
        },
        mounted(){

        }

    }
</script>