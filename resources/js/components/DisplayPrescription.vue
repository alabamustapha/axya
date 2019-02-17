<template>
  <div>
    <div class="card shadow">
      <div class="card-header">
        <div class="card-title">
          <div style="font-size:12px;">
            <div class="pb-2 tf-flex border-bottom">
              <span class="text-bold" :title="appointment.description">
                <i class="fa fa-info-circle"></i> Description: 
              </span>

              <span v-if="this.appointment.attendant_doctor">
                <button class="btn btn-sm btn-warning" title="Cancel Edit" v-if="editing == true" @click="editing = false">
                    <i class="fa fa-times"></i> Cancel Edit
                </button>
                <button class="btn btn-sm btn-info" title="Edit Prescription" v-else @click="editing = true">
                    <i class="fa fa-edit"></i> Edit
                </button>
              </span>
            </div>

            <div>
              <i class="fa fa-user-md"></i> Doctor: 

              <a :href="prescription.doctor.link" target="_blank" style="color:#6c757d !important;">
                {{ prescription.doctor.name }}
              </a>
            </div>
          </div>
        </div>
      </div>

      <div v-if="editing == true">
        <div class="card-body p-2 p-sm-3">

          <!-- Edit form -->
          <form class="mb-3" @submit.prevent="updatePrescription(prescription.id)" id="prescription_update_form"><!-- {{route('prescriptions.update')}} -->
            <div v-for="(drug, index) in drugs" :key="drug.id">
              <div class="card bg-light border-0">

                <div class="card-header mb-1">
                  <span class="text-center">
                    Drug {{index + 1}} : <span class="text-bold">{{drug.name}}</span>
                  </span>

                  <span class="card-tools">
                    <button title="Minimize entity" type="button" class="btn btn-tool pr-2" data-widget="collapse">
                      <i class="fa fa-minus indigo"></i>
                    </button>
                    <button v-if="drugs.length > 1" title="Remove entity" type="button" class="btn btn-tool px-2" @click="removeDrugForm(index)"><!--  data-widget="remove" -->
                      <i class="fa fa-times red"></i>
                    </button>
                  </span>
                </div>

                <div class="card-body p-1 p-sm-2">
                  <div class="form-group mb-1">
                    <div class="row">
                      <div class="col-sm-6">
                        <label class="tf-flex pb-0 mb-0" for="name">
                          <span>Name </span>
                          <small class="red">* req.</small>
                        </label>
                        <input v-model="drug.name" type="text" name="name"
                            placeholder="Name"
                            class="form-control form-control-sm"
                            required>
                      </div>
                      <div class="col-sm-6">
                        <label class="pb-0 mb-0" for="texture">Texture</label> <br>
                        <select v-model="drug.texture" name="texture" id="texture" class="form-control form-control-sm">
                          <option value="">Choose one</option>
                          <option value="tablet">Tablet</option>
                          <option value="liquid">Liquid</option>
                          <option value="capsule">Capsule</option>
                          <option value="caplet">Caplet</option>
                          <option value="powder">Powder</option>
                          <option value="chewable">Chewable</option>
                          <option value="others">Others</option>
                        </select>
                      </div>
                    </div>
                  </div>
              
                  <div class="form-group mb-1">
                    <div class="row">
                      <div class="col-sm-6">
                        <label class="tf-flex pb-0 mb-0" for="dosage">
                          <span>Dosage</span>
                          <small class="red">* req.</small>
                        </label>
                        <input v-model="drug.dosage" type="text" name="dosage"
                            placeholder="dosage eg 2-2-2/50mg etc"
                            class="form-control form-control-sm"
                            required>
                      </div>
                  
                      <div class="col-sm-6">
                        <label class="pb-0 mb-0" for="manufacturer">Brand</label> <br>
                        <input v-model="drug.manufacturer" type="text" name="manufacturer"
                            placeholder="brand/manufacturer"
                            class="form-control form-control-sm">
                      </div>
                    </div>
                  </div>
              
                  <div class="form-group mb-1">
                    <label class="tf-flex pb-0 mb-0" for="usage">
                      <span>Usage</span> 
                      <small class="red">* req.</small>
                    </label>
                    <textarea v-model="drug.usage" name="usage"
                        placeholder="Short description on how to use"
                        style="min-height:60px;max-height:180px;" 
                        class="form-control form-control-sm"
                        required></textarea>
                  </div>
                </div>
              </div>
              <!-- .\ Drug Form -->
            </div>

            <!-- Content Display Section -->
            <div class="display-section">
              <span class="btn btn-dark btn-sm mb-3" @click="addNewDrugForm">
                <i class="fa fa-plus"></i>&nbsp; Add New
              </span>

              <div class="table-responsive mb-3" v-if="drugs">
                <table class="table table-sm">
                  <tr>
                    <td>#</td>
                    <td>Name</td>
                    <td>Texture</td>
                    <td>Dosage</td>
                    <td>Manufacturer</td>                      
                  </tr>
                  <tbody v-for="(drug, index) in drugs" :key="drug.id" :class="(index % 2) == 0 ? 'bg-light':'bg-dark'">
                    <tr>
                      <td rowspan="2">{{ index + 1 }}</td>
                      <td>{{ drug.name }}</td>
                      <td>{{ drug.texture }}</td>
                      <td>{{ drug.dosage }}</td>
                      <td>{{ drug.manufacturer }}</td>
                    </tr>
                    <tr>
                      <td colspan="4">
                        <span class="text-bold">Usage</span>
                        {{ drug.usage }}
                      </td>
                    </tr>
                  </tbody>
                  <tbody v-show="! drugs.length">
                    <tr>
                      <td colspan="5" class="empty-list">0 drugs added</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- ./Content Display Form -->

            <hr>

            <div>
              <div class="form-group">
                <label class="tf-flex" for="usage">
                  <span>How to combine all prescribed drugs?</span> 
                  <small class="red">* req.</small>
                </label>
                <textarea v-model="general_usage" name="usage"
                    class="form-control" 
                    style="min-height: 100px;max-height: 150px;" 
                    placeholder="explain how to use the medications" 
                    required></textarea>
              </div>

              <div class="form-group">
                <label for="comment">Other comments on this prescription</label>
                <textarea v-model="comment" name="comment"
                    class="form-control"
                    style="min-height: 100px;max-height: 150px;" 
                    placeholder="more comments on this prescription"></textarea>
              </div>
            </div>

            <button type="submit" class="btn btn-lg btn-block btn-primary">Update Prescription</button>
          </form>
          <!-- ./Edit form -->
        </div>
      </div>

      <div v-else>
        <div class="card-body p-2 p-sm-3 py-sm-1">          
          <h5 class="text-bold">Drugs:</h5>

          <div class="table-responsive pb-1">
            <table class="table table-sm table-bordered">
              <tr>
                <td>#</td>
                <td>Name</td>
                <td>Texture</td>
                <td>Dosage</td>
                <td>Manufacturer</td>
              </tr>

              <tbody v-for="(drug, index) in drugs" :key="drug.id" :class="(index % 2) == 0 ? 'bg-light':'bg-dark'">
                <tr>
                  <td rowspan="2">{{ index + 1 }}</td>
                  <td>{{ drug.name }}</td>
                  <td>{{ drug.texture }}</td>
                  <td>{{ drug.dosage }}</td>
                  <td>{{ drug.manufacturer }}</td>
                </tr>
                <tr>
                  <td colspan="4">
                    <span class="text-bold">Usage:&nbsp;</span>
                    {{ drug.usage }}
                  </td>
                </tr>
              </tbody>
            </table>                    
          </div>
        </div>

        <div class="card-footer">
          <div class="mb-3">
            <strong class="border-bottom">Usage Information:&nbsp;</strong>
            <br>
            <span v-text="general_usage"></span><!-- {{prescription.usage}} -->
          </div>
          
          <div v-if="prescription.comment">
            <strong class="border-bottom">Comment:&nbsp;</strong>
            <br>
            <span v-text="comment"></span><!-- {{prescription.comment}} -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
  export default {
    props: [ 'prescription','appointment' ],

    data() {
      return {
        editing: false,
        // Prescription
        appointment_id: this.appointment.id,
        general_usage : this.prescription.usage,
        comment : this.prescription.comment,
        drugs   : this.prescription.drugs,
      };
    },

    methods: {
      addNewDrugForm () {
        this.drugs.push({
          name    : '',
          texture : '',
          dosage  : '',
          manufacturer: '',
          usage   : ''
        })
      },
      removeDrugForm(index) {
        if (confirm('You really want to remove this section?')){
          this.drugs.splice(index, 1)
        }
      },
      updatePrescription(id) {
        this.$Progress.start();
        axios.patch('/prescriptions/'+ id, {
          appointment_id: this.appointment_id,
          usage   : this.general_usage,
          comment : this.comment,
          drugs   : this.drugs,
        })
        .then(() => {
          // Event.$emit('RefreshPage');
          // this.$router.go(0); // Refreshes whole page!
          this.editing = false;
          toast({
              type: 'success',
              title: 'Prescription updated successfully.'
          });
          this.$Progress.finish();            
        })
        .catch(() => {
          toast({
              type: 'error',
              title: 'Something went wrong! Try again with correct details.'
          });
          this.$Progress.fail();
        });
      },
    }

  }
</script>
