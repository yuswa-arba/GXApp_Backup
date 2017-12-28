<template>
    <div class="row">

        <div class="col-lg-12">
            <div class="card card-borderless">
                <ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-responsive-tabs="dropdownfx">
                    <li class="nav-item">
                        <a href="" data-toggle="tab" role="tab" data-target="#tabPersonGroup">Person Group</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pan active" id="tabPersonGroup">
                        <person-group-tab></person-group-tab>
                    </div>
                </div>

            </div>
        </div>

    </div>

</template>
<script type="text/javascript">
    import PersonGroupTab from '../../components/PersonGroupTab.vue'
    export default{
        components: {
            'person-group-tab': PersonGroupTab
        },
        mounted(){

        }
    }
</script>