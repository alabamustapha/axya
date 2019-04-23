<template>
  <div :class="setRowClass">
        <div :class="regionDiv">
            <label for="region_id"
              v-if="label"                
              class="tf-flex"
              :class="labelStyle"
              >
                <small style="size:10px;">Region</small>
                <small title="required" class="red">**</small>
            </label>

            <select v-model="form.region_id" 
              name="region_id" 
              id="region_id" 
              class="form-control form-default" 
              :class="{ 'is-invalid': form.errors.has('region_id') }" 
              :required="required"
              @change="loadCities(form.region_id), makeSearch"
              >

                <option value="">Select Region</option>
                <option 
                  v-for="region in regions" 
                  :key="region.id" 
                  :value="region.id" 
                  v-text="region.name"></option>
            </select>
        </div>

        <div :class="cityDiv">
            <label for="city_id" 
              v-if="label" 
              class="tf-flex"
              :class="labelStyle"
              >
                <small style="size:10px;">City</small>
                <small title="required" class="red">**</small>
            </label>

            <select v-model="form.city_id" 
              name="city_id" 
              id="city_id" 
              class="form-control form-default" 
              :class="{ 'is-invalid': form.errors.has('city_id') }" 
              :required="required"
              @change="makeSearch"
              >
                <option value="">Select City</option>
                <option 
                  v-for="city in cities" 
                  :key="city.id" 
                  :value="city.id" 
                  v-text="city.name"></option>
            </select>               
        </div>
  </div>
</template>

<script>
  export default { 
    props: [
      'setRowClass',// .row
      'labelStyle', // ...
      'inputStyle', // .form-default
      'regionDiv',  // .col-sm-6
      'cityDiv',    // .col-sm-6
      'label',      // true
      'required',
      'regionId',
      'cityId',
    ],

    data() {
      return {
        regions : {},
        cities  : {},
        countryId : 1, // Default = (App country locale || auth.user.country_id)
        // regionId  : 1, // Default = (Location region id (what if guest?))

        form: new Form({
          region_id : this.regionId,
          city_id   : this.cityId,
        })
      }
    },

    created() {
      this.loadRegions(this.countryId);
      this.loadCities(this.regionId);
    },

    methods: {
      loadRegions(countryId) {
          this.countryId = countryId ? countryId : this.countryId;

          this.form.get(appUrl + '/searches/load-regions/' + countryId)
          .then(({data}) => (this.regions = data))
          .then(() => { this.$Progress.finish(); })
          .catch(()=> { /*...*/ })
      },

      loadCities(regionId) {
          this.$Progress.start();

          this.form.get(appUrl + '/searches/load-cities/' + regionId)
          .then(({data}) => (this.cities = data))
          .then(() => { this.$Progress.finish(); })
          .catch(()=> { /*...*/ })
      },

      makeSearch() {
          console.log('Search thru...Region: ' + this.form.region_id + ' :City ' + this.form.city_id);
      },
    }
  }
</script>