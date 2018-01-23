<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-borderless">
                <ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#tabBonusCut" class="active">Bonus/Cut</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#tabGeneralBonusCut">General Bonus/Cut</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#tabPayroll">Payroll</a>
                    </li>
                </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="tabBonusCut">
                    <bonus-cut-tab></bonus-cut-tab>
                </div>
                <div class="tab-pane" id="tabGeneralBonusCut">
                    <general-bonus-cut-tab></general-bonus-cut-tab>
                </div>
                <div class="tab-pane" id="tabPayroll">
                    <payroll-tab></payroll-tab>
                </div>
            </div>
        </div>

    </div>
    </div>
</template>
<script type="text/javascript">

    import BonusCutTab from '../../components/settings/BonusCutTab.vue'
    import GeneralBonusCutTab from '../../components/settings/GeneralBonusCutTab.vue'
    import PayrollTab from '../../components/settings/PayrollTab.vue'


    export default{
        components: {
            'bonus-cut-tab': BonusCutTab,
            'general-bonus-cut-tab': GeneralBonusCutTab,
            'payroll-tab' : PayrollTab
        },
        mounted(){

        }
    }
</script>