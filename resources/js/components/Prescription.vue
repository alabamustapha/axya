<template>
  <div>
      <div class="card shadow">
        <div class="card-header">
          <div class="card-title" title="{ {$appointment->patient_info}}">
            <h5 class="border-bottom"><i class="fa fa-prescription"></i>&nbsp; Prescription for:</h5>
            <p style="font-size:11px;">{ {substr($appointment->patient_info, 0, 150)}}</p>
          </div>
        </div>

        <div class="card-body p-2 p-sm-3">
          
          <form action="#" method="post"><!-- {{route('prescriptions.store')}} -->

            <div class="form-group">

              <drug></drug>

            </div>

            <hr>

            <div class="form-group">
              <label for="usage">Explain How To Use</label>
              <textarea v-model="form.usage" name="usage"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('usage') }" 
                  style="min-height: 100px;max-height: 150px;" 
                  placeholder="explain how to use the medications" 
                  required></textarea>
              <has-error :form="form" field="usage"></has-error>
            </div>

            <div class="form-group">
              <label for="comment">More comments on this prescription</label>
              <textarea v-model="form.comment" name="comment"
                  class="form-control" :class="{ 'is-invalid': form.errors.has('comment') }" 
                  style="min-height: 100px;max-height: 150px;" 
                  placeholder="more comments on this prescription" 
                  required></textarea>
              <has-error :form="form" field="comment"></has-error>
            </div>

            <button type="submit" class="btn btn-block btn-primary">Create Prescription</button>
          </form>

        </div>
      </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        form: new Form({
            id: '',
            name: '',
            texture: '',
            dosage: '',
            manufacturer: '',
            usage: ''
        }),
        // prescription: {
        //   usage: '',
        //   comment: '',
        // },
        // drugs: [
        //   {
        //     name: '',
        //     texture: '',
        //     dosage: '',
        //     manufacturer: '',
        //     usage: ''
        //   }
        // ],
      }
    },
  }
</script>
