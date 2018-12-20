<template>
  <div>
    <form @submit.prevent="createAppointnment"><!-- action="{{ route('appointments.store') }}" method="post" -->
        
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
            <input v-model="form.doctor_id" type="hidden" name="doctor_id">
            <input v-model="form.day" type="text" name="day" maxlength="10" :min="this.getMoment().format('Y-M-D')"
               id="datepicker" :placeholder="this.getMoment().format('Y-M-D')" 
               pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" autocomplete="off" 
              class="form-control" :class="{ 'is-invalid': form.errors.has('day') }" 
              required>
            <has-error :form="form" field="day"></has-error>    
          </div>
        </div>
      </div> 

      <div class="form-group text-center">
        <div class="row">

          <div class="col-md-6">
            <label for="from">Start <small>(eg 11:30 or 11:30 AM)</small></label>
            <input v-model="form.from" type="time" name="from" 
              minlength="5" maxlength="5" min="00:00" max="23:59" 
              placeholder="hh:mm" pattern="[0-9]{2}:[0-9]{2}" 
              id="from" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }"
              required> 
            <has-error :form="form" field="from"></has-error>  
          </div>

          <div class="col-md-6">
            <label for="to">End <small>(eg 22:15 or 10:15 PM)</small></label>
            <input v-model="form.to" type="time" name="to" 
              minlength="5" maxlength="5" min="00:00" max="23:59" 
              placeholder="hh:mm" pattern="[0-9]{2}:[0-9]{2}" 
              id="to" class="form-control" :class="{ 'is-invalid': form.errors.has('to') }"
              required>
            <has-error :form="form" field="to"></has-error>                   
          </div>
        </div>
      </div> 

      <fieldset class="p-2 border-1" v-if="form.type == 'home'">
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

      <div class="form-group text-center">
        <textarea v-model="form.patient_info" name="patient_info" 
          id="patient_info" style="min-height: 120px;max-height: 150px;" 
          placeholder="description for booking this appointment" 
          class="form-control" :class="{ 'is-invalid': form.errors.has('patient_info') }" 
          required></textarea>
            <has-error :form="form" field="patient_info"></has-error> 
      </div> 

      <div class="form-group">
        <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-image"></i> Submit</button>
      </div>
    </form>
  </div>
</template>

<script>
  export default {
    props: ['doctor_id'],

    data() {
      return {
        form: new Form({
          id        : '',
          // user_id   : '',Model::boot()
          doctor_id : this.doctor_id,
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
    mounted() {
      console.log('Component mounted.')
    },
    // computed() {
    //   console.log('Component mounted.')
    // }
  }
</script>
