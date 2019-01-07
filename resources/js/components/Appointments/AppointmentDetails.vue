<template>
  <div class="container">
    
    <div class="d-block m-auto text-center bg-white rounded">

      <div class="text-left shadow-lg p-3 mb-3" title="Appointment Description">
        <h5 title="appointment status" class="pb-2 border-bottom">Description</h5>
        
        <p class="text-small">{{appointment.description}}</p>
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
                ${{appointment.fee}}
              </span>
            </span>
          </li>
          <li class="tf-flex p-1">
            <button class="btn btn-primary btn-sm btn-block col" data-toggle="modal" data-target="#appointmentForm" title="Book Appointment"><i class="fa fa-edit"></i> Edit Appointment</button>
          </li>

          <hr>
          <li title="Appointment Status">
            <span class="h6">Status: </span>

            <span :class="appointmentStatusTextColor" class="text-bold">
              <i class="fa fa-info-circle pr-0 mr-0"></i>
              <span v-text="appointmentStatusText"></span>
            </span>
          </li>
        </ul>
      </div>

      <div class="card-footer">
        <ul class="list-unstyled">
          <span>
            <span v-if="appointment.attendant_doctor && status == '0'">
              <!-- <li class="border-bottom pb-1 mb-2">Doctor Section</li> -->
              <li>
                <button class="btn btn-sm my-1 btn-primary"
                  @click="acceptAppointment">
                  Accept Appointment
                </button>
              </li>
              <li class="mb-2">
                <button class="btn btn-sm my-1 btn-danger"
                  @click="rejectAppointment">Reject Appointment</button>
              </li>
            </span>

            <span v-if="appointment.creator">
              <!-- <li class="border-bottom pb-1 mb-2">Patient Section</li> -->
              <li v-if="status == '2'">
                <button class="btn btn-sm my-1 btn-primary"
                  @click="payConsultationFee">Pay Consultation Fee</button>
              </li>
              <li v-if="status == '0' && !appointment.schedule_is_past" class="mb-2">
                <button class="btn btn-sm my-1 btn-danger"
                  @click="cancelAppointment">Cancel Appointment</button>
              </li>  
            </span>
          </span>

          <span>
            <li v-if="status == '5' && appointment.schedule_is_past">
              <button class="btn btn-sm my-1 btn-secondary" 
                @click="appointmentCompleted">Appointment Completed?</button>
            </li>

            <li v-if="status == '1'">
              <span v-if="appointment.creator && reviewed == '0'">
                <button class="btn btn-sm my-1 btn-info mb-3"><i class="fa fa-star"></i> Rate This Doctor</button>
                <br>
                
                <!-- @include('doctors.partials.rating-form') -->
                <form @submit.prevent="createReview" 
                  class="mb-2 p-3 bg-dark d-block text-center" 
                  style="border-radius: 4px;">
                  <h5 class="border-bottom p-2">Rate This Service</h5>

                  <span class="d-inline-block mb-3">Star Rating: 
                    <br>
                    <small>(1 = lowest, highest = 5)</small>
                  </span>

                  <div class="table-responsive">
                    <small class="text-muted mb-2">
                      <span class="tf-flex text-center text-muted mb-3" :class="{ 'is-invalid': form.errors.has('rating') }">

                        <label class="px-2 mr-1 bg-light rating-pad" title="Very Unsatisfactory">
                          <input value="1" type="radio" v-model="form.rating" name="rating" id="rating-1" class="d-block" required>
                          <span class="fa fa-star text-primary p-0 m-0"></span>
                          <br> 1
                        </label>

                        <label class="px-2 mr-1 bg-light rating-pad" title="Unsatisfatory">
                          <input value="2" type="radio" v-model="form.rating" name="rating" id="rating-2" class="d-block" required>
                          <span class="fa fa-star text-primary p-0 m-0"></span>
                          <br> 2
                        </label>

                        <label class="px-2 mr-1 bg-light rating-pad" title="Just Ok">
                          <input value="3" type="radio" v-model="form.rating" name="rating" id="rating-3" class="d-block" required>
                          <span class="fa fa-star text-primary p-0 m-0"></span>
                          <br> 3
                        </label>

                        <label class="px-2 mr-1 bg-light rating-pad" title="Satisfactory">
                          <input value="4" type="radio" v-model="form.rating" name="rating" id="rating-4" class="d-block" required>
                          <span class="fa fa-star text-primary p-0 m-0"></span>
                          <br> 4
                        </label>

                        <label class="px-2 mr-0 bg-light rating-pad" title="Excellent! Very Satisfactory">
                          <input value="5" type="radio" v-model="form.rating" name="rating" id="rating-5" class="d-block" required>
                          <span class="fa fa-star text-primary p-0 m-0"></span>
                          <br> 5
                        </label>
                      </span>
                      <has-error :form="form" field="rating"></has-error> 
                    </small>
                  </div>

                  <textarea v-model="form.comment" name="comment" id="comment" 
                    style="min-height: 70px; max-height: 170px;" 
                    class="form-control form-control-sm mb-2" :class="{ 'is-invalid': form.errors.has('comment') }"
                    placeholder="write your comment"
                    required></textarea>
                  <has-error :form="form" field="comment"></has-error>

                  <button class="btn btn-sm my-1 btn-info">Submit Review</button>
                </form>
              </span>

              <span v-if="reviewed == '1'">                
                <h6 class="py-2 border-bottom border-top font-weight-bold">Appointment Review</h6>
              
                <span>
                  <span class="tf-flex">
                    <span v-text="appointment.user.name"></span><!--  v-text="review.author" -->

                    <button class="btn btn-link btn-sm" title="Update this review" v-if="$acl.isLoggedIn() && $acl.user.id == appointment.user.id">
                      <i class="fa fa-cog"></i>
                    </button>
                  </span>

                  <dfn class="text-muted" v-text="review.comment"></dfn> <br> 

                  <span class="tf-flex text-small" v-if="reviewed == '1'">
                    <span>
                        <span><i class="fa fa-star text-dark" v-for="i in rating"></i></span>

                        <span><i class="fa fa-star text-black-50" v-for="i in alt_rating"></i></span>

                        <!-- 
                          # A RangeError is nagging on these computed methods. Working 80% b4.
                          <span><i class="fa fa-star text-dark" v-for="i in compRating"></i></span>

                          <span><i class="fa fa-star text-black-50" v-for="i in altRating"></i></span
                        -->
                    </span>
                    <span v-text="review.created_at"></span>
                  </span>
                </span>
              </span>
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
        review    : this.appointment.review,
        rating    : this.appointment.rating,
        alt_rating: 5 - this.appointment.rating,
        reviewed    : this.appointment.reviewed,
        status      : this.appointment.status,

        form: new Form({
          id        : '',
          doctor_id : this.appointment.doctor_id,
          appointment_id: this.appointment.id,
          rating    : '',
          comment   : ''
        })
      }
    },

    computed: {
      // A RangeError is nagging on this computed methods. Working 80% b4.
      // compRating(){
      //   return (this.rating == 'undefined' || this.rating == NaN) 
      //       ? 0 
      //       : parseInt(this.form.rating);
      // },
      // altRating(){
      //   return (this.alt_rating == 'undefined' || this.alt_rating == NaN) 
      //       ? 5 
      //       : (5 - parseInt(this.form.rating));
      // },

      appointmentStatusText() {
        // switch (this.status){
          if (this.status == 0){ var statusText = 'Awaiting doctor\'s confirmation'; }
          if (this.status == 1){ var statusText = 'Success'; }
          if (this.status == 2){ var statusText = 'Appointment accepted by doctor. Awaits fee payment'; }
          if (this.status == 3){ var statusText = 'Rejected by doctor!'; }
          if (this.status == 4){ var statusText = 'Cancelled by patient!'; }          
          if (this.status == 5){ var statusText = 'Fee paid, awaiting appointment time.'; }
          if (this.status == 6){ var statusText = 'Schedule time elapsed! Patient absconded.'; }
          if (this.status == 7){ var statusText = 'Doctor did not confirm 1-hour to scheduled time.'; }
        // }
        return statusText;
      },
      appointmentStatusTextColor() {
        // switch (this.status){
          if (this.status == 0){ var statusColor = 'indigo'; }
          if (this.status == 1){ var statusColor = 'teal'; }
          if (this.status == 2){ var statusColor = 'orange'; }
          if (this.status == 3){ var statusColor = 'red'; }
          if (this.status == 4){ var statusColor = 'red'; }          
          if (this.status == 5){ var statusColor = 'orange'; }
          if (this.status == 6){ var statusColor = 'red'; }
          if (this.status == 7){ var statusColor = 'red'; }
        // }
        return statusColor;
      }
    },

    methods: {
      createReview() {
        this.$Progress.start();
        this.form.post('/reviews')
        .then(() => {
          this.review = this.form;
          this.reviewed = '1';

          this.rating = this.review.rating;
          this.alt_rating = (5 - this.rating);

          toast({type: 'success',title: 'Review submitted successfully.'});
          this.$Progress.finish();            
        })
        .catch(() => {
          toast({type: 'fail',title: 'Something went wrong! Try again later.'});
          this.$Progress.fail();
        });
      },

      appointmentCompleted() { 
        // Appointment/Consultation completed successfully.
        if (confirm('Is this appointment completed?')){
          this.$Progress.start();
          axios.patch('/appointments/'+ this.appointment.slug +'/complete')
          .then(()=> {
            this.status = '1';
            toast({ type: 'success', title: 'Appointment completed successfully.'});
            this.$Progress.finish();
          })
        }
      },
      
      acceptAppointment() { 
        //Confirmed, awaiting fees payment
        if (confirm('Accept this appointment?')){
          this.$Progress.start();
          axios.patch('/appointments/'+ this.appointment.slug +'/accept')
          .then(()=> {
            this.status = '2';
            toast({ type: 'success', title: 'Appointment accepted.'});
            this.$Progress.finish();
          })
        }
      },
      rejectAppointment() { 
        // Rejected by doctor
        this.$Progress.start();
        axios.patch('/appointments/'+ this.appointment.slug +'/reject')
        .then(()=> {
          this.status = '3';
          toast({ type: 'success', title: 'Appointment rejected.'});
          this.$Progress.finish();
        })
      },
      cancelAppointment() { 
        // Cancelled by patient
        this.$Progress.start();
        axios.patch('/appointments/'+ this.appointment.slug +'/cancel')
        .then(()=> {
          this.status = '4';
          toast({ type: 'success', title: 'Appointment cancelled.'});
          this.$Progress.finish();
        })
      },

      payConsultationFee() { 
        // Fee paslug, awaiting appointment time.
        this.$Progress.start();
        axios.patch('/appointments/'+ this.appointment.slug +'/payfee')
        .then(()=> {
          this.status = '5';
          toast({ type: 'success', title: 'Payment successful.'});
          this.$Progress.finish();
        })
      },

    },

    // created() {
    //   this.loadAppointmentMessages();
    //   Event.$on('RefreshPage', () => {
    //       this.loadAppointmentMessages();
    //   });
    // }
  }
</script>