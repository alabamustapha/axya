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
          <button type="button" class="btn btn-tool" data-wslugget="collapse">
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
          <span>
            <span v-if="appointment.attendant_doctor && appointment.status == '0'">
              <!-- <li class="border-bottom pb-1 mb-2">Doctor Section</li> -->
              <li>
                <button class="btn btn-sm my-1 btn-primary"
                  @click="acceptAppointment(appointment.slug)">
                  Accept Appointment
                </button>
              </li>
              <li class="mb-2">
                <button class="btn btn-sm my-1 btn-danger"
                  @click="rejectAppointment(appointment.slug)">Reject Appointment</button>
              </li>
            </span>

            <span v-if="appointment.creator">
              <!-- <li class="border-bottom pb-1 mb-2">Patient Section</li> -->
              <li v-if="appointment.status == '2'">
                <button class="btn btn-sm my-1 btn-primary"
                  @click="payConsultationFee(appointment.slug)">Pay Consultation Fee</button>
              </li>
              <li v-if="appointment.status == '0'" class="mb-2">
                <button class="btn btn-sm my-1 btn-danger"
                  @click="cancelAppointment(appointment.slug)">Cancel Appointment</button>
              </li>  
            </span>
          </span>

          <span v-if="appointment.schedule_is_past">
            <li v-if="! appointment.status == '1'">
              <button class="btn btn-sm my-1 btn-secondary" 
                @click="appointmentCompleted(appointment.slug)">Appointment Completed?</button>
            </li>

            <li class="text-bold" v-if="appointment.creator && appointment.status == '1'"><!--  && appointment.rated == '0' -->
              <button class="btn btn-sm my-1 btn-info mb-3"><i class="fa fa-star"></i> Rate This Doctor</button>
              <br>
              
              <!-- @include('doctors.partials.rating-form') -->
              ('Doctors Rating Form Here')
            </li>
          </span>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['appointment'],

    data() {
      return {
        status: this.appointment.status,
      };
    },

    methods: {      
      appointmentCompleted(slug) { 
        // Appointment/Consultation completed successfully.
        if (confirm('Is this appointment completed?')){
          this.$Progress.start();
          axios.patch('/appointments/'+ slug +'/complete')
          .then(()=> {
            this.status = '1';
            toast({
              type: 'success',
              title: 'Appointment completed successfully.'
            });
            this.$Progess.finish();
          })
        }
      },
      
      acceptAppointment(slug) { 
        //Confirmed, awaiting fees payment
        if (confirm('Accept this appointment?')){
          this.$Progress.start();
          axios.patch('/appointments/'+ slug +'/accept')
          .then(()=> {
            this.status = '2';
            toast({
              type: 'success',
              title: 'Appointment accepted.'
            });
            this.$Progess.finish();
          })
        }
      },
      rejectAppointment(slug) { 
        // Rejected by doctor
        this.$Progress.start();
        axios.patch('/appointments/'+ slug +'/reject')
        .then(()=> {
          this.status = '3';
          toast({
            type: 'success',
            title: 'Appointment rejected.'
          });
          this.$Progess.finish();
        })
      },
      cancelAppointment(slug) { 
        // Cancelled by patient
        this.$Progress.start();
        axios.patch('/appointments/'+ slug +'/cancel')
        .then(()=> {
          this.status = '4';
          toast({
            type: 'success',
            title: 'Appointment cancelled.'
          });
          this.$Progess.finish();
        })
      },

      payConsultationFee(slug) { 
        // Fee paslug, awaiting appointment time.
        this.$Progress.start();
        axios.patch('/appointments/'+ slug +'/payfee')
        .then(()=> {
          this.status = '5';
          toast({
            type: 'success',
            title: '....'
          });
          this.$Progess.finish();
        })
      },
      appointmentDoctorRating(slug) {
        // Create a (new Review)
        // Update average rating for doctor directly in profile
        this.$Progress.start();
        axios.post('/reviews')
        .then(()=> {
          toast({
            type: 'success',
            title: 'Doctor rating submitted successfully.'
          });
          this.$Progess.finish();
        })
      },

    },

    // created() {
    //   this.loadAppointmentPage();
    //   Event.$on('RefreshPage', () => {
    //       this.loadAppointmentPage();
    //   });
    // }
  }
</script>