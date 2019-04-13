<template>
  <div v-if="allow">
    <h5 class="py-2 mb-0 rounded text-center bg-dark">
      <span v-if="status == 0">
          <span class="text-light text-bold h5"><i class="fa fa-user-md"></i>&nbsp; You Registered As a Doctor.</span>

          <br> 

          <small class="text-sm">

              <span class="d-inline-block p-2 border border-success rounded">
                Submit verification documents 
                <a class="btn btn-success btn-sm" 
                  :href="registerUrl"> <i class="fa fa-user-check">&nbsp; </i>HERE 
                </a>
              </span>
              <span class="d-inline-block p-2 border border-danger rounded">
                Not a doctor? 
                <button class="btn btn-danger btn-sm" title="Not a doctor?"
                  @click="disallowDoctorVerify">
                  <i class="fa fa-times"></i>&nbsp; Close Reminder
                </button>
              </span>

          </small>
      </span>

      <span v-if="status == 1">
          <span class="teal text-bold"><i class="fa fa-info-circle"></i>&nbsp; Notifications</span>

          <hr> 

          <small class="text-sm">
            Notifications and updates on professional stuffs.
            <br>
            <small class="red"><em>You may recieve appiontment from patients now.</em></small>
            <br>
            <small class="red"><em>You must be <b>subscribed</b> to appear in search results.</em></small>
          </small>
      </span>

      <span v-if="status == 2">
          <span class="green text-bold"><i class="fa fa-info-circle"></i>&nbsp; Application Accepted</span>

          <hr>

          <small class="text-sm">
            Your information has been <b>verified</b>, your application is <b>accepted</b> 
            <br>
            You can now attend to patients and receive appointments on this platform after subscription.
            <button class="btn btn-primary btn-sm" 
              data-toggle="modal" data-target="#newSubscriptionForm" 
              title="New Subscription">Subscribe Now</button>.
          </small>
      </span>

      <span v-if="status == 3">
          <span class="orange text-bold"><i class="fa fa-info-circle"></i>&nbsp; Ongoing Verification</span>

          <hr>

          <small class="text-sm">
            Your application as a <b>&nbsp;<i class="fa fa-user-md"></i>&nbsp; Medical Doctor</b> is being reviewed...
            <br>
            Wait for your documents verification and eventual administrator\'s decision (approval/rejection).
          </small>                
      </span>

      <span v-if="status == 4">
          <span class="teal text-bold"><i class="fa fa-info-circle"></i>&nbsp; Application Received!</span>

          <hr>

          <small class="text-sm">
            We have received your application as a <b>&nbsp;<i class="fa fa-user-md"></i>&nbsp; Medical Doctor</b> on this platform. Your details will be reviewed within 48hours. 
            <br>
            Keep checking this section for updates on your application status.
          </small>
      </span>

      <span v-if="status == 5">
          <span class="red text-bold"><i class="fa fa-info-circle red"></i>&nbsp; Application Rejected!</span>

          <hr>

          <small class="text-sm">
            <b>We cannot accept your application as a medical doctor</b> on our platform at this time. 
            <br>
            Kindly update your documents and reapply later.
          </small>
      </span>
    </h5>
  </div>
</template>

<script>
  export default { 
    props: ['status','docNotify'],

    data() {
      return {
        allow : this.docNotify,
        registerUrl : appUrl +'/doctors/create',
      }
    },

    methods: {
      disallowDoctorVerify() {
        if (confirm('You really want to close this reminder? \n\n It will be hidden forever.')){
            this.$Progress.start();

            axios.post(appUrl + '/doctor-verify')
            .then(() => { 
              this.allow = 0;
              this.docNotify = 0;

              toast({
                  type: 'success',
                  title: 'Notification hidden.'
              });
              this.$Progress.finish();  
            })
            .catch(()=>{ /*...*/ })
        }
      },
    }
  }
</script>