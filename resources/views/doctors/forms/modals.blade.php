
    @if ($doctor->user->isAccountOwner())

      <!-- New Workplace Form-->
      <div class="modal" tabindex="-1" role="dialog" id="createWorkplaceForm" style="display:none;" aria-labelledby="createWorkplaceFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
          <div class="modal-content px-0 pb-0 bg-transparent shadow-none">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="modal-body pb-0">

              @include('doctors.forms.workplace')

            </div>
          </div>
        </div>
      </div>
      <!-- END - New Workplace Form-->

      <!-- Avatar Update Form-->
      <div class="modal" tabindex="-1" role="dialog" id="updateAvatarForm" style="display:none;" aria-labelledby="updateAvatarFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
          <div class="modal-content px-3">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="modal-body">
              <div class="text-center">
                <img class="img-fluid img-circle profile-img" src="{{$doctor->user->avatar}}" alt="{{$doctor->name}} profile picture">

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
      <!-- END - Avatar Update Form-->

      <!-- Schedule Update Form-->
      <div class="modal" tabindex="-1" role="dialog" id="updateScheduleForm" style="display:none;" aria-labelledby="updateScheduleFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
          <div class="modal-content px-3">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="modal-body">

              <form action="{{-- route('schedules.update', $schedule) --}}" method="post">
                {{ csrf_field() }}  
                {{ method_field('PUT') }}   

                <div class="form-group text-center">
                  <input type="hidden" name="schedule_id" required>
                  <input type="time" name="start_at" value="{{--$schedule->id--}}" placeholder="hh:mm am (23:15 am)" pattern="" id="start_at" class="form-control{{ $errors->has('start_at') ? ' is-invalid' : '' }}" required>

                  @if ($errors->has('start_at'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('start_at') }}</strong>
                      </span>
                  @endif

                  <input type="time" name="end_at" value="{{--$schedule->id--}}" placeholder="hh:mm am (23:15 am)" pattern="" id="end_at" class="form-control{{ $errors->has('end_at') ? ' is-invalid' : '' }}" required>

                  @if ($errors->has('end_at'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('end_at') }}</strong>
                      </span>
                  @endif
                </div> 

                <div class="form-group">
                  <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-image"></i> Update Schedule</button>
                </div>
              </form> 
            </div>
          </div>
        </div>
      </div>
      <!-- END - Schedule Update Form-->
    @endif

    <!-- Appointment Form-->
    @if (Auth::id() !== $doctor->user_id)
    <div class="modal" tabindex="-1" role="dialog" id="appointmentForm" style="display:none;" aria-labelledby="appointmentFormLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content px-0 pb-0 shadow-none">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
            <span aria-hidden="true">&times;</span>
          </button>
          <br>
          <div class="modal-body">

            @include('appointments.partials.form')
            {{-- <appointment-form :doctor="{{$doctor}}"></appointment-form> --}}

          </div>
        </div>
      </div>
    </div>
    @endif
    <!-- END - Appointment Form-->