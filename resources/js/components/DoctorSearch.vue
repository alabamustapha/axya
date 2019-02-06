<template>
  <div class="container" v-show="doctors.data">

    <div class="card shadow-none mx-1" v-if="$acl.isSuperAdmin()">
      <div class="card-header">
        <i class="fa fa-user-md"></i>&nbsp; Doctors found for the query: <b class="h4">{{this.$parent.search}}</b>
      </div>

      <div class="card-body p-1 text-small">

        <div v-if="doctors.data != undefined && doctors.data.length">

          <div class="card-columns">
            <div class="p-1" v-for="doctor in doctors.data" :key="doctor.id">

              <div class="card shadow-none">
                <div class="card-body p-1 text-center text-sm" :title="doctor.name">

                  <div class="list-group">

                    <span class="list-group-item p-1 text-center">
                      <a :href="doctor.link">
                        <img :src="doctor.avatar" class="rounded" style="display:block;width:80px;height: 80px;" alt="Doctor Image">
                      </a>
                    </span>
                    <a class="list-group-item list-group-item-action p-1 text-primary text-truncate" :href="doctor.link">
                      <span><i class="fa fa-user-md"></i>&nbsp; {{doctor.name}}</span>
                    </a>
                    <a class="list-group-item list-group-item-action p-1 text-primary text-truncate tf-flex" :href="doctor.transactions_list">
                      <span><i class="fa fa-handshake"></i>&nbsp; Transactions:</span>
                      <span class="badge badge-info">{{doctor.transactions_count}}</span>
                    </a>
                    <a class="list-group-item list-group-item-action p-1 text-primary text-truncate tf-flex" :href="doctor.completed_appointments_list">
                      <span><i class="fa fa-calendar-alt"></i>&nbsp; Appointments:</span>
                      <span class="badge badge-info">{{doctor.appointments_count}}</span>
                    </a>
                    <a class="list-group-item list-group-item-action p-1 text-primary text-truncate tf-flex" :href="doctor.subscriptions_list">
                      <span><i class="fa fa-rss"></i>&nbsp; Subscriptions:</span>
                      <span class="badge badge-info">{{doctor.subscriptions_count}}</span>
                    </a>
                    <a class="list-group-item list-group-item-action p-1 text-primary text-truncate tf-flex" :href="doctor.patients_list">
                      <span><i class="fa fa-diagnoses"></i>&nbsp; Patients:</span>
                      <span class="badge badge-info">{{doctor.patients_count}}</span>
                    </a>
                    
                    <span class="list-group-item p-1 tf-flex">
                      <span><i class="fa fa-star"></i>&nbsp; Rating:</span> <strong>{{doctor.rating}}</strong>
                    </span>
                    <span class="list-group-item p-1 tf-flex">
                      <span><i class="fa fa-info-circle"></i>&nbsp; Status:</span> <strong :class="doctor.is_active ? ' green':' red'">{{doctor.availability_text}}</strong>
                    </span>
                    <span class="list-group-item p-1 tf-flex">
                      <span><i class="fa fa-id-card-alt"></i>&nbsp; License:</span> <strong :class="doctor.revoked ? ' red':' green'">{{doctor.license_status}}</strong>
                    </span>

                    <span class="list-group-item p-1" v-if="$acl.isSuperAdmin()">

                      <button id="navbarDropdown" class="btn btn-sm btn-block btn-dark text-left dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cog"></i>
                      </button>
                      <span class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown" style="font-size:12px;">

                        <span v-if="doctor.revoked">
                          <button type="submit" class="dropdown-item d-inline-block" @click="restoreLicense(doctor)" title="Restore license back to this doctor on this app">
                            <i class="fa fa-id-card teal"></i>&nbsp; Restore License
                          </button>
                          </span>
                          <span v-else>
                          <button type="submit" class="dropdown-item d-inline-block" @click="revokeLicense(doctor)" title="Revoke license from this doctor on this app">
                            <i class="fa fa-id-card orange"></i>&nbsp; Revoke License
                          </button>
                        </span>

                      </span>

                    </span>
                  </div>

                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.card-columns -->

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
          <span class="d-inline-block fa-3x h5">
            <i class="fas fa-sync fa-spin"></i>
          </span>
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
  </div>
</template>

<script>
  export default {
    data() {
      return {
        loading : true,
        doctors   : {},
      }
    },

    methods: {

      /**
       * Block a user on the platform.
       */
      revokeLicense(doctor) {

        if (confirm('You really want to revoke this doctor\'s license?')){
          this.$Progress.start();

          axios.patch('/'+ doctor.slug + '/revoke')
          .then(() => {
            doctor.revoked = 1;
            doctor.license_status = 'Revoked';
            doctor.is_active = false;
            doctor.availability_text = 'unavailable';

            toast({type: 'success', title: 'Dr. '+ doctor.name +'\'s license is now revoked on this platform.'});
            this.$Progress.finish();
          })
          .catch(() => {
            toast({type: 'error', title: 'An error occurred! Try again.'});
            this.$Progress.fail();
          });
        }
      },

      /**
       * Block a doctor on the platform.
       */
      restoreLicense(doctor) {

        if (confirm('You really want to restore this doctor\'s license?')){
          this.$Progress.start();

          axios.patch('/'+ doctor.slug + '/restore')
          .then(() => {
            doctor.revoked = 0;
            doctor.license_status = 'Active';

            toast({type: 'success', title: 'Dr. '+ doctor.name +'\'s license is now restored.'});
            this.$Progress.finish();
          })
          .catch(() => {
            toast({type: 'error', title: 'An error occurred! Try again.'});
            this.$Progress.fail();
          });
        }
      },

      /** ~~~~ MAKE NEW SEARCHES ~~~~*/
      /*******************************/
      searchDoctors() {
        // $parent needed to access the root instance at ...resources\js\app.js
        let query = this.$parent.search;
        const searchUrl = appUrl +'/searches/doctors?q=';

        axios.get(searchUrl + query)
        .then(({data}) => (this.doctors = data))
        .then(() => { this.loading = false; })
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
      }

    },

    /**~~~~ LOAD ON NEW SEARCH ~~~~*/
    /*******************************/
    created() {
      Event.$on('search_doctor', () => {
        this.searchDoctors();
      })
    }
  }
</script>
