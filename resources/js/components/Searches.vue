<template>
  <div class="container" v-show="searches.data || doctors.data || tags.data">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-none">
          <div class="card-header bg-primary text-center p-2">
            <span>
              <span class="h4"><b><!-- {{searches.data.length}}  --><i class="fa fa-user-md"></i></b></span> specialists found for <span class="h4"><b>{{this.$parent.search}}</b></span>
            </span>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
            </div>
          </div>

          <div class="card-body" id="search-list">

            <div class="card-deck">

              <!-- <div class="card card-primary shadow-none mx-1">
                <div class="card-header">
                  <i class="fa fa-user-md"></i>&nbsp; Doctors
                </div>
                <div class="card-body p-2">
                  <div class="px-3 py-1" v-for="doctor in searches.data" :key="doctor.id">
                    
                    <div class="row" :title="doctor.user.name">
                      <a :href="doctor.link">
                        <img :src="doctor.user.avatar" class="text-sm-center" style="display:inline-block;width:80px;height: 80px;" alt="Doctor Image">
                      </a>

                      <div class="text-left ml-2 ml-sm-0 ml-lg-2 d-flex flex-column justify-content-between h-100">
                        <div class="d-flex flex-row justify-content-between w-100">
                          <a class="users-list-name":href="doctor.link">{{doctor.user.name}}</a>

                          <div v-if="$acl.isSuperAdmin()">
                            <button id="navbarDropdown" class="btn btn-sm dropdown-toggle d-inline" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown" style="font-size:12px;">

                                <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to STAFF?');" title="Demote Admin">
                                  <i class="fa fa-user-tie teal"></i>&nbsp; Upgrade to Admin
                                </button>

                                <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                                  <i class="fa fa-user-tag indigo"></i>&nbsp; Upgrade to Staff
                                </button>

                                <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                                  <i class="fa fa-user-slash orange"></i>&nbsp; Demote to Normal User
                                </button>

                                <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                                  <i class="fa fa-ban red"></i>&nbsp; Block/Suspend
                                </button>
                            </div>
                          </div>
                        </div>
                        
                        <a :href="doctor.specialty.link" class="text-muted" v-text="doctor.specialty.name"></a>

                        <div class="d-flex flex-row justify-content-between w-100 mb-1">
                          <small class="text-muted">
                              <span class="fa fa-star text-primary p-0 m-0"></span>
                              <span class="fa fa-star text-primary p-0 m-0"></span>
                              <span class="fa fa-star text-primary p-0 m-0"></span>
                              <span class="fa fa-star text-primary p-0 m-0"></span>
                              <span class="fa fa-star text-primary p-0 m-0"></span>
                          </small>
                          <span>&nbsp;12(5)</span>
                        </div>

                      </div>
                      <a href="#" class="btn btn-primary btn-sm btn-block mt-1">
                        <i class="fa fa-calendar-check"></i>&nbsp; Make Appointment
                      </a>
                    </div>

                  </div>
                  <div class="card-footer text-center mb-0">
                      <pagination :data="searches" @pagination-change-page="makePagination"></pagination>
                  </div>
                </div>
              </div> -->

              <div class="card card-primary shadow-none mx-1">
                <div class="card-header">
                  <i class="fa fa-user-md"></i>&nbsp; Doctors
                </div>
                <div class="card-body p-2">
                  <div class="px-3 py-1" v-for="doctor in doctors.data" :key="doctor.id">
                    
                    <div class="row" :title="doctor.user.name">
                      <a :href="doctor.link">
                        <img :src="doctor.user.avatar" class="text-sm-center" style="display:inline-block;width:80px;height: 80px;" alt="Doctor Image">
                      </a>

                      <div class="text-left ml-2 ml-sm-0 ml-lg-2 d-flex flex-column justify-content-between h-100">
                        <div class="d-flex flex-row justify-content-between w-100">
                          <a class="users-list-name":href="doctor.link">{{doctor.user.name}}</a>

                          <div v-if="$acl.isSuperAdmin()">
                            <button id="navbarDropdown" class="btn btn-sm dropdown-toggle d-inline" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown" style="font-size:12px;">

                                <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to STAFF?');" title="Demote Admin">
                                  <i class="fa fa-user-tie teal"></i>&nbsp; Upgrade to Admin
                                </button>

                                <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                                  <i class="fa fa-user-tag indigo"></i>&nbsp; Upgrade to Staff
                                </button>

                                <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                                  <i class="fa fa-user-slash orange"></i>&nbsp; Demote to Normal User
                                </button>

                                <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                                  <i class="fa fa-ban red"></i>&nbsp; Block/Suspend
                                </button>
                            </div>
                          </div>
                        </div>
                        
                        <a :href="doctor.specialty.link" class="text-muted" v-text="doctor.specialty.name"></a>

                        <div class="d-flex flex-row justify-content-between w-100 mb-1">
                          <small class="text-muted">
                              <span class="fa fa-star text-primary p-0 m-0"></span>
                              <span class="fa fa-star text-primary p-0 m-0"></span>
                              <span class="fa fa-star text-primary p-0 m-0"></span>
                              <span class="fa fa-star text-primary p-0 m-0"></span>
                              <span class="fa fa-star text-primary p-0 m-0"></span>
                          </small>
                          <span>&nbsp;12(5)</span>
                        </div>

                      </div>
                      <a href="#" class="btn btn-primary btn-sm btn-block mt-1">
                        <i class="fa fa-calendar-check"></i>&nbsp; Make Appointment
                      </a>
                    </div>

                  </div>

                  <!-- <div class="short-content-bg" v-show="doctors.data.length == 0">
                    0 results in doctors.
                  </div> -->
                </div>
                <div class="card-footer text-center mb-0">
                    <pagination :data="doctors" @pagination-change-page="doctorsPagination"></pagination>
                </div>
              </div>
              

              <div class="card card-secondary shadow-none mx-1">
                <div class="card-header">
                  <i class="fa fa-tags"></i>&nbsp; Keyword/Tags
                </div>

                <div class="card-body p-2">
                  <div class="p-1 my-2 short-content-bg" v-for="tag in tags.data" :key="tag.id">

                    <span>
                      <a :href="tag.link" :title="tag.name +' - '+ tag.specialty.name" v-text="tag.name"></a>
                      &nbsp; |&nbsp; 
                      <span v-text="tag.description"></span>
                    </span>
                  </div>

                  <!-- <div class="short-content-bg" v-show="tags.data.length == 0">
                    0 results in keywords/tags.
                  </div> -->
                </div>

                <div class="card-footer text-center mb-0">
                    <pagination :data="tags" @pagination-change-page="tagsPagination"></pagination>
                </div>
              </div>
              

              <div class="card card-secondary shadow-none mx-1">
                <div class="card-header">
                  <i class="fa fa-tags"></i>&nbsp; Specialties
                </div>
                <div class="card-body p-2">
                  <div class="px-3 py-1" v-for="specialty in specialties.data" :key="specialty.id">

                    <div class="row" :title="specialty.name">
                      <a :href="specialty.link" v-text="specialty.name"></a>
                    </div>
                  </div>

                  <!-- <div class="short-content-bg" v-show="specialties.data.length == 0">
                    0 results in specialties.
                  </div> -->
                </div>

                <div class="card-footer text-center mb-0">
                    <pagination :data="specialties" @pagination-change-page="specialtiesPagination"></pagination>
                </div>
              </div>


              <div class="card card-primary shadow-none mx-1">
                <div class="card-header">
                  <i class="fa fa-users"></i>&nbsp; Users
                </div>
                <div class="card-body p-2">
                  <div class="px-3 py-1" v-for="user in users.data" :key="user.id">
                    
                    <div class="row" :title="user.name">
                      <a :href="user.link">
                        <img :src="user.avatar" class="text-sm-center" style="display:inline-block;width:80px;height: 80px;" alt="Doctor Image">
                      </a>

                      <div class="text-left ml-2 ml-sm-0 ml-lg-2 d-flex flex-column justify-content-between h-100">
                        <div class="d-flex flex-row justify-content-between w-100">
                          <a class="users-list-name":href="user.link">{{user.name}}</a>

                          <div v-if="$acl.isSuperAdmin()">
                            <button id="navbarDropdown" class="btn btn-sm dropdown-toggle d-inline" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown" style="font-size:12px;">

                                <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to STAFF?');" title="Demote Admin">
                                  <i class="fa fa-user-tie teal"></i>&nbsp; Upgrade to Admin
                                </button>

                                <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                                  <i class="fa fa-user-tag indigo"></i>&nbsp; Upgrade to Staff
                                </button>

                                <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                                  <i class="fa fa-user-slash orange"></i>&nbsp; Demote to Normal User
                                </button>

                                <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                                  <i class="fa fa-ban red"></i>&nbsp; Block/Suspend
                                </button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>

                  <!-- <div class="short-content-bg" v-show="users.data.length == 0">
                    0 results in users.
                  </div> -->
                </div>
                <div class="card-footer text-center mb-0">
                    <pagination :data="users" @pagination-change-page="usersPagination"></pagination>
                </div>
              </div>
              

            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        searches: {},
        doctors : {},
        tags    : {},
        users   : {},
        specialties : {},
      }
    },

    methods: {

      /** ~~~~ MAKE NEW SEARCHES ~~~~*/
      /*******************************/
      loadSearches() {
        // $parent needed to access the root instance at ...resources\js\app.js
        let query = this.$parent.search;
        const searchUrl = appUrl +'/searches?q=';

        axios.get(searchUrl + query)
        .then(({data}) => (this.searches = data))
        .then(()=>{
          if(this.searches.length){
            $('#search-list').css('display', 'block');//.show();
          }
        })
        .catch(()=>{
          //...
        })
      },
      searchDoctors() {
        // $parent needed to access the root instance at ...resources\js\app.js
        let query = this.$parent.search;
        // const searchUrl = appUrl +'/searches?q=';
        const searchUrl = appUrl +'/searches/doctors?q=';

        // axios.get(searchUrl + query +'&type=dr')
        axios.get(searchUrl + query)
        .then(({data}) => (this.doctors = data))
        .then(()=>{
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
        let query = this.$parent.search;
        const searchUrl = appUrl +'/searches/tags?q=';

        axios.get(searchUrl + query)
        .then(({data}) => (this.tags = data))
      },
      searchSpecialties() {
        // $parent needed to access the root instance at ...resources\js\app.js
        let query = this.$parent.search;
        const searchUrl = appUrl +'/searches/specialties?q=';

        axios.get(searchUrl + query)
        .then(({data}) => (this.specialties = data))
      },
      searchUsers() {
        // $parent needed to access the root instance at ...resources\js\app.js
        let query = this.$parent.search;
        const searchUrl = appUrl +'/searches/users?q=';

        axios.get(searchUrl + query)
        .then(({data}) => (this.users = data))
      },


      /*~~~~ PAGINATION OF MODELS ~~~~*/
      /*******************************/
      makePagination(page = 1) {
        let query = this.$parent.search; 
        const searchUrl = appUrl +'/searches?q=';

        axios.get(searchUrl + query + '&page=' + page)
          .then(response => {
            this.searches = response.data;
          });
      },
      doctorsPagination(page = 1) {
        let query = this.$parent.search; 
        const searchUrl = appUrl +'/searches/doctors?q=';

        axios.get(searchUrl + query + '&page=' + page)
          .then(response => {
            this.doctors = response.data;
          });
      },
      tagsPagination(page = 1) {
        let query = this.$parent.search; 
        const searchUrl = appUrl +'/searches/tags?q=';

        axios.get(searchUrl + query + '&page=' + page)
          .then(response => {
            this.tags = response.data;
          });
      },
      specialtiesPagination(page = 1) {
        let query = this.$parent.search; 
        const searchUrl = appUrl +'/searches/specialties?q=';

        axios.get(searchUrl + query + '&page=' + page)
          .then(response => {
            this.specialties = response.data;
          });
      },
      usersPagination(page = 1) {
        let query = this.$parent.search; 
        const searchUrl = appUrl +'/searches/users?q=';

        axios.get(searchUrl + query + '&page=' + page)
          .then(response => {
            this.users = response.data;
          });
      }

    },

    /**~~~~ LOAD ON NEW SEARCH ~~~~*/
    /*******************************/
    created() {
      Event.$on('search_stuff', () => {
        this.loadSearches();
        this.searchDoctors();
        this.searchTags();
        this.searchSpecialties();
        this.searchUsers();
      })
    }
  }
</script>
