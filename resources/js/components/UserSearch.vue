<template>
  <div class="container" v-show="users.data">
    <!-- <div class="row justify-content-center">
      <div class="col"> -->

        <!-- <div class="" id="search-list"> -->

          <!-- <div class="card-deck"> -->
            <div class="card card-primary shadow-none mx-1" v-if="$acl.isSuperAdmin()">
              <div class="card-header">
                <i class="fa fa-users"></i>&nbsp; Users found for <b class="h4">{{this.$parent.search}}</b>
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
                              <span>{{user.name}}</span>
                            </a>
                            
                            <span class="list-group-item p-1 tf-flex">Type: <strong>{{user.type}}</strong></span>
                            <span class="list-group-item p-1 tf-flex">Status: <strong :class="user.blocked ? ' red':' green'">{{user.status}}</strong></span>
                            <a class="list-group-item list-group-item-action p-1 text-primary text-truncate" :href="user.transactions_index">
                              <span>Transactions: <span class="badge badge-info">{{user.transactions_count}}</span></span>
                            </a>
                            <a class="list-group-item list-group-item-action p-1 text-primary text-truncate" :href="user.appointments_index">
                              <span>Appointments: <span class="badge badge-info">{{user.appointments_count}}</span></span>
                            </a>
                            <span class="list-group-item p-1 tf-flex">Transactions: <span class="badge badge-info">{{user.transactions_count}}</span></span>
                            <span class="list-group-item p-1 tf-flex">Appointments: <span class="badge badge-info">{{user.appointments_count}}</span></span>
                            <span class="list-group-item p-1" v-if="$acl.isSuperAdmin()">

                              <button id="navbarDropdown" class="btn btn-sm btn-block btn-dark text-left dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fa fa-cog"></i>
                              </button>
                              <span class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown" style="font-size:12px;">

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
          <!-- </div> -->
        <!-- </div> -->

      <!-- </div>
    </div>
 -->  </div>
</template>

<script>
  export default {
    data() {
      return {
        users   : {},
      }
    },

    methods: {

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
