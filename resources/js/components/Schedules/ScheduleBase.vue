<template>
  <div class="py-2 border-bottom">
    <tr class="">
      
      <td>
        <div v-if="isDoctorOwner" class="justify-content-center">
          <table cols="1" cellspacing="0" cellpadding="0">
            <tbody>

              <tr>
                <td>
                  <label>
                    <input type="checkbox" v-model="editScheduleCheck" @click="initSchedule">
                  </label>
                </td>
              </tr>
              
            </tbody>
          </table>
        </div>
      </td>

      <td>
        <div class="px-3">
          <table cols="1" cellspacing="0" cellpadding="0">
            <tbody>

              <tr>
                <td>
                  <span class="font-weight-bold" style="width:70px;display:inline-block">{{ dayName }}</span> 

                  <button v-if="editScheduleCheck && !editing" @click="editing = true" title="Edit">
                    <i class="fa fa-edit text-primary"></i>
                    <span>Edit</span>
                  </button>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </td>


      <td>
        <div v-if="editing">
          <div v-for="(schedule, index) in daySchedules" :key="index">
            <table cols="2" cellspacing="0" cellpadding="0">
              <tbody>

                <tr>
                  <td>
                    <div>
                      <table cols="3" cellspacing="0" cellpadding="0">
                        <tbody>
                          
                          <tr>
                            <td>
                              <!-- Start Time -->
                              <div>
                                <span placeholder="Time">
                                  <label>
                                    <input type="time"
                                      :id="'start_at_' + index" class="day-time-field"
                                      v-model="schedule.start_at"
                                      @keyup="regCleanUp('start_at_' + index)"
                                      required
                                    >
                                      <!-- type="text" 
                                      aria-autocomplete="list" aria-expanded="false" 
                                      autocomplete="off" autocorrect="off" minlength="8" maxlength="8" placeholder="08:00:00" -->
                                  </label>
                                </span>
                              </div>
                            </td>
                            <td>
                              <div>–</div>
                            </td>
                            <td>
                              <!-- End Time -->
                              <div>
                                <span placeholder="Time">
                                  <label>
                                    <input type="time" 
                                      :id="'end_at_' + index" class="day-time-field" 
                                      v-model="schedule.end_at"
                                      @keyup="regCleanUp('end_at_' + index)"
                                      required 
                                    >
                                      <!-- type="text" 
                                      aria-autocomplete="list" aria-expanded="false" 
                                      autocomplete="off" autocorrect="off" minlength="8" maxlength="8" placeholder="23:59:59" -->
                                  </label>
                                </span>
                              </div>
                            </td>
                          </tr>

                        </tbody>
                      </table>
                    </div>
                  </td>

                  <td>
                    <div class="px-1">
                      <table cols="1" cellspacing="0" cellpadding="0">
                        <tbody>

                          <tr>
                            <td>
                              <span v-if="editing">
                                <button v-if="index >= 0 && index === (daySchedules.length - 1)" @click="removeASchedule(index)" class="" title="Delete">
                                  <i class="fa fa-times text-danger"></i>
                                </button>
                              </span>
                            </td>
                          </tr>
                          
                        </tbody>
                      </table>
                    </div>
                  </td>
                </tr>

              </tbody>
            </table>
          </div>

          <div id="errorMsg" v-if="errorMsg" v-html="errorMsg"></div>
        </div>

          
        <div class="pt-2 border-top">
          <table v-if="isDoctorOwner" cols="2" cellspacing="0" cellpadding="0">
            <tbody>
              <tr>      

                <td>
                  <div class="mr-2">
                    <button v-if="editing" @click="cancelEditSchedules" title="Cancel edit">
                      <i class="fa fa-times text-danger"></i>
                      <span>Cancel Editing</span>
                    </button>
                  </div>
                </td>
                <td>
                  <div v-if="editing">
                    <button v-if="(daySchedules.length < maxDailySchedules)" @click="addNewSchedule" class="" title="Add New">
                      <i class="fa fa-plus text-primary"></i>&nbsp;
                      <span>Add New</span>
                    </button>

                    <button @click="createSchedule" class="" title="Save All">
                      <i class="fa fa-file text-info"></i>&nbsp;
                      <span>Save</span>
                    </button>
                  </div>
                </td>

              </tr>
            </tbody>
          </table>
        </div>
      </td>

      <!-- Normal User's View -->
      <td v-if="!editing">
        <div v-if="daySchedules.length">
          <table cols="1" cellspacing="0" cellpadding="0">
            <tbody>

              <tr>
                <td>
                  <div>
                    <table cols="3" cellspacing="0" cellpadding="0">
                      <tbody>

                        <tr v-for="schedule in daySchedules" :key="schedule.id" class="mb-1">
                          <td>
                            <!-- Start Time -->
                            <div class="mb-1">
                              <input 
                                class="day-time-field bg-white border-0 text-center"
                                v-model="schedule.start" type="text" 
                                disabled
                              >
                            </div>
                          </td>
                          <td>
                            <div class="mb-1">–</div>
                          </td>
                          <td>
                            <!-- End Time -->
                            <div class="mb-1">
                              <input 
                                class="day-time-field bg-white border-0 text-center"
                                v-model="schedule.end" type="text" 
                                disabled
                              >
                            </div>
                          </td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                </td>
              </tr>

            </tbody>
          </table>

        </div>
        <div v-else v-show="!loading" class="text-center">
          <span>Not available on {{ dayName }}</span>
        </div>

        <!-- <loading-spinner :spinner-loading="spinnerLoading"></loading-spinner> -->
        <div class="text-center" v-show="loading">
          <span class="d-inline-block fa-1x h6">
            <i class="fas fa-sync fa-spin"></i>
          </span>
        </div>
      </td>
      <!-- ./Normal User's View -->

    </tr>
  </div>
</template>

<script>
  export default {
    props: ['doctorId', 'isDoctorOwner', 'dayId', 'dayName'],
    
    data() {
      return {
        // isDoctorOwner  :...,    // Logged in user is the doctor who owns presently viewed account?
        loading           : true,  // Still fetching contents
        daySchedules      : {},    // A day's schedules

        maxDailySchedules : 3,     // Maximum schedules that can be added for a day. Controls Add New button
        editing           : false, // Editing in progress?
        editScheduleCheck : false, // Checkbox toggles the activation of editing
        addNew            : false, // ?
        errorMsg          : null,  // Used in giving instant feedback.
        schedules: [               // Schedules available in db or just getting pushed in.
          {
            start_at : null,
            end_at   : null,
          }
        ]
      }
    },

    created() {
      this.showSchedules();
    },

    computed: {
      // spinnerLoading () {
      //   return this.loading ? true : false;
      // },
    },

    methods: {
      initSchedule () {
        // The workings of checkbox is weird "checked == false" sort of.
        if (this.editScheduleCheck == true) {
          this.cancelEditSchedules();
        }
      },
      addNewSchedule () {
        this.daySchedules.push({
          start_at : '',
          end_at   : '',
        })
      },

      removeASchedule(index) {
        // if (confirm('You really want to remove this schedule?')){
          this.daySchedules.splice(index, 1);
        // }
      },

      createSchedule() {
        if (this.daySchedules.length) {

          this.$Progress.start();
          axios.post('/schedules', {
            schedules : this.daySchedules, // array()
            day_id    : this.dayId,
            doctor_id : this.doctorId,
          })
          .then((response) => {
            this.editing = false;
            this.showSchedules();
            let message = response.data.status;
            console.log(message);

            toast({
                type: 'success',
                title: message,//'Schedule created successfully.'
            });
            this.$Progress.finish();            
          })
          .catch(() => {
            toast({
                type: 'error',
                title: 'Something went wrong! Try again later.'
            });
            this.$Progress.fail();
          });
        }
        else if (this.start_at == null || this.end_at == null) {
          this.errorMsg = '<span class="text-danger">Schedule <strong>start</strong> or <strong>end time</strong> cannot be empty</span>';
          setTimeout(() => { this.errorMsg = null; }, 7000);
          return false;
        }
      },

      editSchedules() {
        this.editing   = true;
      },

      cancelEditSchedules() {
        this.editing   = false;
        this.showSchedules()
      },
      
      showSchedules() {
        axios.get('/schedules/' + this.doctorId +'/' + this.dayId)
        .then(({data}) => (this.daySchedules = data))
        .then(() => { this.loading = false; })
      },

      // regCleanUp(elem){
      //   let inputField = document.getElementById(elem);
      //   let regX = new RegExp;
      //       regX = /[^0-9:]/gi;
      //   // Check at: regexr.com/ or regexpal.com/
      //   let regXpattern = /(([0-1]{1}[0-9]{1})|([0-2]{1}[0-3]{1})):[0-5]{1}[0-9]{1}:[0-5]{1}[0-9]{1}/gi; // 00:00:00 - 23:59:59

      //   inputField.value = inputField.value.replace(regX, "");

      //   if (inputField.value.length == 8){
      //     if (inputField.value.match(regXpattern)) {
      //       this.errorMsg = '<span class="text-success">Valid!</span>';
      //       setTimeout(() => { this.errorMsg = null; }, 7000);

      //       // Not used for now because it is tripping off after some seconds/losing focus.
      //       // this.reformattedTime(elem);
      //     }
      //     else {

      //       this.errorMsg = '<span class="text-danger">Time must be <b>24-hour format</b>, highest is: <b>23:59:59</b></span>';
      //       setTimeout(() => { this.errorMsg = null; }, 7000);
      //    }
      //   }
      // },

      // reformattedTime(elem){
      //   let inputField = document.getElementById(elem);
      //   let timeArr = inputField.value.split(':');
      //   let hour = timeArr[0];
      //   let min = timeArr[1];
      //   let sec = timeArr[2];

      //   hour = hour < 23 ? hour:23;
      //   min  = min  < 59 ? min :59;
      //   sec  = sec  < 59 ? sec :59;
      //   let reformat = hour +':'+ min +':'+ sec;
      //   console.log(reformat);
      //   inputField.value = reformat;
      //   // $('#'+elem).val(reformat);
      // },
    },
  }
</script>