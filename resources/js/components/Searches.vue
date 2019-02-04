<template>
  <div id="search-result" class=" shadow ">
    <div class="result">
      <div class="result-header text-center p-3">
        <span class="h4 result-title  text-darker"></span>
      </div>

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

                      <div class="d-inline-block" v-if="$acl.isSuperAdmin()" :title="'Admin '+ doctor.user.name">
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
            <div class="text-center p-3" v-else>
              0 results for <b>{{this.$parent.search}}</b> in <em class="text-bold">doctors</em>.
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
            <div class="text-center p-3" v-else>
              0 results for <b>{{this.$parent.search}}</b> in <em class="text-bold">tags</em>.
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

    <!-- <div class="card shadow-none text-left">
      <div class="card-header bg-primary text-center p-2">
        <span>Results found for <b class="h4">{{this.$parent.search}}</b></span>
      </div>

      <div class="card-body" id="search-list">

        <div class="card-deck">
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

    </div> -->
  </div>
</template>

<script>
  export default {
    data() {
      return {
        // searches: {},
        doctors : {},
        tags    : {},
        // users   : {},
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
      // searchUsers() {
      //   // $parent needed to access the root instance at ...resources\js\app.js
      //   let query = this.$parent.search;
      //   const searchUrl = appUrl +'/searches/users?q=';

      //   axios.get(searchUrl + query)
      //   .then(({data}) => (this.users = data))
      // },


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
      // usersPagination(page = 1) {
      //   let query = this.$parent.search; 
      //   const searchUrl = appUrl +'/searches/users?q=';

      //   axios.get(searchUrl + query + '&page=' + page)
      //     .then(response => {
      //       this.users = response.data;
      //     });
      // }

    },

    /**~~~~ LOAD ON NEW SEARCH ~~~~*/
    /*******************************/
    created() {
      Event.$on('search_stuff', () => {
        this.searchDoctors();
        this.searchTags();
        // this.searchUsers();
      })
    }
  }
</script>
