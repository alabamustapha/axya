<template>
  <div>
      <div class="card shadow">
        <div class="card-header">
          <div class="card-title" :title="appointment.description">
            <h5 class="border-bottom"><i class="fa fa-prescription"></i>&nbsp; Prescription for:</h5>
            <p style="font-size:12px;">{{ appointment.description }}</p>
          </div>
        </div>

        <div class="card-body p-2 p-sm-3">
          
          <form @submit.prevent="createPrescription()" id="prescription_form"><!-- {{route('prescriptions.store')}} -->

            <!-- <div class="form-group">
              <drug></drug>
            </div> -->
              
            <!-- Drug Form1 -->
            <div class="form-group">
              <div v-for="(drug, index) in drugs" :key="index">
                <div class="card p-2 p-sm-3 bg-light border-0">

                  <div class="card-header mb-1">
                    <span class="h5 text-center">
                      Drug {{index + 1}} : <span class="text-bold h5">{{drug.name}}</span>
                    </span>

                    <span class="card-tools">
                      <button title="Minimize entity" type="button" class="btn btn-tool pr-2" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                      </button>
                      <button title="Remove entity" type="button" class="btn btn-tool px-2" @click="removeDrugForm(index)"><!--  data-widget="remove" -->
                        <i class="fa fa-times red"></i>
                      </button>
                    </span>
                  </div>

                  <div class="card-body p-0">
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
              </div>

              <div class="">
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
                    <tbody v-for="(drug, index) in drugs" :key="index" :class="(index % 2) == 0 ? 'bg-light':'bg-dark'">
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
                  </table>
                  <div v-show="! drugs.length">
                    <span class="empty-list">0 drugs added</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- .\ Drug Form -->

            <hr>

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

            <button type="submit" class="btn btn-block btn-primary">Create Prescription</button>
          </form>

        </div>
      </div>
  </div>
</template>
<script>
  export default {
    props: ['appointment'],
    
    data() {
      return {
        drugs: [
          {
            name    : '',
            texture : '',
            dosage  : '',
            manufacturer: '',
            usage   : ''
          }
        ],
        appointment_id: this.appointment.id,
        general_usage : '',
        comment   : '',
      }
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
        this.drugs.splice(index, 1)
      },
      createPrescription() {
        this.$Progress.start();
        axios.post('/prescriptions', {
          appointment_id: this.appointment_id,
          usage   : this.general_usage,
          comment : this.comment,
          drugs   : this.drugs,
        })
        .then(() => {
          // Event.$emit('RefreshPage');
          this.$router.go(0); // Refreshes whole page!
          $('#newPrescriptionForm').modal('hide');
          toast({
              type: 'success',
              title: 'Prescription created successfully.'
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
