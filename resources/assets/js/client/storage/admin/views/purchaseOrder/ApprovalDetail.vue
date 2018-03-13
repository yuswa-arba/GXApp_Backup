<template>
    <div class="row">
        <div class="col-lg-12">
            <slot name="go-back-menu"></slot>
            <div class="card card-default card-bordered border-solid-grey">
                <div class="card-block no-padding">
                    <div class="col-lg-12 border-bottom-grey" style="background:#fafafa;">
                        <div class="row">
                            <div class="col-lg-3 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Requisition No.</p>
                                <p class="text-black fs-18 m-b-10">{{requisition.requisitionNumber}}</p>

                                <p class="text-uppercase m-b-0">Approval No.</p>
                                <p class="text-black fs-16 m-b-10" v-if="requisition.approvalNumber">
                                    {{requisition.approvalNumber}}</p>
                                <p v-else="">-</p>

                            </div>
                            <div class="col-lg-2 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Requested At</p>
                                <p class="text-black fs-16 m-b-10">{{requisition.requestedAt}}</p>

                                <p class="text-uppercase m-b-0">Date Needed By</p>
                                <p class="text-black fs-16 m-b-10">{{requisition.dateNeededBy}}</p>

                            </div>
                            <div class="col-lg-3 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Description</p>
                                <p class="text-black fs-14 m-b-10">{{requisition.description}}</p>
                            </div>
                            <div class="col-lg-3 m-t-20 m-b-20">
                                <p class="text-uppercase m-t-10 m-b-0">Approval Status</p>
                                <p class="text-black fs-14 m-b-10">{{requisition.approvalName}}</p>
                            </div>
                            <div class="col-lg-1 m-t-20 m-b-20">

                            </div>
                        </div>
                    </div>
                    <div class="p-t-10"></div>
                    <div class="col-lg-12" v-for="item in requisition.requisitionItems.data" v-if="requisition.requisitionItems">
                        <div class="row border-bottom-grey p-t-10 p-b-10">
                            <div class="col-lg-3 p-t-10">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="cursor" @click="viewImage('/images/storage/items/'+item.itemPhoto)"
                                             style="margin-top:-10px">
                                            <img :src="'/images/storage/items/'+item.itemPhoto" height="60px"
                                                 alt="No Image Found">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <p class="text-black fs-16 m-b-0">{{item.itemName}}</p>
                                        <p class="no-padding fs-14">{{item.itemCode}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2 p-t-10">
                                <p class="fs-16 m-b-0">Amount: <span class="text-black">{{item.amount}}</span></p>
                                <p class=" fs-16 m-b-0">Unit: <span class="text-black">{{item.itemUnit}}</span></p>
                            </div>
                            <div class="col-lg-3 p-t-10">
                                <p class="text-uppercase m-b-0">Notes</p>
                                <p class="text-black fs-16 m-b-10" v-if="item.notes">{{item.notes}}</p>
                                <p v-else="">-</p>
                            </div>
                            <div class="col-lg-3 p-t-10">
                                <p>
                                    <span class="text-uppercase">Approved: </span>
                                    <i class="fa fa-check text-success fs-16" v-if="item.isApproved"></i>
                                    <i class="fa fa-times text-danger fs-16" v-else=""></i>
                                </p>
                                <div v-if="item.updatedAt&&item.updatedBy">
                                    <p class="text-uppercase m-b-0">Latest Update</p>
                                    <p class="text-black fs-16 m-b-10">
                                        Updated at {{item.updatedAt}} by {{item.updatedBy}}
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-1 p-t-10"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import {get} from '../../../../helpers/api'
    import {api_path} from '../../../../helpers/const'
    export default{
        data(){
            return {
                requisition: {}
            }
        },
        created(){
            let self = this

            get(api_path + 'storage/admin/purchaseOrder/approvalDetail?no=' + this.$route.params.approvalNo)
                .then((res) => {
                    if (!res.data.isFailed) {

                        //insert to array
                        self.requisition = res.data.requisition.data

                    } else {
                        $('.page-container').pgNotification({
                            style: 'flip',
                            message: res.data.message,
                            position: 'top-right',
                            timeout: 3500,
                            type: 'danger'
                        }).show();
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

        },
        computed: {},
        methods: {
            viewImage(url){
                window.open(url, '_blank')
            },
        }
    }
</script>