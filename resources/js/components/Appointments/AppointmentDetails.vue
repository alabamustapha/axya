<template>
  <div class="container">
    
    <div class="d-block m-auto text-center bg-white">

      <div class="text-left shadow-lg p-3 mb-3">
        <h6 title="appointment status">
          <!-- {{appointment.statusTextOutput()}} -->
          <span :class="appointment.status_text_color" class="text-bold">
            <i class="fa fa-info-circle"></i>&nbsp;
            {{appointment.status_text}}
          </span>
        </h6>

        <hr>
        
        <p>{{appointment.patient_info}}</p>
      </div>
    </div>

    <div class="card">
      <div class="card-header bg-primary text-center p-2 mb-0">
        <span class="h4">Appointment Details</span>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-widget="collapse">
            <i class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="card-body p-2">
        <ul class="list-unstyled">
          <li class="tf-flex p-1">
            <span><i class="fa fa-calendar"></i> Date</span>
            <span class="text-bold">{{appointment.day}}</span>
          </li>

          <li class="tf-flex p-1">
            <span><i class="fa fa-clock"></i> Time</span>
            <span class="text-bold">
              <span v-text="appointment.start_time"></span>
                - 
              <span v-text="appointment.end_time"></span>
            </span>
          </li>

          <li class="tf-flex p-1">
            <span><i class="fa fa-stopwatch"></i> Duration</span>
            <span class="text-bold"><span>{{ appointment.duration }}</span></span>
          </li>

          <li class="tf-flex p-1">
            <span><i class="fa fa-donate"></i> Fee</span>
            <span class="text-bold">
              <span style="font-size: 14px;" class="badge badge-secondary badge-pill">
              $ <!--{{appointment.doctor.rate}}-->
              </span>
            </span>
          </li>

          <hr>
          <p title="Appointment status">{{appointment.status_text}}</p>
        </ul>
      </div>
      <div class="card-footer">
        <ul class="list-unstyled">
          <!-- @if (appointment.attendant_doctor) -->
          <span v-if="appointment.attendant_doctor">
            <li>
              <button class="btn btn-sm my-1 btn-primary">Accept & Confirm</button>
            </li>
            <li>
              <button class="btn btn-sm my-1 btn-danger">Reject</button>
            </li>
          </span>
          <!-- @elseif (appointment.creator) -->
          <span v-else-if="appointment.creator">
            <li>
              <button class="btn btn-sm my-1 btn-primary">Pay Consultation Fee</button>
            </li>
            <li>
              <button class="btn btn-sm my-1 btn-danger">Cancel</button>
            </li>  
          </span>
          <!-- @endif -->
          <span v-if="appointment.schedule_is_past">
            <li>
              <button class="btn btn-sm my-1 btn-secondary">Appointment Completed?</button>
            </li>

            <!-- @if (appointment.creator) -->
            <li class="text-bold" v-if="appointment.creator">
              <button class="btn btn-sm my-1 btn-info mb-3"><i class="fa fa-star"></i> Rate This Doctor</button>
              
              <!-- @include('doctors.partials.rating-form') -->
            </li>
            <!-- @endif -->
          </span>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['appointment'],

    // methods: {
    //   loadAppointmentPage() {
    //     axios.get('/appointment/'+ appointment.id)
    //     .then(({ data }) => (this.form.fill(data)));
    //     // axios.get('api/users')
    //     //     .then(({ data }) => (this.users = data.data)); // ES6 equivalent
    //   },
    // },

    // created() {
    //   this.loadAppointmentPage();
    //   Event.$on('RefreshPage', () => {
    //       this.loadAppointmentPage();
    //   });
    // }
  }
</script>