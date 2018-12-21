<template>
  <div class="container">

    <div class="row mt-5"><!--  v-if="$gate.isAccountOwner()" -->
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Appointments</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Doctor</th>
                  <th><i class="fa fa-stethoscope"></i>&nbsp; Specialty</th>
                  <th>View Details</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="appointment in appointments" :key="appointment.id">
                  <td>{{ appointment.day }}</td>
                  <td>
                    <router-link to="/appointments/:slug">
                    <!-- <a :href="appointment.link" style="color:inherit;"> -->
                        <span v-text="appointment.status_text"></span>
                    <!-- </a> -->
                    </router-link>
                  </td>
                  <td>
                    <!-- <a :href="appointment.doctor.link" style="color:inherit;">
                        <span v-text="appointment.doctor.name"></span>
                    </a> -->
                  </td>
                  <td>
                    <!-- <a :href="appointment.doctor.specialty.link" style="color:inherit;">
                        <span v-text="appointment.doctor.specialty.name"></span>
                    </a> -->
                  </td>
                  <td>
                    <router-link to="/appointments/:slug">
                    <!-- <a :href="appointment.link" style="color:inherit;"> -->
                        <i class="fa fa-file"></i>&nbsp; 
                        <span v-text="appointment.description_preview"></span>
                    <!-- </a> -->
                    </router-link>
                  </td>
                </tr>
              </tbody>
            </table>
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
        appointments: {},
      }
    },

    methods: {
      loadAppointments() {
        axios.get('appointments')
          // .then(function(data) { return (this.appointments = data.data); });
          .then(({ data }) => (this.appointments = data));
      }
    },

    mounted() {
      console.log('Component mounted.')
    },

    created() {
      this.loadAppointments();
      // Event.$on('RefreshPage', () => {
      //     this.loadAppointments();
      // });
      // setInterval(() => this.loadAppointments(), 10000);
    }
  }
</script>
