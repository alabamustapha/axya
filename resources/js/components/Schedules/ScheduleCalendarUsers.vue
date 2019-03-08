<template>
  <div>
    <!-- 
      events-on-month-view="short"
      vuecal--rounded-theme // has been overriden in the styles thus not potent
    -->
    <vue-cal
        :disable-views="['years']"
        :events="events"
        :time-step="15"
        :time-from="7 * 60" 
        class="vuecal--blue-theme"
        default-view="month"
        no-event-overlaps
        hide-view-selector
        startWeekOnSunday
    >
        <i slot="arrowPrev" aria-hidden="true" class="fa fa-arrow-left"></i>
        <i slot="arrowNext" aria-hidden="true" class="fa fa-arrow-right"></i>
        
        <div slot="event-renderer" slot-scope="{ event, view }">
          <i class="fa fa-2x" :class="event.icon "></i>

          <div class="vuecal__event-title" v-html="event.title" />

          <small class="vuecal__event-time d-block clearfix">
            <strong>Start:</strong> <span>{{ event.startTime }}</span>
            <span>-</span>
            <strong>End:</strong> <span>{{ event.endTime }}</span>
          </small>
        </div>
    </vue-cal>
  </div>
</template>

<script>
  // https://antoniandre.github.io/vue-cal/
  import VueCal from 'vue-cal'
  import 'vue-cal/dist/vuecal.css'
  export default {
    components: { VueCal },

    props: ['userId'],

    data () {
      return {
        overlapEvents: false,
        minCellWidth  : 150,
        timeCellHeight: 90,
        
        events: [],
      }
    },

    created() {
      this.getEvents();
    },

    methods: {
      getEvents() { 
        // route('events.index') | {user}/events
        axios.get(this.userId + '/events/')
        .then(({data}) => {
          this.events = data;
          // console.log(this.events);
        })
      },
    }
  }
</script>

<style>
  .vuecal__cells.years-view .vuecal__cell,
  .vuecal__cells.year-view .vuecal__cell,
  .vuecal__cells.month-view .vuecal__cell {height:70px;}
  .vuecal__event .vuecal__event-title {font-weight:bold;display:inline-block;padding:5px;margin-bottom:3px;}

  /* Cell background indicator */
  .vuecal__cell--has-events {background-color: #fffacd;}
  .vuecal__cell-events-count {display: block;}/*none*/

  /* Cell Event Type Background */
  .vuecal__event.others {background-color: #0ffac0;}
  .vuecal__event.medication {background-color: #ff09cd;color: #fff9f9;}
  .vuecal__event.home-appointment {background-color: #fffa00;}
  .vuecal__event.online-appointment {background-color: #a0facd;}

  .vuecal__event.fee {
    background: repeating-linear-gradient(45deg, #ffffff, #ffffff 10px, #f2f2f2 10px, #f2f2f2 20px);/* IE 10+ */
    color: #999;
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .vuecal__event.fee .vuecal__event-time {align-items: center;}
</style>