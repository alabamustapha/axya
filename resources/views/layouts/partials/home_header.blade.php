
   <div class="container text-center pt-5">
        <h1 class="display-2">Premium Health Care!</h1>
        <p class="lead text-uppercase pb-4">Search for doctors and book an appointment today.</p>

        <hr class="my-4">
        
        {{-- @include('layouts.partials.search_form') --}}
        
        <div class="pt-4">
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