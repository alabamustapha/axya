<template>
  <div class="container" v-show="searches.length">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-none">
          <div class="card-header bg-primary text-center p-2">
            <span>
              <span class="h4"><b>{{searches.length}} <i class="fa fa-user-md"></i></b></span> specialists found for <span class="h4"><b>{{this.$parent.search}}</b></span>
            </span>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
            </div>
          </div>

          <div class="card-body" id="search-list">
            <!-- <tr v-for="search in searches" :key="search.id"> -->

              <div class="mb-4">

                <div class="px-3 py-1" v-for="doctor in searches" key="doctor.id">
                  <div class="row col-sm-6 col-md-4" :title="doctor.user.name">
                    <a :href="doctor.link">
                      <img :src="doctor.user.avatar" class="text-sm-center" style="display:inline-block;width:80px;height: 80px;" alt="Doctor Image">
                    </a>

                    <div class="text-left ml-2 ml-sm-0 ml-lg-2 d-flex flex-column justify-content-between h-100">
                      <div class="d-flex flex-row justify-content-between w-100">
                        <a class="users-list-name":href="doctor.link">{{doctor.user.name}}</a>

                        <div v-if="$acl.isAdmin()">
                          <button id="navbarDropdown" class="btn btn-sm dropdown-toggle d-inline" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="fa fa-cog"></i>
                          </button>
                          <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                            <!-- <form method="post" action="{{ route('make-staff', $admin) }}">
                              @csrf
                              {{method_field('PATCH')}} -->
                              <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to STAFF?');" title="Demote Admin">
                                <i class="fa fa-user-tag orange"></i>&nbsp; Demote to Staff
                              </button>
                            <!-- </form>
                            <form method="post" action="{{ route('make-normal', $admin) }}">
                              @csrf
                              {{method_field('PATCH')}} -->
                              <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                                <i class="fa fa-user-slash red"></i>&nbsp; Demote to Normal User
                              </button>
                            <!-- </form> -->
                          </div>
                        </div>
                      </div>
                      
                      <a :href="doctor.specialty.link" class="text-muted" v-text="doctor.specialty.name"></a><!-- <br> -->

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

<!-- 
                  <div class="row col-sm-6 col-md-4" :title="doctor.name">
                    <div class="text-left ml-2 ml-sm-0 ml-lg-2 d-flex flex-column justify-content-between h-100">
                      <div class="d-flex flex-row justify-content-between w-100">
                        <a class="users-list-name":href="doctor.link">{{doctor.name}}</a>
                      </div>
                      
                      <a :href="doctor.link" class="text-muted" v-text="doctor.description"></a>

                    </div>
                    <a href="#" class="btn btn-primary btn-sm btn-block mt-1">
                      <i class="fa fa-user-md"></i>&nbsp; View Doctors
                    </a>
                  </div> -->
                </div>
              </div>
            <!-- </tr> -->
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
        searches : {}
      }
    },
    methods: {
      loadSearches() {
        let query = this.$parent.search; // This is accessed from a parent component i.e the root instance at ...resources\js\app.js thus need for .$parent
        const searchUrl = appUrl +'/searches?q=';

        axios.get(searchUrl + query)
        .then(({data}) => (this.searches = data.data))
        .then(()=>{
          if(this.searches.length){
            $('#search-list').css('display', 'block');//.show();
          }
        })
        .catch(()=>{
          //...
        })
      }
    },
    created() {
      Event.$on('search_stuff', () => {
        this.loadSearches();
      })
    }
  }
</script>
