<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title"><i class="fa fa-hospital-alt"></i> Work Records</h3>

    <span class="card-tools">
      <button type="button" class="btn btn-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </span>
  </div>

  <div class="card-body">

    <div class="table-responsive pb-0">
      <table class="table table-sm">

        @forelse($workplaces as $workplace)
          <tr>
            <td>                      
              <span class="mr-3">              
                <button id="navbarDropdown" class="btn btn-sm btn-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cog teal"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                  <button class="dropdown-item" data-toggle="modal" data-target="#workplaceUpdateForm" title="Update Keyword">
                    <i class="fa fa-edit teal"></i>&nbsp; edit
                  </button>
                  <form method="post" action="{{route('workplaces.destroy', $workplace)}}">
                    @csrf
                    {{ method_field('DELETE') }} 
                    <button type="submit" class="dropdown-item" onclick="return confirm('You really want to delete this workplace?');" title="Delete Keyword">
                      <i class="fa fa-trash red"></i>&nbsp; delete
                    </button>
                  </form>
                </div>
              </span>

              {{ $workplace->name }}
            </td>
            <td>{{ $workplace->address }}</td>
            <td>
              <small class="tf-flex">
                <b class="" style="padding:2px;border:1px dotted gray;">{{ $workplace->start_date }}</b>

                <b class="" style="padding:2px;border:1px dotted gray;">{{ $workplace->end_date }}</b>
              </small>
            </td>
          </tr>
        @empty
          <tr>
            <td class="empty-list">No workplace at the moment.</td>
          </tr>
        @endforelse

        @if ($doctor->user->isAccountOwner())
        <tr>
          <td colspan="3">
            <button class="btn btn-secondary btn-sm text-light" data-toggle="modal" data-target="#createWorkplaceForm" title="Add new workplace">
              Add new &nbsp;<i class="fa fa-hospital-alt"></i>
            </button>
          </td>
        </tr>
        @endif
      </table>
    </div>
  </div>
  <!-- /.card-body -->
</div>

@if ($doctor->user->isAccountOwner() || Auth::user()->isAdmin())
<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title"><i class="fa fa-certificate"></i> Certifications</h3>

    <span class="card-tools">
      <button type="button" class="btn btn-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </span>
  </div>

  <div class="card-body" style="display: none;">
              
    <ul class="list-group list-group-unbordered mb-0">
      @foreach ($certificates as $certificate)
      <li class="list-group-item p-1 tf-flex "><b>{{$certificate->name}}:</b> <span><i class="fa fa-calendar"></i>&nbsp; {{$certificate->expiry_date}} <i class="fa fa-check green"></i></span></li>
      @endforeach
      {{-- <li class="list-group-item p-1 border-bottom-0" title="Add new certificate">
        <button class="btn btn-secondary btn-sm text-light">Add new &nbsp;<i class="fa fa-certificate"></i></button>
      </li> --}}
    </ul>
  </div>
</div>
@endif
