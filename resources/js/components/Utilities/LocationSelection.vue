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
              class="form-control form-default d-inline-block w-100" 
              :class="[{ 'is-invalid': form.errors.has('region_id')}, regionInputStyle ]" 
              :required="required"
              @change="loadCities(form.region_id)"
              >

                <option value="-1" v-text="computedRegionSelectText"></option>
                <!-- 
                  value="-1" is very important to clear region field value when appropriate.
                  DO NOT CHANGE unless you have created a better hack.
                 -->
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
              class="form-control form-default d-inline-block w-100" 
              :class="[{ 'is-invalid': form.errors.has('city_id')}, cityInputStyle ]" 
              :required="required"
              @change="makeSearch"
              >
                <option value="" v-text="computedCitySelectText"></option>
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
      'setRowClass',      // .row
      'labelStyle',       // ...
      'regionInputStyle', // .form-default
      'cityInputStyle',   // .form-default
      'regionDiv',        // .col-sm-6|.col-6
      'cityDiv',          // .col-sm-6|.col-6
      'label',            // true|false
      'required',
      'regionId',
      'cityId',
      'isSearchForm',     // true|false
      'regionSelectText', // Search By/Select Region
      'citySelectText',   // Search By/Select City
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

    computed: {
      computedCountryId() {
        return this.countryId ? this.countryId : '';
      },
      computedRegionId() {
        return this.regionId ? this.regionId : this.form.region_id;
      },
      computedCityId() {
        // return this.cityId ? this.cityId : '';
        return this.cityId ? this.cityId : this.form.city_id;
      },
      computedRegionSelectText() {
        return this.regionSelectText ? this.regionSelectText : 'Select Region';
      },
      computedCitySelectText() {
        return this.citySelectText ? this.citySelectText : 'Select City';
      },
    },

    created() {
      // // Computed properties not necessary when initializing.
      // this.loadRegions(this.countryId);
      // this.loadCities(this.regionId);
      // this.form.region_id = this.regionId ? this.regionId : '';
      // this.form.city_id   = this.cityId ? this.cityId : '';
      
      this.loadRegions(this.computedCountryId);
      this.loadCities(this.computedRegionId);
      this.form.region_id = this.computedRegionId == undefined ? '-1' : this.computedRegionId;
      this.form.city_id   = this.computedCityId;
    },

    methods: {
      loadRegions(countryId) {
          // this.countryId = countryId ? countryId : this.countryId;
          this.countryId = countryId ? countryId : this.computedCountryId;

          this.form.get(appUrl + '/searches/load-regions/' + countryId)
          .then(({data}) => (this.regions = data))
          .then(() => { this.$Progress.finish(); })
          .catch(()=> { /*...*/ })
      },

      loadCities(regionId) {
          this.$Progress.start();
          this.form.city_id = ''; // Clear loaded cities for a fresh loading.

          this.form.get(appUrl + '/searches/load-cities/' + regionId)
          .then(({data}) => (this.cities = data))
          .then(() => { 
            this.makeSearch();

            this.$Progress.finish(); 
          })
          .catch(()=> { /*...*/ })
      },

      makeSearch() {
        if (this.isSearchForm) {
          let qRegionId = this.form.region_id;
          let qCityId   = this.form.city_id;

          Event.$emit('search_by_location', qRegionId, qCityId);
          console.log('[Region: ' + this.form.region_id + ' ++ City: ' + this.form.city_id + ']');
        } else {
          console.log('Not a search form');
        }
      },
    }
  }
</script>