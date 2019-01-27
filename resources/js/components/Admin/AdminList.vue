<template>
  <div>

    <div v-if="admins.data != undefined && admins.data.length">
      <div v-for="admin in admins.data" :key="admin.id">
        <div class="px-3 py-1 text-sm">
          <div class="row">
            <a class="d-inline-block" :href="admin.link">
              <img :src="admin.avatar" style="width:80px;height: 80px;" alt="Admin Avatar">
            </a>

            <div class="d-inline-block text-left ml-2">
              <a :href="admin.link" v-text="admin.name"></a>

              <br>

              <span>
                <span class="text-muted" v-text="admin.type"></span>

                <span v-if="$acl.isSuperAdmin()">
                  <button id="navbarDropdown" class="btn btn-sm dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-cog"></i>
                  </button>
                  <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">

                      <button @click="makeStaff(admin)" class="dropdown-item btn-sm" title="Demote Admin">
                        <i class="fa fa-user-tag orange"></i>&nbsp; Demote to Staff
                      </button>

                      <button @click="makeNormal(admin)" class="dropdown-item btn-sm" title="Demote Admin">
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
            <pagination :data="admins" @pagination-change-page="adminsPagination"></pagination>
          </div>
        </div>
      </div>
    </div>

    <div v-else>
      <span class="d-inline-block">
        Loading admins...
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
        admins   : {},
      }
    },

    methods: {

      /**
       * Demote this Admin to STAFF.
       */
      makeStaff(user) {

        if (confirm('You really want to demote this admin to STAFF?')){
          this.$Progress.start();

          axios.patch('/make/'+ user.slug +'/staff')
          .then(() => {
            Event.$emit('list_admin');

            toast({type: 'success', title: user.name +' made staff successfully.'});
            this.$Progress.finish();
          })
          .catch(() => {
            toast({type: 'fail', title: 'An error occurred! Try again.'});
            this.$Progress.fail();
          });
        }
      },

      /**
       * Demote this Admin a Normal User.
       */
      makeNormal(user) {

        if (confirm('You really want to demote this admin to NORMAL User?')){
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
      listAdmins() {
        axios.get('/dashboard/list-admins')
        .then(({data}) => (this.admins = data))
      },


      /**
       * PAGINATION OF MODELS
       */
      adminsPagination(page = 1) {
        axios.get('/dashboard/list-admins' + '?page=' + page)
          .then(response => {
            this.admins = response.data;
          });
      }

    },

    /**
     * LOAD ON NEW SEARCH 
     */
    created() {
      this.listAdmins();
      Event.$on('list_admin', () => {
        this.listAdmins();
      })
    }
  }
</script>
