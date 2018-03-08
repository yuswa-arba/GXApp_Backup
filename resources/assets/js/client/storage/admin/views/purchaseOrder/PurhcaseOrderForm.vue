<template>
    <div class="row">

        <div class="col-lg-12 m-b-10 m-t-10">
            <slot name="go-back-menu"></slot>
        </div>

        <div class="col-lg-12">
            <div class="row">

                <!--forms-->
                <po-form></po-form>
                <insert-items-form></insert-items-form>

            </div>
        </div>

        <!--modals-->
        <select-requisition-modal></select-requisition-modal>
        <select-supplier-modal></select-supplier-modal>

    </div>
</template>

<script type="text/javascript">
    import {mapGetters, mapState} from 'vuex'
    import SelectRequisitionModal from '../../components/purchaseOrder/SelectRequisitionModal.vue'
    import SelectSupplierModal from '../../components/purchaseOrder/SelectSupplierModal.vue'
    import POFrom from '../../components/purchaseOrder/POForm.vue'
    import InsertItemsForm from '../../components/purchaseOrder/InsertItemsForm.vue'
    export default{
        components: {
            'po-form': POFrom,
            'insert-items-form': InsertItemsForm,
            'select-requisition-modal': SelectRequisitionModal,
            'select-supplier-modal': SelectSupplierModal
        },
        data(){
            return {}
        },
        created(){

        },
        computed: {},
        methods: {}
    }
</script>