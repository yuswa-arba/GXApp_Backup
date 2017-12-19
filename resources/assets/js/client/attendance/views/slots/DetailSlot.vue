<template>
    <div class="row">

        <div class="col-lg-12 m-b-10 m-t-10">
            <slot name="go-back-menu"></slot>
            <span class="fs-24 pull-center text-primary text-center z-index-minus-1">{{slotDetail.name}}</span>

            <!--if its not general slot then show assign button-->
            <div class="pull-right m-r-15 m-b-10" v-if="slotDetail.id!=1">
                <button class="btn btn-primary all-caps" @click="assignSlot()">Assign <i class="fa fa-plus"></i></button>
            </div>

        </div>


        <div class="col-lg-12 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block padding-30">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>

        <assign-slot-quickview></assign-slot-quickview>


    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import AssignSlotQuickview from '../../components/slots/AssignSlotQuickview.vue'

    export default{
        components: {
            "assign-slot-quickview": AssignSlotQuickview
        },
        data(){
            return{

            }
        },
        computed: {
            ...mapGetters('slots', {
                slotDetail: 'slotDetail'
            })
        },
        created(){
            let self = this
            this.$store.dispatch('slots/getDataOnSlotCalendar',this.$route.params.id)
        },
        mounted(){

            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today removeSource',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                selectable: true,
                selectHelper: true,
                timeFormat: 'H:mm',
                select: function(start, end) {
//                  alert(moment(start).format('DD/MM/YYYY'))
                },
                eventRender: function(event, element, view ) {
                    element.on('click',()=>{
                        console.log(moment(event.start).format('DD/MM/YYYY'))
                    })
                },
            })
        },
        methods:{
            assignSlot(){
                this.$store.dispatch('slots/getDataOnAssignSlot',this.$route.params.id)
            }
        }

    }
</script>