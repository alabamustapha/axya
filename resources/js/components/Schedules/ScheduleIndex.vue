<template>
  <div class="schedule-table table-responsive">
    <table cellspacing="0" cellpadding="0" style="table">
      <tbody>
        <tr>
          <td>
            <div class="px-3 text-center">
              <h5 class="font-weight-bold text-uppercase">Schedules</h5>
            </div>
          </td>
        </tr>
        </tr>
          <td>
            <!-- Availability Hours -->
            <div v-if="isDoctorOwner" class="px-3 mb-2 border-bottom">
              <div class="d-block">
                <label>
                  <input type="radio" name="avialability_type"> &nbsp;
                  <span>Available Always</span>
                </label>
              </div>
              <div class="d-block">
                <label>
                  <input type="radio" name="avialability_type"> &nbsp;
                  <span>Available on Selected Hours</span>
                </label>
              </div>
              <div class="d-block">
                <label>
                  <input type="radio" name="avialability_type"> &nbsp;
                  <span>Not Available</span>
                </label>
              </div>
            </div>

            <!-- Availability Hours Gangan -->
            <div class="px-3 schedule-table__font-size">
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

    props: ['doctorId', 'isDoctorOwner'],//

    data () {
      return {
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