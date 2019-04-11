<template>

  <div class="modal fade bg-theme-blue" style="color:inherit;" role="dialog" id="sitewideSearchContent" aria-labelledby="sitewideSearchContentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">

        <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
          <span aria-hidden="true">&times;</span>
        </button>

        <br>
        <div class="modal-body">

          <form @submit.prevent="this.$parent.searchForQuery" class="form-inline">
              <input
                v-model="this.search"
                @keyup="this.$parent.searchForQuery"
                type="search"
                name="query" id="query"
                aria-label="Search" 
                placeholder="search..."
                class="form-control w-100 input-lg mr-sm-2 m-0 border-0 rounded search-form bg-dark"
                required>
          </form>
            <!--  
             <button @click="this.$parent.searchForQuery" type="submit" class="search-icon bg-theme-blue">
                  <i class="fa fa-search "></i>
              </button>
            -->
          <div class="text-center">
            <h1>
              <small class="text-sm">Search results for</small> <em class="text-warning">{{this.query}}</em></h1>            
          </div>


          <div class="result">

            <div class="result-nav px-3 ">
              <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="doctor-tab" data-toggle="tab" href="#doctor" role="tab" aria-controls="doctor" aria-selected="true">Doctor</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="tag-tab" data-toggle="tab" href="#tag" role="tab" aria-controls="tag" aria-selected="false">Keyword/Tag</a>
                </li>
              </ul>
            </div>

            <div class="result-body">
              <div class="tab-content" id="myTabContent">

                <div class="tab-pane fade show active" id="doctor" role="tabpanel" aria-labelledby="doctor-tab">

                  <div v-if="doctors.data != undefined && doctors.data.length">
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
                        <span class="ratings">
                          <a :href="doctor.link +'#reviews'" :title="doctor.name +' - '+ doctor.specialty.name" style="color:inherit;">
                            <i class="fas fa-star" v-for="i in doctor.rating_digit"></i>
                          </a>
                        </span>
                      </div>
                    </div>
                  </div>

                  <div v-else>
                    <div class="text-center" v-show="!loading">
                      <div class="display-3"><i class="fa fa-user-md"></i></div> 

                      <br>

                      <p><strong>0</strong> results for <b>{{this.$parent.search}}</b> in <em class="text-bold">doctors</em>.</p>
                    </div>
                  </div>

                  <div class="text-center" v-show="loading">
                    <span class="d-inline-block">
                      Searching doctors <i class="fa fa-user-md"></i> for <b>{{this.$parent.search}}</b>...
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
                  <div v-if="tags.data != undefined && tags.data.length">
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

                      <p><strong>0</strong> results for <b>{{this.$parent.search}}</b> in <em class="text-bold">tags</em>.</p>
                    </div>
                  </div>

                  <div class="text-center" v-show="loading">
                    <span class="d-inline-block">
                      Searching keywords <i class="fa fa-tags"></i> for <b>{{this.$parent.search}}</b>...
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
        loading : true,
        // searches: {},
        doctors : {},
        tags    : {},
        // users   : {},
        search : '',
        query : this.computedQuery,
      }
    },

    computed: {
      // a computed getter
      computedQuery: function () {
        console.log(this.search != undefined);
        console.log(this.search.length);

        return (this.search != undefined && this.search.length) 
              ? this.search : this.$parent.search
              ;
      }
    },

    methods: {

      /** ~~~~ MAKE NEW SEARCHES ~~~~*/
      /*******************************/
      searchDoctors() {
        // $parent needed to access the root instance at ...resources\js\app.js

        // const searchUrl = appUrl +'/searches?q=';
        const searchUrl = appUrl +'/searches/doctors?q=';

        // axios.get(searchUrl + this.query +'&type=dr')
        axios.get(searchUrl + this.query)
        .then(({data}) => (this.doctors = data))
        .then(() => { this.loading = false; })
        .then(() =>{
          if(this.doctors.length){
            $('#search-list').css('display', 'block');//.show();
          }
        })
        .catch(()=>{
          //...
        })
      },
      searchTags() {
        // $parent needed to access the root instance at ...resources\js\app.js
        this.query = (this.search != undefined && this.search.length) ? this.search : this.$parent.search;
        const searchUrl = appUrl +'/searches/tags?q=';

        axios.get(searchUrl + this.query)
        .then(({data}) => (this.tags = data))
        .then(() => { this.loading = false; })
      },
      // searchUsers() {
      //   // $parent needed to access the root instance at ...resources\js\app.js
      //   this.query = (this.search != undefined && this.search.length) ? this.search : this.$parent.search;
      //   const searchUrl = appUrl +'/searches/users?q=';

      //   axios.get(searchUrl + this.query)
      //   .then(({data}) => (this.users = data))
      //   .then(() => { this.loading = false; })
      // },


      /*~~~~ PAGINATION OF MODELS ~~~~*/
      /*******************************/
      doctorsPagination(page = 1) {
        const searchUrl = appUrl +'/searches/doctors?q=';

        axios.get(searchUrl + this.query + '&page=' + page)
          .then(response => {
            this.doctors = response.data;
          });
      },
      tagsPagination(page = 1) {
        const searchUrl = appUrl +'/searches/tags?q=';

        axios.get(searchUrl + this.query + '&page=' + page)
          .then(response => {
            this.tags = response.data;
          });
      },
      // usersPagination(page = 1) {
      //   const searchUrl = appUrl +'/searches/users?q=';

      //   axios.get(searchUrl + this.query + '&page=' + page)
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
      })
    }
  }
</script>
