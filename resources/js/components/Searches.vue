<template>

  <div class="modal fade bg-theme-blue" style="color:inherit;" role="dialog" id="sitewideSearchContent" aria-labelledby="sitewideSearchContentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">

        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
          <span aria-hidden="true">&times;</span>
        </button>

        <br>
        <div class="modal-body">

                <!-- @keyup="this.$parent.searchForQuery" -->
          <form @submit.prevent="$parent.searchForQuery" class="form-inline">
              <!-- <div class="form-group"> -->
                <input
                  v-model="search"
                  type="search"
                  name="query" id="query"
                  aria-label="Search" 
                  placeholder="search doctor, city, illness, specialty..."
                  class="form-control w-100 input-lg border-0 rounded search-form bg-dark text-white text-center p-4"
                  autocomplete="off"
                  minlength="3"
                  required
                >
              <!-- </div> -->
              <div class="container w-100 d-block">
                <location-selection
                            :set-row-class="'row'"
                            :region-div="'col-6'"
                            :city-div="'col-6'"
                            :required="false"
                            :is-search-form="true"
                            :region-select-text="'Search By Region'"
                            :city-select-text="'Search By City'"
                ></location-selection>
                <!-- :required="true"
                  :label="true" -->
              </div>
             
             <br>
             <button @click="$parent.searchForQuery" type="button" class="btn btn-block bg-theme-blue">
                  <i class="fa fa-search "></i>
                  <!-- -->
              </button>
           
          </form>
          <div class="text-center">
            <h1>
              <small class="text-sm">Search results for</small> <em class="text-warning">{{this.query}}</em></h1>            
          </div>


          <div class="result">

            <div class="result-nav px-3 ">
              <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="doctor-tab" data-toggle="tab" href="#doctor" role="tab" aria-controls="doctor" aria-selected="true">
                    Doctors (<span v-text="doctorsCount"></span>)
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="tag-tab" data-toggle="tab" href="#tag" role="tab" aria-controls="tag" aria-selected="false">
                    Keyword/Tag (<span v-text="tagsCount"></span>)
                  </a>
                </li>
              </ul>
            </div>

            <div class="result-body">
              <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="doctor" role="tabpanel" aria-labelledby="doctor-tab">

                  <div v-if="doctors.data != undefined && doctorsCount">
                    <div class="d-r result-row" v-for="doctor in doctors.data" :key="doctor.id">
                      <div class="img-side">
                        <a :href="doctor.link" :title="doctor.name +' - '+ doctor.specialty.name" style="color:inherit;">
                          <img :src="doctor.avatar" class="img-fluid rounded-circle" alt="">
                        </a>
                      </div>
                      <div class="info-side">
                        <div class="doc">
                          <div class="d-block">
                            <a class="d-inline-block" :href="doctor.link" :title="doctor.name +' - '+ doctor.specialty.name" style="color:inherit;">
                              <span class="d-block h2" v-text="doctor.name"></span>
                            </a>
                          </div>

                          <span class="d-block occupation text-muted" v-text="doctor.location"></span>

                          <a :href="doctor.specialty.link" :title="doctor.specialty.name" style="color:inherit;">
                            <span class="occupation" v-text="doctor.specialty.name"></span>
                          </a>
                        </div>
                        <small class="ratings text-review review-star text-sm">
                          <a :href="doctor.link +'#reviews'" :title="doctor.name +' - '+ doctor.specialty.name" style="color:inherit;">
                            <i class="fas fa-star" v-for="i in doctor.rating_digit"></i>
                          </a>
                        </small>
                      </div>
                    </div>
                  </div>

                  <div v-else>
                    <div class="text-center" v-show="!loading">
                      <div class="display-3"><i class="fa fa-user-md"></i></div> 

                      <br>

                      <p><strong>0</strong> results for <b>{{this.query}}</b> in <em class="text-bold">doctors</em>.</p>
                    </div>
                  </div>

                  <div class="text-center" v-show="loading">
                    <span class="d-inline-block">
                      Searching doctors <i class="fa fa-user-md"></i> for <b>{{this.query}}</b>...
                    </span>
                    <span class="d-inline-block fa-fw h5">
                      <i class="fas fa-sync fa-spin"></i>
                    </span>
                  </div>

                  <div class="card-footer text-center mb-0 pb-1 px-2">
                    <div class="table-responsive tp-scrollbar m-0">
                      <div style="flex-flow: nowrap;">
                        <pagination :data="doctors" @pagination-change-page="doctorsPagination"></pagination>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane fade" id="tag" role="tabpanel" aria-labelledby="tag-tab">
                  <div v-if="tags.data != undefined && tagsCount">
                    <div class="result-row" v-for="tag in tags.data" :key="tag.id">
                      <span class="tag">
                        <a :href="tag.link" :title="tag.name +' - '+ tag.specialty.name" v-text="tag.name"></a>
                      </span>
                      &nbsp;-&nbsp; 
                      <span v-text="tag.description_preview"></span>                         
                    </div>
                  </div>

                  <div v-else>
                    <div class="text-center" v-show="!loading">
                      <div class="display-3"><i class="fa fa-tags"></i></div> 

                      <br>

                      <p><strong>0</strong> results for <b>{{this.query}}</b> in <em class="text-bold">tags</em>.</p>
                    </div>
                  </div>

                  <div class="text-center" v-show="loading">
                    <span class="d-inline-block">
                      Searching keywords <i class="fa fa-tags"></i> for <b>{{this.query}}</b>...
                    </span>
                    <span class="d-inline-block fa-fw h5">
                      <i class="fas fa-sync fa-spin"></i>
                    </span>
                  </div>

                  <div class="card-footer text-center mb-0 pb-1 px-2">
                    <div class="table-responsive tp-scrollbar m-0">
                      <div style="flex-flow: nowrap;">
                        <pagination :data="tags" @pagination-change-page="tagsPagination"></pagination>
                      </div>
                    </div>
                  </div>
                </div>
                  
              </div>
            </div>
          </div>


        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
  </div><!-- modal -->

</template>

<script>
  export default {
    data() {
      return {
        regionId : '',
        cityId   : '',
        loading : true,
        // searches: {},
        doctors : {},
        tags    : {},
        // users   : {},
        search  : '',
        query   : '',
        doctorSearchUrl : appUrl +'/searches/doctors',
        tagSearchUrl    : appUrl +'/searches/tags?q=',
        doctorsCount    : 0,
        tagsCount       : 0,
      }
    },

    computed: {
      // a computed getter
      computedQuery: function () {
        // $parent needed to access the root instance at ...resources\js\app.js
        return (this.search.length) 
              ? this.search : this.$parent.search
              ;
      },

    },

    methods: {

      /** ~~~~ MAKE NEW SEARCHES ~~~~*/
      /*******************************/
      searchDoctors() {
        this.query = this.computedQuery;
        // Event.$emit('search_by_location', this.regionId, this.cityId);

        axios.get(this.doctorSearchUrl, {
          params: {
            q        : this.query,
            regionId : this.regionId,
            cityId   : this.cityId,
          }
        })
        .then(({data}) => (this.doctors = data))
        .then(() => { 
          this.loading = false; 
          this.doctorsCount = this.doctors.data.length;
        })
        .catch(()=>{ /*...*/ })
      },

      searchTags() {
        this.query = this.computedQuery;

        axios.get(this.tagSearchUrl + this.query)
        .then(({data}) => (this.tags = data))
        .then(() => { 
          this.tagsCount = this.tags.data.length;
        })
      },

      // searchUsers() {
      //   this.query = this.computedQuery;
      //   const this.userSearchUrl = appUrl +'/searches/users?q=';

      //   axios.get(this.userSearchUrl + this.query)
      //   .then(({data}) => (this.users = data))
      //   .then(() => { this.loading = false; })
      // },


      /*~~~~ PAGINATION OF MODELS ~~~~*/
      /*******************************/
      doctorsPagination(page = 1) {

        axios.get(this.doctorSearchUrl, {
            params: {
              q        : this.query,
              page     : page,
              regionId : this.regionId,
              cityId   : this.cityId,
            }
          })
          .then(response => {
            this.doctors = response.data;
          });
      },
      tagsPagination(page = 1) {

        axios.get(this.tagSearchUrl + this.query + '&page=' + page)
          .then(response => {
            this.tags = response.data;
          });
      },
      // usersPagination(page = 1) {
      //   const this.userSearchUrl = appUrl +'/searches/users?q=';

      //   axios.get(this.userSearchUrl + this.query + '&page=' + page)
      //     .then(response => {
      //       this.users = response.data;
      //     });
      // }

    },

    /**~~~~ LOAD ON NEW SEARCH ~~~~*/
    /*******************************/
    created() {
      Event.$on('search_stuff', () => {
        $('#sitewideSearchContent').modal('show');
        this.searchDoctors();
        this.searchTags();
        // this.searchUsers();
      });

      Event.$on('search_by_location', (qRegionId, qCityId) => {
        this.regionId = qRegionId;
        console.log(this.regionId);

        this.cityId   = qCityId;
        console.log(this.cityId);
      })
    }
  }
</script>
