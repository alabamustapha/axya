@extends('layouts.master')

@section('title', $doctor->user->name)

@section('content')

  <div class="container-fluid">

    <div class="row">
      <div class="col-md-4">

        <div class="card card-dark card-outline">
          <div class="card-body box-profile">
            <!-- Profile Image -->
            <div class="text-center">
              <a href="{{$doctor->user->originalAvatarFile}}" target="_blank" style="text-decoration:none;color: inherit;">
                <img class="profile-user-img img-fluid img-circle profile-img" src="{{$doctor->user->avatar}}" alt="{{$doctor->user->name}} profile picture">
              </a>
            </div>

            @if ($doctor->user->isAccountOwner())
            <div class="tf-flex">
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateAvatarForm" title=" Update Avatar">
                <i class="fa fa-upload text-light"></i>
              </button>

              
              @if ($doctor->user->hasUploadedAvatar())
                  <a href="{{route('user.avatar.delete', $doctor->user)}}" class="btn btn-sm btn-danger" title="Remove Avatar" onclick="return confirm('Do you want to remove current avatar?');">
                  <i class="fa fa-trash text-light"></i>
                </a>
              @endif
            </div>
            @endif

            <h3 class="profile-username text-center">{{$doctor->user->name}}</h3>

            <p class="text-muted text-center">

              @if ($doctor->user->isAccountOwner())
              
                <strong>{{$doctor->subscriptionStatus()}}</strong>

              @endif
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item p-1">
                <b>Specialties</b> <a class="float-right">{{--$doctor->specialty--}}</a>
              </li>
              <li class="list-group-item p-1">
                <b>Patients Served</b> <a class="float-right">{{$doctor->patients->count()}}</a>
              </li>
              <li class="list-group-item p-1">
                <b>Alma mater</b> <a class="float-right">{{ $doctor->graduate_school }}</a>
              </li>
              <li class="list-group-item p-1">
                <b>Availabilty</b> <a class="float-right">{{$doctor->available ? 'Available':'Unavailable'}}</a>
              </li>
              <li class="list-group-item p-1">
                <b>Practice Years</b> <a class="float-right">{{random_int(1,20)/*$doctor->practiceYears()*/}} yrs</a>
              </li>

              <li class="list-group-item p-1">
                <b>Location</b> <a class="float-right">{{$doctor->user->address}}</a>
              </li>
            </ul>

            @if ($doctor->user->isAccountOwner())
              <a onclick="return false;" class="btn btn-dark btn-block text-light" title="Update Profile" data-toggle="modal" data-target="#updateProfessionalProfileForm">
                <i class="fa fa-edit mr-1"></i> 
                <b>Edit Details</b>
              </a>
            @endif
          </div>
          <!-- /.card-body -->
        </div>

      </div>

      <div class="col-md-8">


        <!-- Available Hours Section -->
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title">
              {{--$doctor->availability()--}}
              Available Hours
            </h3>
          </div>
          <div class="card-body box-profile">

            <table class="table table-sm table-striped">
              <thead>
                <tr>
                  <th>Day</th>
                  <th>Period 1</th>
                  <th>Period 2</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th>Sunday</th>
                  <td>9:00am - 12:15pm</td>
                  <td>6:30pm - 09:00pm</td>
                </tr>
                <tr>
                  <th>Monday</th>
                  <td>9:00am - 12:15pm</td>
                  <td>6:30pm - 09:00pm</td>
                </tr>
                <tr>
                  <th>Tuesday</th>
                  <td>9:00am - 12:15pm</td>
                  <td>6:30pm - 09:00pm</td>
                </tr>
                <tr>
                  <th>Wednesday</th>
                  <td>9:00am - 12:15pm</td>
                  <td>6:30pm - 09:00pm</td>
                </tr>
                <tr>
                  <th>Thursday</th>
                  <td>9:00am - 12:15pm</td>
                  <td>6:30pm - 09:00pm</td>
                </tr>
                <tr>
                  <th>Friday</th>
                  <td>9:00am - 12:15pm</td>
                  <td>6:30pm - 09:00pm</td>
                </tr>
                <tr>
                  <th>Saturday</th>
                  <td>9:00am - 12:15pm</td>
                  <td>6:30pm - 09:00pm</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <!-- /.card -->

        <!-- Certification And Work Records Section -->
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title">Certification And Work Records</h3>
          </div>

          <div class="card-body">
            <div class="mb-5">
              <h4 class="mb-3">
                <strong><i class="fa fa-certificate"></i> Certifications</strong>
              </h4>
                      
              <ul class="list-group list-group-unbordered mb-0">
                <li class="list-group-item p-1 tf-flex "><b>Medical School:</b> <span><i class="fa fa-calendar"></i>&nbsp; June 2005</span></li>
                <li class="list-group-item p-1 tf-flex"><b>Medical Association:</b> <span><i class="fa fa-calendar"></i>&nbsp; August 2005</span></li>
                <li class="list-group-item p-1 border-bottom-0" title="Add new certificate">
                  <button class="btn btn-secondary btn-sm text-light">Add new &nbsp;<i class="fa fa-certificate"></i></button>
                </li>
              </ul>
            </div>

            <div>
              <h4 class="mb-3">
                <strong><i class="fa fa-hospital-alt"></i> Work records</strong>
              </h4>

              <div class="table-responsive">
                <table class="table table-sm">
                  @foreach($workplaces as $workplace)
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
                  @endforeach
                  <tr>
                    <td colspan="3">
                      <button class="btn btn-secondary btn-sm text-light" data-toggle="modal" data-target="#createWorkplaceForm" title="Add new workplace">
                        Add new &nbsp;<i class="fa fa-hospital-alt"></i></button>
                      </td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- Reviews Section -->
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title">Reviews</h3>
          </div>
          <div class="card-body box-profile">

            <ul class="list-group list-group-unbordered mb-0">
              <li class="list-group-item p-1">John Doe <span class="muted">Such a great professional. ****</span></li>
              <li class="list-group-item p-1">Jason Doe <span class="muted">The consultation was breathtaking. ****</span></li>
              <li class="list-group-item p-1">Jane Doe <span class="muted">I got good value for the money. ****</span></li>
            </ul>
          </div>
        </div>  
        <!-- /.card -->            
        
      </div>
    </div>

    @if ($doctor->user->isAccountOwner())
      <div class="modal" tabindex="-1" role="dialog" id="updateProfessionalProfileForm" style="display:none;" aria-labelledby="updateProfessionalProfileFormLabel" aria-hidden="true">
        <div class="modal-dialog{{--  modal-dialog-centered --}}" role="document">
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="modal-body">

              {{-- @include('doctors.forms.edit') --}}

            </div> <!-- modal-body -->    
          </div> <!-- modal-content -->    
        </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="createWorkplaceForm" style="display:none;" aria-labelledby="createWorkplaceFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
          <div class="modal-content px-3 bg-transparent shadow-none">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="modal-body">

              @include('doctors.forms.workplace')

            </div>
          </div>
        </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="updateAvatarForm" style="display:none;" aria-labelledby="updateAvatarFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
          <div class="modal-content px-3">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="modal-body">
              <div class="text-center">
                <img class="img-fluid img-circle profile-img" src="{{$doctor->user->avatar}}" alt="{{$doctor->user->name}} profile picture">

                <div class="form-group text-center">
                  <label for="avatar" class="h5">Update Display Picture</label>
                </div>
              </div>

              <form action="{{route('user.avatar.upload', $doctor->user)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}  
                {{ method_field('PATCH') }}   

                <div class="form-group text-center">
                  <input type="file" name="avatar" id="avatar" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}" accept="image/*" required>

                  @if ($errors->has('avatar'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('avatar') }}</strong>
                      </span>
                  @endif
                </div> 

                <div class="form-group">
                  <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-image"></i> Upload Avatar</button>
                </div>
              </form> 
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>

@endsection