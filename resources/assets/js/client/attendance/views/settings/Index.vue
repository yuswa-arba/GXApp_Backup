<template>
    <div class="row">
        <!--<shift-card></shift-card>-->
        <div class="col-lg-12">
            <div class="card card-borderless">
                <ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="dropdownfx">

                    <li class="nav-item">
                        <a class="active" href="#" data-toggle="tab" role="tab" data-target="#tabShifts">Shifts</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#tabSlots">Slots</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#tabKiosk">Kiosk</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#tabPublicHoliday">Holidays</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#tabDayOff">Dayoff</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#tabManagers">Managers</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" data-toggle="tab" role="tab" data-target="#tabGeofence">Geofence</a>
                    </li>


                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tabShifts">
                        <shift-tab></shift-tab>
                    </div>
                    <div class="tab-pane " id="tabSlots">
                        <slot-tab></slot-tab>
                    </div>
                    <div class="tab-pane" id="tabKiosk">
                        <kiosk-tab></kiosk-tab>
                    </div>
                    <div class="tab-pane" id="tabPublicHoliday">
                        <public-holiday-tab></public-holiday-tab>
                    </div>
                    <div class="tab-pane" id="tabDayOff">
                        <day-off-tab></day-off-tab>
                    </div>
                    <div class="tab-pane" id="tabManagers">
                        <manager-tab></manager-tab>
                    </div>
                    <div class="tab-pane" id="tabGeofence">
                        <geofence-tab></geofence-tab>
                    </div>

                    <div class="tab-pane" id="tabMisc">
                        <misc-tab></misc-tab>
                    </div>
                </div>
            </div>

        </div>

    </div>

</template>
<script type="text/javascript">
    import ShiftTab from '../../components/settings/ShiftTab.vue'
    import SlotTab from '../../components/settings/SlotTab.vue'
    import DayOffTab from '../../components/settings/DayOffTab.vue'
    import PublicHolidayTab from '../../components/settings/PublicHolidayTab.vue'
    import ManagerTab from '../../components/settings/ManagerTab.vue'
    import GeofenceTab from '../../components/settings/GeofenceTab.vue'
    import KioskTab from '../../components/settings/KIoskTab.vue'
    import MiscTab from '../../components/settings/MiscTab.vue'

    export default{
        components: {
            'shift-tab': ShiftTab,
            'slot-tab': SlotTab,
            'day-off-tab': DayOffTab,
            'public-holiday-tab': PublicHolidayTab,
            'manager-tab': ManagerTab,
            'geofence-tab': GeofenceTab,
            'kiosk-tab': KioskTab,
            'misc-tab': MiscTab,

        },
        mounted(){

        }
    }
</script>