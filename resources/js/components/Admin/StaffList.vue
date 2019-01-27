<template>
  <div>

    <div v-if="staffs.data != undefined && staffs.data.length">
      <div v-for="staff in staffs.data" :key="staff.id">
        <div class="px-3 py-1 text-sm">
          <div class="row">
            <a class="d-inline-block" :href="staff.link">
              <img :src="staff.avatar" style="width:80px;height: 80px;" alt="Staff Avatar">
            </a>

            <div class="d-inline-block text-left ml-2">
              <a :href="staff.link" v-text="staff.name"></a>

              <br>

              <span>
                <span class="text-muted" v-text="staff.type"></span>

                <span v-if="$acl.isSuperAdmin()">
                  <button id="navbarDropdown" class="btn btn-sm dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-cog"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">

                      <button @click="makeAdmin(staff)" class="dropdown-item btn-sm" title="Promote Staff">
                        <i class="fa fa-user-tie green"></i>&nbsp; Promote to Admin
                      </button>

                      <button @click="makeNormal(staff)" class="dropdown-item btn-sm" title="Demote Staff">
                        <i class="fa fa-user-slash red"></i>&nbsp; Demote to Normal User
                      </button>

                  </div>
                </span>

              </span>
            </div>
          </div>
        </div>
      </div>

      <div class="text-center mb-0 pb-1 px-2">
        <div class="table-responsive tp-scrollbar m-0">
          <div style="flex-flow: nowrap;">
            <pagination :data="staffs" @pagination-change-page="staffsPagination"></pagination>
          </div>
        </div>
      </div>
    </div>

    <div v-else>
      <span class="d-inline-block">
        Loading staffs...
      </span>
      <span class="d-inline-block fa-3x h5">
        <i class="fas fa-sync fa-spin"></i>
      </span>
    </div>

  </div>
</template>

<script>
  export default {
    data() {
      return {
        staffs   : {},
      }
    },

    methods: {

      /**
       * Promote this Staff to ADMIN.
       */
      makeAdmin(user) {

        if (confirm('You really want to promote this staff to ADMIN?')){
          this.$Progress.start();

          axios.patch('/make/'+ user.slug +'/admin')
          .then(() => {
            Event.$emit('list_admin');

            toast({type: 'success', title: user.name +' made admin successfully.'});
            this.$Progress.finish();
          })
          .catch(() => {
            toast({type: 'fail', title: 'An error occurred! Try again.'});
            this.$Progress.fail();
          });
        }
      },

      /**
       * Demote this Staff a Normal User.
       */
      makeNormal(user) {

        if (confirm('You really want to demote this staff to NORMAL User?')){
          this.$Progress.start();

          axios.patch('/make/'+ user.slug +'/normal')
          .then(() => {
            Event.$emit('list_admin')

            toast({type: 'success', title: user.name +' made normal user successfully.'});
            this.$Progress.finish();
          })
          .catch(() => {
            toast({type: 'fail', title: 'An error occurred! Try again.'});
            this.$Progress.fail();
          });
        }
      },

      /**
       * LOAD ADMIN LISTS
       */
      listStaffs() {
        axios.get('/dashboard/list-staffs')
        .then(({data}) => (this.staffs = data))
      },

      /**
       * PAGINATION OF MODELS
       */
      staffsPagination(page = 1) {
        axios.get('/dashboard/list-staffs' + '?page=' + page)
          .then(response => {
            this.staffs = response.data;
          });
      }

    },

    /**
     * LOAD ON NEW SEARCH 
     */
    created() {
      this.listStaffs();
      Event.$on('list_admin', () => {
        this.listStaffs();
      })
    }
  }
</script>
