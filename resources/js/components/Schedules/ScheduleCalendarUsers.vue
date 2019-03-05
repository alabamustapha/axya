<template>
  <div>
    <!-- vuecal--rounded-theme  -->
    <vue-cal 
        hide-view-selector
        class="vuecal--blue-theme"
        default-view="month"
        :time-step="30"
        :events="events"
        :on-event-click="onEventclick"
    >
    </vue-cal>
    
    <v-dialog v-model="showDialog">
      <v-card>
        <v-card-title>
          <v-icon>{{ selectedEvent.icon }}</v-icon>
          <span>{{ selectedEvent.title }}</span>
          <v-spacer/>
          <strong>{{ selectedEvent.startDate }}</strong>
        </v-card-title>
        <v-card-text>
          <p v-html="selectedEvent.contentFull"/>
          <strong>Event details:</strong>
          <ul>
            <li>Event starts at: {{ selectedEvent.startTime }}</li>
            <li>Event ends at: {{ selectedEvent.endTime }}</li>
          </ul>
        </v-card-text>
      </v-card>
    </v-dialog>
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
            title: 'Doctor appointment',
            content: '<i class="fa fa-hospital"></i>',
            class: 'health',
            split: 1
          },
          {
            start: '2019-03-05 18:30',
            end: '2019-03-05 23:15',
            title: 'Dentist appointment',
            content: '<i class="fa fa-hospital fa-3x"></i>',
            class: 'health',
            split: 2
          },
          {
            start: '2019-03-04 18:30',
            end: '2019-03-04 20:30',
            title: 'Crossfit',
            content: '<i class="fa fa-cogs 2x"></i>',
            class: 'sport',
            split: 2
          },

        ],
      }
    }
  }
</script>

<style>
  .vuecal__cells.years-view .vuecal__cell,
  .vuecal__cells.year-view .vuecal__cell,
  .vuecal__cells.month-view .vuecal__cell,
  .vuecal__cells.week-view .vuecal__cell {height:70px;}
  /*.vuecal__cells.day-view .vuecal__cell {height:70px;}*/
</style>