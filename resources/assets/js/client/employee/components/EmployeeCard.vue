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
                 @click="viewDetail(employee.id)">
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
        <infinite-loading @infinite="infiniteHandler" spinner="waveDots"
                          ref="infiniteLoading">
                                        <span slot="no-more">
                                          <!--There is no more Empoyees-->
                                        </span>
        </infinite-loading>
    </div>
</template>

<script type="text/javascript">
    import {get} from '../../helpers/api'
    import {api_path} from '../../helpers/const'
    import InfiniteLoading from 'vue-infinite-loading';
    export default{
        components: {
            InfiniteLoading,
        },
        data(){
            return {
                employees: [],
                paginationMeta: {
                    count: '',
                    current_page: '',
                    links: [],
                    per_page: '',
                    total: '',
                    total_pages: ''
                },
            }
        },
        created(){
            let self = this;
//            get(api_path + 'employee/list')
//                .then((res) => {
//                    this.employees = res.data.data;
//                })
        },
        methods: {
            infiniteHandler($state) { //getting item list data from server using vue-infinit-scroll
                let self = this

                if (self.paginationMeta.current_page >= self.paginationMeta.total_pages && self.paginationMeta.current_page != '') {

                    $state.complete()

                } else {

                    let nextPage = self.paginationMeta.current_page + 1

                    get(api_path + 'employee/list'+'?page='+nextPage)
                        .then((res) => {
                            let employeesData = res.data.data
                            if (employeesData) {

                                self.employees = self.employees.concat(employeesData);

                                //insert pagination
                                self.paginationMeta = res.data.meta.pagination

                                $state.loaded();

                                if (self.employees.length === self.paginationMeta.total) {
                                    $state.complete()
                                }

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

                            $state.complete()
                        })


                }

            },
            viewDetail(id){
                this.$router.push({name: 'detailMaster', params: {id: id}})
            }

        },
        mounted(){

        }

    }
</script>