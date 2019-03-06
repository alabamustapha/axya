<template>
  <div>
    <!-- 
      events-on-month-view="short"
      vuecal--rounded-theme // has been overriden in the styles thus not potent
    -->
    <vue-cal
        :disable-views="['years']"
        :events="events"
        class="vuecal--blue-theme"
        default-view="month"
        no-event-overlaps
        hide-view-selector
        startWeekOnSunday
    >
        <i slot="arrowPrev" aria-hidden="true" class="fa fa-arrow-left"></i>
        <i slot="arrowNext" aria-hidden="true" class="fa fa-arrow-right"></i>
    </vue-cal>
  </div>
</template>

<script>
  // https://antoniandre.github.io/vue-cal/
  import VueCal from 'vue-cal'
  import 'vue-cal/dist/vuecal.css'
  export default {
    components: { VueCal },

    data () {
      return {
        minCellWidth: 150,
        timeCellHeight: 70,
        
        events: [
          {
            start: '2019-03-05 10:35',
            end: '2019-03-05 11:30',
            title: 'Doctor Appointment (Online)',
            content: '<i class="fa fa-hospital"></i>',
            contentFull: '<i class="fa fa-hospital"></i>',
            class: 'online-appointment',
          },
          {
            start: '2019-03-06 18:30',
            end: '2019-03-06 23:15',
            title: 'Hospital Appointment',
            content: 'Visit Dr. J.K at Metropolitan hospital, Istanbul <br> <i class="fa fa-hospital fa-2x"></i>.',
            contentFull: 'Visit Dr. J.K at Metropolitan hospital, Istanbul <br> <i class="fa fa-hospital fa-2x"></i>.',
            class: 'home-appointment',
          },
          {
            start: '2019-03-06 18:30',
            end: '2019-03-06 23:15',
            title: 'Take Medication',
            content: '<i class="fa fa-pills fa-2x"></i>',
            contentFull: '<i class="fa fa-pills fa-2x"></i>',
            class: 'medication',
          },
          {
            start: '2019-03-06 12:00',
            end: '2019-03-06 13:00',
            title: 'Appointment Fee Payment Countdown',
            class: 'fee',
            background: true
          },
          {
            start: '2019-03-07 18:30',
            end: '2019-03-07 20:30',
            title: 'Crossfit',
            content: '<i class="fa fa-cogs 2x"></i>',
            contentFull: '<i class="fa fa-cogs 2x"></i>',
            class: 'others',
          },

        ],
      }
    }
  }
</script>

<style>
  .vuecal__cells.years-view .vuecal__cell,
  .vuecal__cells.year-view .vuecal__cell,
  .vuecal__cells.month-view .vuecal__cell {height:70px;}
  .vuecal__event .vuecal__event-title {font-weight:bold;}

  /* Cell background indicator */
  .vuecal__cell--has-events {background-color: #fffacd;}
  .vuecal__cell-events-count {display: block;}/*none*/

  /* Cell Event Type Background */
  .vuecal__event.others {background-color: #0ffac0;}
  .vuecal__event.medication {background-color: #ff09cd;color: #fff9f9;}
  .vuecal__event.home-appointment {background-color: #fffa00;}
  .vuecal__event.online-appointment {background-color: #a0facd;}

  .vuecal__event.fee {
    background: repeating-linear-gradient(45deg, transparent, transparent 10px, #f2f2f2 10px, #f2f2f2 20px);/* IE 10+ */
    color: #999;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .vuecal__event.fee .vuecal__event-time {align-items: center;}
</style>