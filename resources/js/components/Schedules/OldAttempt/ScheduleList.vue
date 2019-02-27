<template>
  <div class="card card-dark">

    <div class="card-header">
      <h3 class="card-title">
        Schedules
      </h3>
    </div>
    <div class="card-body box-profile">

      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th>Day</th>
            <th>Periods</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <th>
              <span class="tf-flex">
                Sunday
                <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
              </span>
            </th>

            <td class="tf-flex" v-for="schedule in sundaySchedules" :key="schedule.id"><!--  v-bind:day="1" -->
              <span>
                <span v-text="schedule.start"></span> - <span v-text="schedule.end"></span>
              </span>
              <span class="w-25 tf-flex">
                <span data-toggle="modal" data-target="#updateScheduleForm" title=" Update time">
                  <i class="fa fa-edit teal"></i> 
                </span>
                / 
                <i class="fa fa-times red"></i>
              </span>
            </td>
            <td v-if="! sundaySchedules.length" v-else class="d-flex justify-content-center">
              <span title="Not Available">-na-</span>
            </td>
          </tr>

          <tr>
            <th>
              <span class="tf-flex">
                Monday
                <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
              </span>
            </th>

            <td class="tf-flex" v-for="schedule in mondaySchedules" :key="schedule.id"><!--  v-bind:day="1" -->
              <span>
                <span v-text="schedule.start"></span> - <span v-text="schedule.end"></span>
              </span>
              <span class="w-25 tf-flex">
                <span title="Update time">
                  <i class="fa fa-edit teal"></i> 
                </span>
                / 
                <i class="fa fa-times red"></i>
              </span>
            </td>
            <td v-if="! mondaySchedules.length" v-else class="d-flex justify-content-center">
              <span title="Not Available">-na-</span>
            </td>
          </tr>

          <tr>
            <th>
              <span class="tf-flex">
                Tuesday
                <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
              </span>
            </th>

            <td class="tf-flex" v-for="schedule in tuesdaySchedules" :key="schedule.id"><!--  v-bind:day="1" -->
              <span>
                <span v-text="schedule.start"></span> - <span v-text="schedule.end"></span>
              </span>
              <span class="w-25 tf-flex">
                <span title="Update time">
                  <i class="fa fa-edit teal"></i> 
                </span>
                / 
                <i class="fa fa-times red"></i>
              </span>
            </td>
            <td v-if="! tuesdaySchedules.length" v-else class="d-flex justify-content-center">
              <span title="Not Available">-na-</span>
            </td>
          </tr>

          <tr>
            <th>
              <span class="tf-flex">
                Wednesday
                <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
              </span>
            </th>

            <td class="tf-flex" v-for="schedule in wednesdaySchedules" :key="schedule.id"><!--  v-bind:day="1" -->
              <span>
                <span v-text="schedule.start"></span> - <span v-text="schedule.end"></span>
              </span>
              <span class="w-25 tf-flex">
                <span title="Update time">
                  <i class="fa fa-edit teal"></i> 
                </span>
                / 
                <i class="fa fa-times red"></i>
              </span>
            </td>
            <td v-if="! wednesdaySchedules.length" v-else class="d-flex justify-content-center">
              <span title="Not Available">-na-</span>
            </td>
          </tr>

          <tr>
            <th>
              <span class="tf-flex">
                Thursday
                <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
              </span>
            </th>

            <td class="tf-flex" v-for="schedule in thursdaySchedules" :key="schedule.id"><!--  v-bind:day="1" -->
              <span>
                <span v-text="schedule.start"></span> - <span v-text="schedule.end"></span>
              </span>
              <span class="w-25 tf-flex">
                <span title="Update time">
                  <i class="fa fa-edit teal"></i> 
                </span>
                / 
                <i class="fa fa-times red"></i>
              </span>
            </td>
            <td v-if="! thursdaySchedules.length" v-else class="d-flex justify-content-center">
              <span title="Not Available">-na-</span>
            </td>
          </tr>

          <tr>
            <th>
              <span class="tf-flex">
                Friday
                <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
              </span>
            </th>

            <td class="tf-flex" v-for="schedule in fridaySchedules" :key="schedule.id"><!--  v-bind:day="1" -->
              <span>
                <span v-text="schedule.start"></span> - <span v-text="schedule.end"></span>
              </span>
              <span class="w-25 tf-flex">
                <span title="Update time">
                  <i class="fa fa-edit teal"></i> 
                </span>
                / 
                <i class="fa fa-times red"></i>
              </span>
            </td>
            <td v-if="! fridaySchedules.length" v-else class="d-flex justify-content-center">
              <span title="Not Available">-na-</span>
            </td>
          </tr>

          <tr>
            <th>
              <span class="tf-flex">
                Saturday
                <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
              </span>
            </th>

            <td class="tf-flex" v-for="schedule in saturdaySchedules" :key="schedule.id"><!--  v-bind:day="1" -->
              <span>
                <span v-text="schedule.start"></span> - <span v-text="schedule.end"></span>
              </span>
              <span class="w-25 tf-flex">
                <span title="Update time">
                  <i class="fa fa-edit teal"></i> 
                </span>
                / 
                <i class="fa fa-times red"></i>
              </span>
            </td>
            <td v-if="! saturdaySchedules.length" v-else class="d-flex justify-content-center">
              <span title="Not Available">-na-</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['doctor_id','day'],

    // data() {
    //   return {
    //     uid: this.auth.id,
    //     interestsCount: this.report.follows_count,
    //     hasShownInterest: this.report.hasShownInterest,
    //   }
    // },
    data() {
      return {
        doctorId : this.doctor_id,
        sundaySchedules: {},
        sundayId    : '1',

        mondaySchedules: {},
        mondayId    : '2',

        tuesdaySchedules: {},
        tuesdayId   : '3',

        wednesdaySchedules: {},
        wednesdayId : '4',

        thursdaySchedules: {},
        thursdayId  : '5',

        fridaySchedules: {},
        fridayId    : '6',

        fridaySchedules: {},
        fridayId    : '7',

        scheduleUrl : appUrl +'/schedules/'
      }
    },

    // mounted() {
    //   this.loadSchedules();
    // },

    created() {
      this.loadSundaySchedules();
      this.loadMondaySchedules();
      this.loadTuesdaySchedules();
      this.loadWednesdaySchedules();
      this.loadThursdaySchedules();
      this.loadFridaySchedules();
      this.loadSaturdaySchedules();
    },

    methods: {
      loadSundaySchedules() {
        // const scheduleUrl = appUrl +'/schedules/' + this.doctorId +'/' + this.sundayId);
        axios.get(this.scheduleUrl + this.doctorId +'/' + this.sundayId)
        .then(({data}) => (this.sundaySchedules = data))
      },
      loadMondaySchedules() {
        // const scheduleUrl = appUrl +'/schedules/' + this.doctorId +'/' + this.mondayId);
        axios.get(this.scheduleUrl + this.doctorId +'/' + this.mondayId)
        .then(({data}) => (this.mondaySchedules = data))
      },
      loadTuesdaySchedules() {
        // const scheduleUrl = appUrl +'/schedules/' + this.doctorId +'/' + this.tuesdayId);
        axios.get(this.scheduleUrl + this.doctorId +'/' + this.tuesdayId)
        .then(({data}) => (this.tuesdaySchedules = data))
      },
      loadWednesdaySchedules() {
        // const scheduleUrl = appUrl +'/schedules/' + this.doctorId +'/' + this.wednesdayId);
        axios.get(this.scheduleUrl + this.doctorId +'/' + this.wednesdayId)
        .then(({data}) => (this.wednesdaySchedules = data))
      },
      loadThursdaySchedules() {
        // const scheduleUrl = appUrl +'/schedules/' + this.doctorId +'/' + this.thursdayId);
        axios.get(this.scheduleUrl + this.doctorId +'/' + this.thursdayId)
        .then(({data}) => (this.thursdaySchedules = data))
      },
      loadFridaySchedules() {
        // const scheduleUrl = appUrl +'/schedules/' + this.doctorId +'/' + this.fridayId);
        axios.get(this.scheduleUrl + this.doctorId +'/' + this.fridayId)
        .then(({data}) => (this.fridaySchedules = data))
      },
      loadSaturdaySchedules() {
        // const scheduleUrl = appUrl +'/schedules/' + this.doctorId +'/' + this.saturdayId);
        axios.get(this.scheduleUrl + this.doctorId +'/' + this.saturdayId)
        .then(({data}) => (this.saturdaySchedules = data))
      }
    }
  }
</script>
