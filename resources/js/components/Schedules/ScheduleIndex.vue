<template>
  <div class="col schedule-table table-responsive">
    <table cellspacing="0" cellpadding="0" class="w-100">
      <tbody>
        <tr>
          <td>
            <div class="px-3">
              <h5 class="font-weight-bold text-uppercase">Schedules</h5>
              <ul v-if="isDoctorOwner" class="list-unstyled ml-3 text-muted font-weight-bold">
                <li><i class="fa fa-check-square"></i> Tick any checkbox to edit.</li>
                <li><i class="fa fa-minus-square"></i> Untick to cancel editing.</li>
              </ul>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <!-- Availability Hours -->
            <div v-if="isAvailable" class="px-3 schedule-table__font-size">
              <div>
                <table cols="3" cellspacing="0" cellpadding="0">
                  <tbody>

                    <div 
                        v-for="(day, index) in days" 
                        :key="index" 
                        :class="(index % 2) == 0 ? 'bg-light':'bg-white'">

                        <schedule-base 
                          :day-id="index + 1" 
                          :day-name="day" 
                          :doctor-id="doctorId"
                          :is-doctor-owner="isDoctorOwner"
                          ></schedule-base>

                    </div>

                  </tbody>
                </table>
              </div>
            </div>
            <div v-else class="px-3 schedule-table__font-size">

              <div class="col mb-3 text-center font-weight-bold border border-danger rounded">
                <div class="display-3"><i class="fa fa-calendar-times red"></i></div>
                <p class="text-sm red font-weight-bold">
                  Not available for appointments at this time.
                </p>
              </div>

            </div>
            <!-- \Availability Hours Gangan -->
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  import ScheduleBase from './ScheduleBase.vue'
  export default {
    components: {
      'schedule-base': ScheduleBase,
    },

    props: ['doctorId', 'isDoctorOwner'],//, 'isAvailable'

    data () {
      return {
        isAvailable       : true, // Remember to use the props own, this is for testing.
        days : [
          'Sunday',
          'Monday',
          'Tuesday', 
          'Wednesday',
          'Thursday',
          'Friday',
          'Saturday',
        ],
      }
    }
  }
</script>

<style>
  .schedule-table {
    color: #660f0b;
    font-size: 14px;
  }
  .schedule-table__font-size {
    color: gray;
    font-size: 12px;
  }

  td div label input[type='text'] {
    font-family: monospace;    
    padding-left: 10px;
    box-sizing: border-box;
  }
</style>