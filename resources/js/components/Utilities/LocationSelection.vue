<template>
  <div :class="setRowClass">
        <div :class="regionDiv">
            <label v-if="label" for="region_id" class="tf-flex">
                <small style="size:10px;">Region</small>
                <small title="required" class="red">**</small>
            </label>

            <select v-model="form.region_id" 
              name="region_id" 
              id="region_id" 
              class="form-control" 
              :class="{ 'is-invalid': form.errors.has('region_id') }" 
              :required="required"
              @change="loadCities(form.region_id), makeSearch"
              >

                <option value="">Select Region</option>
                <option 
                  v-for="(region, index) in regions" 
                  :key="region.id" 
                  :value="region.id" 
                  v-text="region.name"></option>
            </select>
        </div>

        <div :class="cityDiv">
            <label v-if="label" for="city_id" class="tf-flex">
                <small style="size:10px;">City</small>
                <small title="required" class="red">**</small>
            </label>

            <select v-model="form.city_id" 
              name="city_id" 
              id="city_id" 
              class="form-control" 
              :class="{ 'is-invalid': form.errors.has('city_id') }" 
              :required="required"
              @change="makeSearch"
              >
                <option value="">Select City</option>
                <option 
                  v-for="(city, index) in cities" 
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
      'regionDiv',  // .col-sm-6
      'cityDiv',    // .col-sm-6
      'label',      // true
      'required',
    ],

    data() {
      return {
        regions : {},
        cities  : {},
        countryId : 1, // Default = (App country locale || auth.user.country_id)
        // regionId  : 1, // Default = (Location region id (what if guest?))

        form: new Form({
          region_id : '',
          city_id   : '',
        })
      }
    },

    created() {
      this.loadRegions(this.countryId);
      // this.loadCities(regionId);
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