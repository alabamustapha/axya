<template>
  <div>
    <tr>
      
      <td>
        <div v-if="isDoctorOwner" class="justify-content-center">
          <table cols="1" cellspacing="0" cellpadding="0">
            <tbody>

              <tr>
                <td>
                  <label>
                    <!-- Use this to target a day -->
                    <input type="checkbox" v-model="sundayNew" @click="initSundaySchedule">
                  </label>
                </td>
              </tr>
              
            </tbody>
          </table>
        </div>
      </td>

      <td>
        <div class="px-3 font-weight-bold">
          <table cols="1" cellspacing="0" cellpadding="0">
            <tbody>

              <tr>
                <td>
                  <span>Sunday</span> <br>

                  <span><!--   v-if="isDoctorOwner -->
                    <button v-if="editing" @click="editing = false" title="Cancel edit">
                      <i class="fa fa-times text-warning"></i>
                      <span>Cancel</span>
                    </button>

                    <button v-else @click="editing = true" title="Edit">
                      <i class="fa fa-edit text-primary"></i>
                      <span>Edit</span>
                    </button>
                  </span>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </td>

      <td>
        <div v-for="(schedule, index) in schedules" :key="index">
          <table cols="2" cellspacing="0" cellpadding="0">
            <tbody>

              <tr>
                <td>
                  <div>
                    <table cols="3" cellspacing="0" cellpadding="0">
                      <tbody>
                        
                        <span v-if="creating">
                          <tr>
                            <td>
                              <!-- Start Time -->
                              <div>
                                <span placeholder="Time">
                                  <label id="">
                                    <input 
                                      class="sunday-time-field" placeholder="time" 
                                      v-model="schedules.startTime" type="text" 
                                      aria-autocomplete="list" aria-expanded="false" 
                                      autocomplete="off" autocorrect="off" disabled required 
                                    >
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
                                  <label id="">
                                    <input 
                                      class="sunday-time-field" placeholder="time" 
                                      v-model="schedules.endTime" type="text" 
                                      aria-autocomplete="list" aria-expanded="false" 
                                      autocomplete="off" autocorrect="off" disabled required 
                                    >
                                  </label>
                                </span>
                              </div>
                            </td>
                          </tr>
                        </span>
                        
                        <span v-else>
                          <tr v-for="schedule in sundaySchedules" :key="schedule.id" class="mb-1">
                            <td>
                              <!-- Start Time -->
                              <div>
                                <input 
                                  class="sunday-time-field"
                                  v-model="schedule.start" type="text" 
                                  disabled
                                >
                              </div>
                            </td>
                            <td>
                              <div>–</div>
                            </td>
                            <td>
                              <!-- End Time -->
                              <div>
                                <input 
                                  class="sunday-time-field"
                                  v-model="schedule.end" type="text" 
                                  disabled
                                >
                              </div>
                            </td>
                          </tr>
                        </span>
                        
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
                            <span v-if="creating || editing">
                              <button v-if="schedules.length < maxDailySchedules && index === (schedules.length - 1)" @click="addNewSundaySchedule" class="" title="Add New">
                                <i class="fa fa-plus text-primary"></i>
                                <!-- <span>Add</span> -->
                              </button>

                              <button v-if="index > 0 && index === (schedules.length - 1)" @click="removeASundaySchedule" class="" title="Delete">
                                <i class="fa fa-times text-danger"></i>
                                <!-- <span>Del</span> -->
                              </button>
                            </span>

                            <span v-if="creating || editing">
                              <button v-if="index === schedules.length - 1" @click="createSundaySchedule" class="ml-1" title="Save All">
                                <i class="fa fa-file text-info"></i>
                                <span>Save</span>
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

        <span class="text-danger" v-if="errorMsg" v-html="errorMsg"></span>
      </td>
    </tr>
  </div>
</template>

<script>
  export default {
    // props: ['doctorId'],
    
    data() {
      return {
        isDoctorOwner : true,
        doctorId : 30,//doctorId,
        sundaySchedules: {},
        dayId    : '1',

        maxDailySchedules : 3,
        creating   : false,
        editing    : false,
        sundayNew : false,
        addNew    : false,
        errorMsg   : null,
        schedules: [
          {
            startTime : null,
            endTime   : null,
            dayId     : '1',
          }
        ]
      }
    },

    created() {
      this.showSundaySchedules();
    },

    methods: {
      initSundaySchedule () {
        this.creating   = true;
        this.schedules.startTime = '9:00am';
        this.schedules.endTime   = '5:00pm';
        $('.sunday-time-field').attr('disabled', true);

        if (this.sundayNew) {
          $('.sunday-time-field').attr('disabled', true);
          this.schedules.startTime = null;
          this.schedules.endTime   = null;
          this.creating             = false;
        } else {
          $('.sunday-time-field').attr('disabled', false);
          this.schedules.startTime = '9:00am';
          this.schedules.endTime   = '5:00pm';
          this.creating             = true;
        }
      },
      addNewSundaySchedule () {
        // this.addNew = true;  
        $('.sunday-time-field').attr('disabled', false); 
        this.schedules.push({
          startTime : '5:00pm',
          endTime   : '11:00pm',
          day_id     : '1',
        })
      },
      removeASundaySchedule(index) {
        // this.addNew = false;   
        $('.sunday-time-field').attr('disabled', false); 
        this.schedules.splice(index, 1);
        // // then remove from db if this is update action.
      },

      createSundaySchedule() {
        if (this.startTime == null || this.endTime == null) {
          this.errorMsg = 'Schedule <strong>start</strong> or <strong>end time</strong> cannot be empty';
          setTimeout(() => { this.errorMsg = null; }, 7000);
          return false;
        }

        this.$Progress.start();
        axios.post('/schedules', {
          startTime : this.startTime,
          endTime   : this.endTime,
          day_id     : '1',
        })
        .then(() => {
          // Event.$emit('RefreshPage');
          $('.sunday-time-field').attr('readonly', 'true');
          $('.sunday-time-field').addClass('bg-light');
          toast({
              type: 'success',
              title: 'Schedule created successfully.'
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
      },

      editSundaySchedules() {
        //
      },

      cancelEditSundaySchedules() {
        //
      },
      
      showSundaySchedules() {
        // const scheduleUrl = appUrl +'/schedules/' + this.doctorId +'/' + this.sundayId);
        axios.get('/schedules/' + this.doctorId +'/' + this.dayId)
        .then(({data}) => (this.sundaySchedules = data))
        .then(() => {
          console.log(this.sundaySchedules);
        })
      },
    },
  }
</script>