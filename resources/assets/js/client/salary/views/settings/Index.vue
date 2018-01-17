<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-borderless">
                <ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#tabBonusCut" class="active">Bonus Cut</a>
                    </li>
                </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tabBonusCut">
                    <bonus-cut-tab></bonus-cut-tab>
                </div>
            </div>
        </div>

    </div>
    </div>
</template>
<script type="text/javascript">

    import BonusCutTab from '../../components/settings/BonusCutTab.vue'
    export default{
        components: {
            'bonus-cut-tab': BonusCutTab

        },
        mounted(){

        }
    }
</script>