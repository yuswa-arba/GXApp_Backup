<template>
    <div class="row" style="margin-left: -30px">
        <div class="col-lg-2 bg-master-light">
            <category-card></category-card>
        </div>
        <div class="col-lg-10">
            <item-card></item-card>
        </div>

        <attempt-add-item-to-cart-modal></attempt-add-item-to-cart-modal>
    </div>
</template>
<script type="text/javascript">
    import CategoryCard from '../../components/shop/CategoryCard.vue'
    import ItemCard from '../../components/shop/ItemCard.vue'
    import AttemptAddItemToCartModal from '../../components/shop/AttemptAddItemToCartModal.vue'
    export default{
        components: {
            'category-card': CategoryCard,
            'item-card': ItemCard,
            'attempt-add-item-to-cart-modal':AttemptAddItemToCartModal
        },
        mounted(){

        },
        created(){
            this.$store.dispatch({
                type:'shop/getDataOnCreate'
            })
        }
    }
</script>