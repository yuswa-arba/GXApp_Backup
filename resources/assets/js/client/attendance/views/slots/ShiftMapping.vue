<template>
    <div class="row">
        <div class="col-lg-12 m-b-10 m-t-10">
            <slot name="go-back-menu"></slot>
        </div>
        <div class="col-lg-4 m-b-10">
            <div class="card card-default">
                <div class="card-header ">
                    <div class="card-title">Slot List
                    </div>
                </div>
                <div class="card-block">
                    <div class="scrollable">
                        <div class=" h-500">
                            <div class="checkbox padding-10">
                                <input type="checkbox" id="cbAll">
                                <label for="cbAll">All</label>
                                <i class="fa fa-circle text-danger"></i>
                            </div>
                            <div class="checkbox padding-10" v-for="(slot,index) in slotsBeingMap">
                                <input type="checkbox"
                                       :value="slot.id"
                                       :id="'cbSlot'+index">
                                <label :for="'cbSlot'+index">{{slot.name}}</label>
                                <i class="fa fa-circle" :style="{color:'#'+shiftMapPalette[index]}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 m-b-10">
            <div class="widget-11-2 card no-border card-condensed no-margin widget-loader-circle align-self-stretch d-flex flex-column">
                <div class="card-block padding-30">
                    <div id="calendar-shift-mapping"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    export default{

        data(){
          return{
          }
        },
        computed:{
            ...mapGetters('slots',{
                slotsBeingMap:'slotsBeingMap',
                shiftMapPalette :'shiftMapPalette'
            })
        },
        methods:{

        },
        mounted(){

            $('#calendar-shift-mapping').fullCalendar({
                header: {
                    left: 'prev,next today removeSource',
                    center: 'title',
                    right: 'month,basicWeek,basicDay'
                },
                selectable: true,
                selectHelper: true,
                select: function (start, end) {
//                  alert(moment(start).format('DD/MM/YYYY'))
                },
                eventRender: function (event, element, view) {
                    element.on('click', () => {
                        console.log(moment(event.start).format('DD/MM/YYYY'))
                    })
                },
            })
        },
    }
</script>