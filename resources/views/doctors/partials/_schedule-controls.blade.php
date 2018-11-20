
<div class="w-15 tf-flex" v-if="creating">
  <span class="mr-3" class="teal" title="Create new schedule" @click="store">
    <i class="fa fa-save teal"></i>
  </span>

  <span class="orange" title="Cancel create" @click="closeForm">
    <i class="fa fa-times"></i>
  </span>
</div>

<div class="w-15 tf-flex" v-else>

  <div class="tf-flex" v-if="editing">
    <span class="mr-3" title="Save Edit" @click="update">
      <i class="fa fa-save teal"></i>{{-- &nbsp; Save --}}
    </span>

    <span title="Cancel Edit" @click="closeForm">
      <i class="fa fa-times orange"></i>{{-- &nbsp; Cancel --}}
    </span>
  </div>

  <div class="tf-flex" v-else>
    {{-- <span class="mr-3" title="Edit Schedule" @click="edit(schedule)">
      <i class="fa fa-edit teal"></i> 
    </span>

    <span title="Delete Schedule" @click="destroy">
      <i class="fa fa-trash red"></i>
    </span> --}}


    <span>              
      <button id="navbarDropdown" class="btn btn-sm btn-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-cog teal"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
        <span style="cursor: pointer;" class="dropdown-item" class="mr-3" title="Edit Schedule" @click="edit(schedule)">
          <i class="fa fa-edit teal"></i> Edit
        </span style="cursor: pointer;">

        <span style="cursor: pointer;" class="dropdown-item" title="Delete Schedule" @click="destroy">
          <i class="fa fa-trash red"></i> Delete
        </span style="cursor: pointer;">
      </div>
    </span>
  </div>

</div>  