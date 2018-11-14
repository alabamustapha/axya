<template>
  <div class="container" v-show="searches.length">
    <div class="row justify-content-center">
      <div class="col">
        <div class="card shadow-none">
          <div class="card-header bg-primary text-center">
            <b>{{searches.length}}</b> results found for <em><b>{{this.$parent.search}}</b></em>


            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
              <!-- <button type="button" class="btn btn-tool" data-widget="remove">
                <i class="fa fa-times"></i>
              </button> -->
            </div>
          </div>

          <div class="card-body">               
            <!-- <tr v-for="search in searches" :key="search.id"> -->

              <div class="mb-4">


                <div class="px-3 py-1" v-for="doctor in searches"><!--  :key="doctor.id" -->
                  <div class="row" :title="doctor.name">
                    <a class="users-list-name" :href="doctor.link">
                      <img :src="doctor.avatar" style="display:inline-block;width:80px;height: 80px;" alt="Doctor Image">
                    </a>
                    <span class="text-left ml-2">
                      <a class="users-list-name":href="doctor.link">{{doctor.name}}</a>
                      
                      <span class="text-muted" v-text="doctor.doctor.first_appointment"></span><br>
                    <!-- 
                      <span class="text-muted">{{doctor.type()}}</span><br>

                      <span>
                        <button id="navbarDropdown" class="btn btn-sm dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cog"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                          <form method="post" action="{{ route('make-staff', $admin) }}">
                            @csrf
                            {{method_field('PATCH')}}
                            <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to STAFF?');" title="Demote Admin">
                              <i class="fa fa-user-tag orange"></i>&nbsp; Demote to Staff
                            </button>
                          </form>
                          <form method="post" action="{{ route('make-normal', $admin) }}">
                            @csrf
                            {{method_field('PATCH')}}
                            <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                              <i class="fa fa-user-slash red"></i>&nbsp; Demote to Normal User
                            </button>
                          </form>
                        </div>
                      </span> 
                    -->
                    </span>
                  </div>
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
    created() {
      Event.$on('search_stuff', () => {
        let query = this.$parent.search; // This is accessed from a parent component i.e the root instance at ...resources\js\app.js thus need for .$parent
        axios.get('http://medapp.demo/api/searches?q=' + query)
        .then(({data}) => (this.searches = data.data))
        .catch(()=>{
          //...
        })
      })
    }
  }
</script>
