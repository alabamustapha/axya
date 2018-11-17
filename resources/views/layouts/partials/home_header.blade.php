<div class="jumbotron jumbotron-fluid">
   <div class="container text-center">
        <h1 class="display-4">Premium health care!</h1>
        <p class="lead">Search for doctors and book an appointment today.</p>
        <hr class="my-4">
        
        {{-- @include('layouts.partials.search_form') --}}
        
        <div>
          <div class="input-group input-group-lg">
            <input class="form-control form-control-navbar" 
                v-model="search" 
                @keyup="searchForQuery" 
                type="search" 
                placeholder="Search for doctors, ailments, specialties, medical procedures..." 
                aria-label="Search"
            >
            <div class="input-group-append">
              <button class="btn btn-navbar bg-white" @click="searchForQuery" type="submit">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>

          <searches></searches>
        </div> 

   </div>
</div>