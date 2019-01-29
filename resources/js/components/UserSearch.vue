<template>
  <div class="container" v-show="users.data">

    <div class="card shadow-none mx-1" v-if="$acl.isSuperAdmin()">
      <div class="card-header">
        <i class="fa fa-users"></i>&nbsp; Users found for the query: <b class="h4">{{this.$parent.search}}</b>
      </div>

      <div class="card-body p-1 text-small">

        <div v-if="users.data != undefined && users.data.length">

          <div class="card-columns">
            <div class="p-1" v-for="user in users.data" :key="user.id">

              <div class="card shadow-none">
                <div class="card-body p-1 text-center text-sm" :title="user.name">

                  <div class="list-group">

                    <span class="list-group-item p-1 text-center">
                      <a :href="user.link">
                        <img :src="user.avatar" class="rounded" style="display:block;width:80px;height: 80px;" alt="Doctor Image">
                      </a>
                    </span>
                    <a class="list-group-item list-group-item-action p-1 text-primary text-truncate" :href="user.link">
                      <span><i class="fa fa-user-md"></i>&nbsp; {{user.name}}</span>
                    </a>
                    <a class="list-group-item list-group-item-action p-1 text-primary text-truncate tf-flex" :href="user.transactions_list">
                      <span><i class="fa fa-handshake"></i>&nbsp; Transactions:</span>
                      <span class="badge badge-info">{{user.transactions_count}}</span>
                    </a>
                    <a class="list-group-item list-group-item-action p-1 text-primary text-truncate tf-flex" :href="user.appointments_list">
                      <span><i class="fa fa-calendar-alt"></i>&nbsp; Appointments:</span>
                      <span class="badge badge-info">{{user.appointments_count}}</span>
                    </a>
                    
                    <span class="list-group-item p-1 tf-flex">
                      <span><i class="fa fa-user-check"></i>&nbsp; Type:</span> <strong>{{user.type}}</strong>
                    </span>
                    <span class="list-group-item p-1 tf-flex">
                      <span><i class="fa fa-info-circle"></i>&nbsp; Status:</span> <strong :class="(user.blocked) ? ' red':' green'">{{user.status}}</strong>
                    </span>

                    <span class="list-group-item p-1" v-if="$acl.isSuperAdmin()">

                      <button id="navbarDropdown" class="btn btn-sm btn-block btn-dark text-left dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cog"></i>
                      </button>
                      <span class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown" style="font-size:12px;">
                        <span class="d-block" v-if="! user.is_administrator || ! user.is_staff_user">
                          <button class="dropdown-item" @click="makeStaff(user)" title="Promote to Staff">
                            <i class="fa fa-user-tag indigo"></i>&nbsp; Upgrade to Staff
                          </button>
                        </span>

                        <span class="d-block" v-if="user.blocked">
                          <button class="dropdown-item" @click="unblockUser(user)" title="Unblock user">
                            <i class="fa fa-ban green"></i>&nbsp; UnBlock
                          </button>
                        </span>
                        <span class="d-block" v-else>
                          <button class="dropdown-item" @click="blockUser(user)" title="Block user">
                            <i class="fa fa-ban red"></i>&nbsp; Block
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
</template>

<script>
  export default {
    props: ['admins_count','staffs_count'],

    data() {
      return {
        users   : {},
        blockedText: '',
        adminsCount: this.admins_count,
        staffsCount: this.staffs_count,
      }
    },

    methods: {

      /**
       * Demote this Admin to STAFF.
       */
      makeStaff(user) {

        if (confirm('You really want to promote this user to STAFF?')){
          this.$Progress.start();

          axios.patch('/make/'+ user.slug +'/staff')
          .then(() => {
            var stfCount = this.staffsCount + 1;

            Event.$emit( 'list_admin', stfCount,  this.adminsCount );

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
       * Block a user on the platform.
       */
      blockUser(user) {

        if (confirm('You really want to block this user?')){
          this.$Progress.start();

          axios.patch('/'+ user.slug + '/block')
          .then(() => {
            user.blocked = 1;
            user.status = 'Blocked';

            toast({type: 'success', title: user.name +' is now blocked on this platform.'});
            this.$Progress.finish();
          })
          .catch(() => {
            toast({type: 'fail', title: 'An error occurred! Try again.'});
            this.$Progress.fail();
          });
        }
      },

      /**
       * Block a user on the platform.
       */
      unblockUser(user) {

        if (confirm('You really want to unblock this user?')){
          this.$Progress.start();

          axios.patch('/'+ user.slug + '/unblock')
          .then(() => {
            user.blocked = 0;
            user.status = 'Active';

            toast({type: 'success', title: user.name +' is now unblocked.'});
            this.$Progress.finish();
          })
          .catch(() => {
            toast({type: 'fail', title: 'An error occurred! Try again.'});
            this.$Progress.fail();
          });
        }
      },

      /** ~~~~ MAKE NEW SEARCHES ~~~~*/
      /*******************************/
      searchUsers() {
        // $parent needed to access the root instance at ...resources\js\app.js
        let query = this.$parent.search;
        const searchUrl = appUrl +'/searches/users?q=';

        axios.get(searchUrl + query)
        .then(({data}) => (this.users = data))
      },


      /*~~~~ PAGINATION OF MODELS ~~~~*/
      /*******************************/
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
      Event.$on('search_user', () => {
        this.searchUsers();
      })
    }
  }
</script>
