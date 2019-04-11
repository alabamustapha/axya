@if ($user->isAccountOwner())
        <div class="modal fade" tabindex="-1" role="dialog" id="updateUserProfileForm" style="display:none;" aria-labelledby="updateUserProfileFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">

                @include('users.forms.edit')

              </div> <!-- modal-body -->    
            </div> <!-- modal-content -->    
          </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="updateAllergyProfileForm" style="display:none;" aria-labelledby="updateAllergyProfileFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">

                @include('users.forms.allergies')

              </div> <!-- modal-body -->    
            </div> <!-- modal-content -->    
          </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="updateChronicsProfileForm" style="display:none;" aria-labelledby="updateChronicsProfileFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">

                @include('users.forms.chronics-form')

              </div> <!-- modal-body -->    
            </div> <!-- modal-content -->    
          </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="updatePasswordForm" style="display:none;" aria-labelledby="updatePasswordFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">

                @include('users.forms.password-form')

              </div> <!-- modal-body -->    
            </div> <!-- modal-content -->    
          </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="updateAvatarForm" style="display:none;" aria-labelledby="updateAvatarFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content px-3">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">
                <div class="text-center">
                  <img class="img-circle" height="75" src="{{$user->avatar}}" alt="{{$user->name}} profile picture">

                  <div class="form-group text-center">
                    <label for="avatar" class="h6">Update Avatar</label>
                  </div>
                </div>

                <form action="{{route('user.avatar.upload', $user)}}" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}  
                  {{ method_field('PATCH') }}   

                  <div class="form-group text-center">
                    <input type="hidden" name="resize" value="true">
                    <input type="hidden" name="caption" value="{{ auth()->user()->name }}'s profile avatar">
                    <input type="file" name="uploadFile[]" id="uploadFile" class="form-control{{ $errors->has('uploadFile') ? ' is-invalid' : '' }}" accept="image/*" required>

                    @if ($errors->has('uploadFile'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('uploadFile') }}</strong>
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