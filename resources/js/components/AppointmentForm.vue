<template>
  <div class="card card-primary text-center shadow"> <!-- card-outline -->
    <div class="card-header">
      <div class="card-title">
        <span>
          <i class="fa fa-tags"></i> 
          <span v-text="doctor.name"></span>
        </span>
        <br>

        <span style="font-size:14px;font-weight:bold;">
          <span>
            <i class="fa fa-user-md red"></i> 
            <span v-text="doctor.specialty.name"></span>
          </span>
          <br>

          <span class="badge badge-secondary badge-pill text-bold">
            $<span v-text="doctor.rate"></span> / hour
          </span>
        </span>
      </div>
    </div>

    <div class="card-body">
      <form @submit.prevent="createAppointment"><!-- action="{{ route('appointments.store') }}" method="post" -->

        <div class="form-group text-center">
          <textarea v-model="form.patient_info" name="patient_info" 
            id="patient_info" style="min-height: 120px;max-height: 150px;" 
            placeholder="description for booking this appointment" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('patient_info') }" 
            required></textarea>
              <has-error :form="form" field="patient_info"></has-error> 
        </div> 
          
        <div class="form-group text-center">
          <div class="row">

            <div class="col-md-6">
              <label for="type">Type</label>
              <select 
                v-model="form.type" name="type" 
                class="form-control" :class="{ 'is-invalid': form.errors.has('type') }" 
                required>
                <option value="">Appointment Type</option>
                <option value="Online">Online</option>
                <option value="Home">Home</option>
              </select>
              <has-error :form="form" field="type"></has-error>                   
            </div>

            <div class="col-md-6">
              <label for="day">Select Day <small>(yyyy-mm-dd)</small></label>
              <input v-model="form.day" 
                id="datepicker" 
                type="text" name="day" minlength="10" maxlength="15"
                placeholder="yyyy-mm-dd" autocomplete="off" 
                class="form-control" :class="{ 'is-invalid': form.errors.has('day') }" 
                required>
                <!-- :min="this.getMoment().format('Y-M-D')" :placeholder="this.getMoment().format('Y-M-D')"  -->
              <has-error :form="form" field="day"></has-error>    
            </div>
          </div>
        </div> 

        <!-- <div class="form-group text-center">
          <div class="row" id="timepicker">
            <div class="col-md-5">
              <input type="text" name="from" 
              minlength="5" maxlength="8" min="00:00" max="23:59" 
              value="{{old('from')}}" placeholder="HH:MM AM"
              id="from" class="time start form-control{{ $errors->has('from') ? ' is-invalid' : '' }}" 
              required>

            </div>

            <div class="col-xs-1 mx-auto p-0 m-0"> to </div>

            <div class="col-md-6">
              <input type="text" name="to"
              minlength="5" maxlength="8" min="00:00" max="23:59" 
              value="{{old('to')}}" placeholder="HH:MM AM"
              id="to" class="time end form-control{{ $errors->has('to') ? ' is-invalid' : '' }}" 
              required>

            </div>
          </div>
        </div> --> 

        <div class="form-group text-center">
          <div class="row" id="timepicker">
            <div class="col-md-5">
              <!-- <label for="from">Start <small>(eg 11:30 or 11:30 AM)</small></label> -->
              <input v-model="form.from" type="text" name="from" 
                minlength="5" maxlength="5" min="00:00" max="23:59" 
                placeholder="hh:mm am"
                id="from" class="time start form-control" :class="{ 'is-invalid': form.errors.has('type') }"
                required> 
              <has-error :form="form" field="from"></has-error>  
            </div>

            <div class="col-xs-1 mx-auto p-0 m-0"> to </div>

            <div class="col-md-6">
              <!-- <label for="to">End <small>(eg 22:15 or 10:15 PM)</small></label> -->
              <input v-model="form.to" type="text" name="to" 
                minlength="5" maxlength="5" min="00:00" max="23:59" 
                placeholder="hh:mm am"
                id="to" class="time end form-control" :class="{ 'is-invalid': form.errors.has('to') }"
                required>
              <has-error :form="form" field="to"></has-error>                   
            </div>
          </div>
        </div> 

        <fieldset class="p-2 border-1" v-if="form.type == 'Home'">
          <legend class="h5">Home Visitation</legend>

          <div class="form-group text-center">
            <label for="address">Address</label>
            <input v-model="form.address" type="text" name="address" 
              maxlength="255" placeholder="address for home visit" 
              id="address" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
              <has-error :form="form" field="address"></has-error> 
          </div>

          <div class="form-group text-center">
            <label for="phone">Phone Contact</label>
            <input v-model="form.phone" type="tel" name="phone" 
              maxlength="255" placeholder="phone for home visit" 
              id="phone" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
              <has-error :form="form" field="phone"></has-error> 
          </div>
        </fieldset>

        <div class="form-group">
          <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-image"></i> Submit</button>
        </div>
      </form>

    </div>

    <div class="card-footer">
      <span class="text-danger text-small"><b>Make sure your medical history is properly created in your profile.</b></span>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['doctor'],

    data() {
      return {
        form: new Form({
          id        : '',
          // user_id   : '',Model::boot()
          doctor_id : this.doctor.id,
          day       : '',
          from      : '',
          to        : '',
          patient_info: '',
          type      : '',
          address   : '',
          phone     : ''
        })
      }
    },

    methods: {
      createAppointment() {
        this.$Progress.start();
        this.form.post('/appointments')
        .then(() => {
          // Event.$emit('RefreshPage');
          // this.$router.go(0); // Refreshes whole page!
          $('#appointmentForm').modal('hide');
          toast({
              type: 'success',
              title: 'Appointment created successfully.'
          });
          this.$Progress.finish();            
        })
        .catch(() => {
          toast({
              type: 'fail',
              title: 'Something went wrong! Try again with correct details.'
          });
          this.$Progress.fail();
        });
      },
    },

  }
</script>
