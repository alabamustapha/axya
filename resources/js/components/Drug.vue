<template>
  <div class="form-group">
    <div class="card p-2 p-sm-3 bg-light border-0">
      <div class="card-header mb-2">
        <span class="h5 text-center">
          New Drug
        </span>

        <span class="card-tools">
          <button type="button" class="btn btn-tool" data-widget="collapse">
            <i class="fa fa-minus"></i>
          </button>
        </span>
      </div>
      
      <div class="card-body p-0 m-0">
        <form @submit.prevent="editmode ? updateUser() : createUser()">
          <div class="form-group mb-1">
            <div class="row">
              <div class="col-sm-6">
                <label class="pb-0 mb-0" for="name">Name</label> <br>
                <input v-model="form.name" type="text" name="name"
                    placeholder="Name"
                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('name') }">
                <has-error :form="form" field="name"></has-error>              
              </div>
              <div class="col-sm-6">
                <label class="pb-0 mb-0" for="texture">Drug Texture</label> <br>
                <select v-model="form.texture" name="texture" id="texture" class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('texture') }">
                  <option value="">Choose one</option>
                  <option value="tablet">Tablet</option>
                  <option value="syrup">Liquid</option>
                  <option value="capsule">Capsule</option>
                  <option value="caplet">Caplet</option>
                  <option value="powder">Powder</option>
                  <option value="chewable">Chewable</option>
                  <option value="any">Any type</option>
                  <option value="others">Others</option>
                </select>
                <has-error :form="form" field="texture"></has-error>
              </div>
            </div>
          </div>
      
          <div class="form-group mb-1">
            <div class="row">
              <div class="col-sm-6">
                <label class="pb-0 mb-0" for="dosage">Dosage</label> <br>
                <input v-model="form.dosage" type="dosage" name="dosage"
                    placeholder="dosage eg 2-2-2/50mg etc"
                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('dosage') }">
                <has-error :form="form" field="dosage"></has-error>
              </div>
          
              <div class="col-sm-6">
                <label class="pb-0 mb-0" for="manufacturer">Brand</label> <br>
                <input v-model="form.manufacturer" type="manufacturer" name="manufacturer"
                    placeholder="drug brand/manufacturer"
                    class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('manufacturer') }">
                <has-error :form="form" field="manufacturer"></has-error>
              </div>
            </div>
          </div>
      
          <div class="form-group mb-1">
            <label class="pb-0 mb-0" for="usage">Usage</label> <br>
            <textarea v-model="form.usage" name="usage"
                placeholder="Short description on how to use"
                style="min-height:100px;max-height:180px;" 
                class="form-control form-control-sm" :class="{ 'is-invalid': form.errors.has('usage') }"></textarea>
            <has-error :form="form" field="usage"></has-error>
          </div>

          <div>
           <!--  <button v-show="editmode" type="submit" class="btn btn-primary">Update</button>
            <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button> -->
          </div>
        </form>
      </div>

      <hr>

      <button class="btn btn-dark btn-sm">
        <i class="fa fa-plus"></i>&nbsp; Add New
      </button>
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
