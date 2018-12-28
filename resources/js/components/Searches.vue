<template>
  <div class="container" v-show="specialties.data || doctors.data || tags.data || users.data">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-none text-left">
          <div class="card-header bg-primary text-center p-2">
            <span>Results found for <b class="h4">{{this.$parent.search}}</b></span>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
            </div>
          </div>

          <div class="card-body" id="search-list">

            <div class="card-deck">

              <div class="card card-primary shadow-none mx-1">
                <div class="card-header">
                  <i class="fa fa-user-md"></i>&nbsp; Doctors
                </div>
                <div class="card-body p-2">
                  <div v-if="doctors.data != undefined && doctors.data.length">
                    <div class="p-1" v-for="doctor in doctors.data" :key="doctor.id">
                      
                      <span class="text-small">
                        <div class="mb-0 clearfix">
                          <a :href="doctor.link">
                            <img :src="doctor.avatar" class="text-sm-center" style="display:inline-block;width:80px;height: 80px; float:left" alt="Doctor Image" :title="doctor.user.name">
                          </a>

                          <div class="pl-2 text-left ml-2 ml-sm-0 ml-lg-2 d-flex flex-column justify-content-between h-100">
                            <div class="d-flex flex-row justify-content-between w-100 text-truncate">
                              <a class="users-list-name":href="doctor.link" :title="doctor.user.name">{{doctor.user.name}}</a>

                              <div v-if="$acl.isSuperAdmin()" :title="'Admin '+ doctor.user.name">
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
                            
                            <a :href="doctor.specialty.link" class="text-muted text-truncate" v-text="doctor.specialty.name" :title="doctor.specialty.name"></a>
                            <span class="text-muted text-truncate" v-text="doctor.location" :title="doctor.location"></span>

                          </div>
                        </div>
                        <div class="p-1 text-truncate tf-flex" title="Current rating">
                          <span>
                              <i class="fas fa-star pr-0 mr-0" v-for="i in doctor.rating_digit"></i>

                              <i class="fas fa-star pr-0 mr-0 orange" v-for="i in (5 - doctor.rating_digit)"></i>
                          </span>

                          <span>{{ doctor.rating }}</span>
                        </div>
                      </span>

                    </div>
                  </div>
                  <div class="short-content-bg" v-else>
                    0 results for <b>{{this.$parent.search}}</b> in <em class="text-bold">doctors</em>.
                  </div>
                </div>

                <div class="card-footer text-center mb-0 pb-1 px-2">
                  <div class="table-responsive tp-scrollbar m-0">
                    <div style="flex-flow: nowrap;">
                      <pagination :data="doctors" @pagination-change-page="doctorsPagination"></pagination>
                    </div>
                  </div>
                </div>
              </div>
              

              <div class="card card-secondary shadow-none mx-1">
                <div class="card-header">
                  <i class="fa fa-tags"></i>&nbsp; Keyword/Tags
                </div>

                <div class="card-body p-2 text-small">
                  <div v-if="tags.data != undefined && tags.data.length">
                    <div class="p-1 my-2 mx-0 short-content-bg" v-for="tag in tags.data" :key="tag.id">

                      <span>
                        <a class="text-bold" :href="tag.link" :title="tag.name +' - '+ tag.specialty.name" v-text="tag.name"></a>
                        &nbsp; |&nbsp; 
                        <span class="text-dark" v-text="tag.description_preview"></span>
                      </span>
                    </div>
                  </div>
                  <div class="short-content-bg" v-else>
                    0 results for <b>{{this.$parent.search}}</b> in <em class="text-bold">keywords</em>.
                  </div>
                </div>

                <div class="card-footer text-center mb-0 pb-1 px-2">
                  <div class="table-responsive tp-scrollbar m-0">
                    <div style="flex-flow: nowrap;">
                      <pagination :data="tags" @pagination-change-page="tagsPagination"></pagination>
                    </div>
                  </div>
                </div>
              </div>


              <div class="card card-secondary shadow-none mx-1">
                <div class="card-header">
                  <i class="fa fa-tags"></i>&nbsp; Specialties
                </div>
                <div class="card-body p-2 text-small">
                  <div v-if="specialties.data != undefined && specialties.data.length">
                    <div class="p-1" v-for="specialty in specialties.data" :key="specialty.id">

                      <span :title="specialty.name">
                        <a class="text-bold" :href="specialty.link" v-text="specialty.name"></a>
                        &nbsp; |&nbsp; 
                        <span class="text-dark" v-text="specialty.description_preview"></span>
                      </span>
                    </div>
                  </div>
                  <div class="short-content-bg" v-else>
                    0 results for <b>{{this.$parent.search}}</b> in <em class="text-bold">specialties</em>.
                  </div>
                </div>

                <div class="card-footer text-center mb-0 pb-1 px-2">
                  <div class="table-responsive tp-scrollbar m-0">
                    <div style="flex-flow: nowrap;">
                      <pagination :data="specialties" @pagination-change-page="specialtiesPagination"></pagination>
                    </div>
                  </div>
                </div>
              </div>


              <div class="card card-primary shadow-none mx-1" v-if="$acl.isSuperAdmin()">
                <div class="card-header">
                  <i class="fa fa-users"></i>&nbsp; Users
                </div>
                <div class="card-body p-2 text-small">
                  <div v-if="users.data != undefined && users.data.length">
                    <div class="p-1" v-for="user in users.data" :key="user.id">
                      
                      <span :title="user.name">
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
                      </span>

                    </div>
                  </div>
                  <div class="short-content-bg" v-else>
                    0 results for <b>{{this.$parent.search}}</b> in <em class="text-bold">users</em>.
                  </div>
                </div>

                <div class="card-footer text-center mb-0 pb-1 px-2">
                  <div class="table-responsive tp-scrollbar m-0">
                    <div style="flex-flow: nowrap;">
                      <pagination :data="users" @pagination-change-page="usersPagination"></pagination>
                    </div>
                  </div>
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
        this.searchDoctors();
        this.searchTags();
        this.searchSpecialties();
        this.searchUsers();
      })
    }
  }
</script>
