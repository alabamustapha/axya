<template>
  <div>
    <div class="container">
      <button class="btn btn-success mt-5 mb-5">
        New Drug
      </button>
    </div>

    <div class="card card-primary card-outline shadow">
      <div class="card-header">
        <div class="card-title" title="{ {$appointment->patient_info}}">
          <h5 class="border-bottom"><i class="fa fa-prescription"></i>&nbsp; Prescription for:</h5>
          <p style="font-size:11px;">{ {substr($appointment->patient_info, 0, 150)}}</p>
        </div>
      </div>

      <div class="card-body">

          <div class="form-group border"><!-- 
            <div class="table-responsive tp-scrollbar">
              <table class="table table-sm">
                <tr>
                  <td>Name</td>
                  <td>Texture</td>
                  <td>Dosage</td>
                  <td>Usage</td>
                  <td>Manufacturer</td>
                </tr>
                <tr>
                  <td>Chloroquine{{--$drug->name--}}</td>
                  <td>tablet</td>
                  <td>200mg{{--$drug->dosage--}}</td>
                  <td>2-2-2{{--$drug->usage--}}</td>
                  <td>Emzor</td>
                </tr>
                <tr>
                  <td>Piritin</td>
                  <td>syrup</td>
                  <td>1tp (15ml)</td>
                  <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic a ex unde laudantium? Animi eum sapiente adipisci, voluptas optio quia eligendi quam, ea dignissimos consectetur ipsa aut earum maiores vel.</td>
                  <td>Drugfield</td>
                </tr>
                <tr>
                  <td>Aspirin</td>
                  <td>capsule</td>
                  <td>20mg</td>
                  <td>1-0-1</td>
                  <td>May and Baker</td>
                </tr>
                <tr>
                  <td>Astimycin</td>
                  <td>capsule</td>
                  <td>10mg</td>
                  <td>1-0-0</td>
                  <td></td>
                </tr>
              </table>                    
            </div> -->
          </div>

      </div>
    </div>
  </div>
</template>
<script>
  export default {
    data() {
      return {
        drugs: [
          {
            name: '',
            texture: '',
            dosage: '',
            usage: '',
            manufacturer: ''
          }
        ],
      }
    },
  }
</script>
