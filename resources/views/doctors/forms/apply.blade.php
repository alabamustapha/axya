<form method="POST" action="{{-- route('apply') --}}" enctype="multipart/form-data">
    @csrf

    <div class="form-group h1 text-center">
        Doctor's Application
    </div>

    <div class="card card-primary card-outline text-center shadow mb-4">
      <div class="card-header">
        <div class="card-title">
          <i class="fa fa-user-md"></i> Basic Details
        </div>
      </div>

      <div class="card-body">
        <div class="form-group">
            <label for="name" class="tf-flex">{{ __('Name') }}</label>

            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
        </div>

        <div class="form-group" data-toggle="tooltip" title="Choose a specialty close to yours if your specialty is not available yet, as a medical doctor on this platform, you can add it if your application is successful and then update your profile.">
            <label for="specialties" class="tf-flex">
                <span>{{ __('Specialty') }}</span>
                <small class="red">required</small>
            </label>

            <select id="specialties" class="form-control{{ $errors->has('specialties') ? ' is-invalid' : '' }}" name="specialties[]" {{-- multiple --}} required autofocus>
                <option value="">Select Specialty</option>
                @foreach ($specialties as $specialty)
                    <option value="{{$specialty->id}}" {{old('specialties') == $specialty->id ? 'selected':''}}>{{$specialty->name}}</option>
                @endforeach
            </select>

            @if ($errors->has('specialties'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('specialties') }}</strong>
                </span>
            @endif
        </div>
      </div>

      <div class="card-footer">
        <small class="text-muted">Your specialty is not in the list yet? Choose anyone close, however verified medical doctors on this platform has privelege to add specialties, add it when your application is successful and then update your profile.</small>
      </div>
    </div>



    <div class="card card-primary card-outline text-center shadow mb-4">
      <div class="card-header">
        <div class="card-title">
          <i class="fa fa-hospital-alt"></i> Work Experience
        </div>
      </div>

      <div class="card-body">
        <div class="form-group">
            <label for="first_appointment" class="tf-flex">
                <span>{{ __('Date of First Appointment') }}</span>
                <small class="red">required</small>
            </label>

            <input id="first_appointment" type="date" class="form-control{{ $errors->has('first_appointment') ? ' is-invalid' : '' }}" name="first_appointment" value="{{ old('first_appointment') }}" placeholder="yyyy-mm-dd" required>

            @if ($errors->has('first_appointment'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('first_appointment') }}</strong>
                </span>
            @endif
        </div>

        <div class="card border-secondary">
            <div class="card-body bg-transparent shadow-none">
                <div class="form-group">
                    <label for="workplace" class="tf-flex">
                        <span>{{ __('Present WorkPlace') }}</span>
                        <small class="red">required</small>
                    </label>

                    <input id="workplace" type="text" class="form-control{{ $errors->has('workplace') ? ' is-invalid' : '' }}" name="workplace" value="{{ old('workplace') }}" placeholder="name of hospital" required>

                    @if ($errors->has('workplace'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('workplace') }}</strong>
                        </span>
                    @endif

                    <div class="row">
                        <div class="col-sm-6 mt-3">
                            <label for="workplace" class="tf-flex">
                                <span>{{ __('Address') }}</span>
                                <small class="red">required</small>
                            </label>
                            <input id="workplace_address" type="text" class="form-control{{ $errors->has('workplace_address') ? ' is-invalid' : '' }}" name="workplace_address" value="{{ old('workplace_address') }}" placeholder="eg state, country" required>

                            @if ($errors->has('workplace_address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('workplace_address') }}</strong>
                                </span>
                            @endif                    
                        </div>
                        <div class="col-sm-6 mt-3">
                            <label for="workplace" class="tf-flex">
                                <span>{{ __('Start Date') }}</span>
                                <small class="red">(yyyy-mm-dd) required</small>
                            </label>
                            <input id="workplace_start" type="date" class="form-control{{ $errors->has('workplace_start') ? ' is-invalid' : '' }}" name="workplace_start" value="{{ old('workplace_start') }}" placeholder="name, state, country" required>

                            @if ($errors->has('workplace_start'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('workplace_start') }}</strong>
                                </span>
                            @endif                    
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-secondary">
            <div class="card-body bg-transparent shadow-none">
                <div class="form-group">
                    <label for="workplace2" class="tf-flex">
                        <span>{{ __('Previous WorkPlace') }}</span>
                    </label>

                    <input id="workplace2" type="text" class="form-control{{ $errors->has('workplace2') ? ' is-invalid' : '' }}" name="workplace2" value="{{ old('workplace2') }}" placeholder="name of hospital">

                    @if ($errors->has('workplace2'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('workplace2') }}</strong>
                        </span>
                    @endif

                    <div class="form-grou">
                        <label for="workplace2_address" class="tf-flex">
                            <span>{{ __('Address') }}</span>
                        </label>
                        <input id="workplace2_address" type="text" class="form-control{{ $errors->has('workplace2_address') ? ' is-invalid' : '' }}" name="workplace2_address" value="{{ old('workplace2_address') }}" placeholder="eg state, country">

                        @if ($errors->has('workplace2_address'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('workplace2_address') }}</strong>
                            </span>
                        @endif                    
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mt-3">
                            <label for="workplace2_start" class="tf-flex">
                                <span>{{ __('Start Date') }}</span>
                            </label>
                            <input id="workplace2_start" type="date" class="form-control{{ $errors->has('workplace2_start') ? ' is-invalid' : '' }}" name="workplace2_start" value="{{ old('workplace2_start') }}">

                            @if ($errors->has('workplace2_start'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('workplace2_start') }}</strong>
                                </span>
                            @endif                    
                        </div>
                        <div class="col-sm-6 mt-3">
                            <label for="workplace2_end" class="tf-flex">
                                <span>{{ __('End Date') }}</span>
                            </label>
                            <input id="workplace2_end" type="date" class="form-control{{ $errors->has('workplace2_end') ? ' is-invalid' : '' }}" name="workplace2_end" value="{{ old('workplace2_end') }}">

                            @if ($errors->has('workplace2_end'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('workplace2_end') }}</strong>
                                </span>
                            @endif                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>


    <div class="card card-primary card-outline text-center shadow mb-4">
      <div class="card-header">
        <div class="card-title">
          <i class="fa fa-certificate"></i> Certifications
        </div>
      </div>

      <div class="card-body">
        <div class="form-group">
            <label for="medical_certificate" class="tf-flex">
                <span>{{ __('Medical College Practice Certificate') }}</span>
                <small> (Image, PDF) <span class="red">required</span></small>
            </label>

            <div class="">
                <input id="medical_certificate" type="file" class="form-control{{ $errors->has('medical_certificate') ? ' is-invalid' : '' }}" name="medical_certificate" value="{{ old('medical_certificate') }}" placeholder="Medical school certificate" accept="application/pdf, image/png, image/jpeg" required>

                @if ($errors->has('medical_certificate'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('medical_certificate') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="form-group mt-4">
            <label for="specialist_diploma" class="tf-flex">
                <span>{{ __('Specialist Diploma') }}</span>
                <small>(Image, PDF) <span class="red">required</span></small>
            </label>

            <input id="specialist_diploma" type="file" class="form-control{{ $errors->has('specialist_diploma') ? ' is-invalid' : '' }}" name="specialist_diploma" value="{{ old('specialist_diploma') }}" accept="application/pdf, image/png, image/jpeg" required>

            @if ($errors->has('specialist_diploma'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('specialist_diploma') }}</strong>
                </span>
            @endif
        </div> 

        <div class="form-group mt-4">
            <label for="competences" class="tf-flex">
                <span>{{ __('Competences Certificate') }}</span>
                <small>(Image, PDF) <span class="red">required</span></small>
            </label>

            <input id="competences" type="file" class="form-control{{ $errors->has('competences') ? ' is-invalid' : '' }}" name="competences" value="{{ old('competences') }}" accept="application/pdf, image/png, image/jpeg" required>

            @if ($errors->has('competences'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('competences') }}</strong>
                </span>
            @endif
        </div> 

        <div class="form-group mt-4">
            <label for="malpraxis" class="tf-flex">
                <span>{{ __('Malpraxis Insurance') }}</span>
                <small>(Image, PDF) <span class="red">required</span></small>
            </label>

            <input id="malpraxis" type="file" class="form-control{{ $errors->has('malpraxis') ? ' is-invalid' : '' }}" name="malpraxis" value="{{ old('malpraxis') }}" accept="application/pdf, image/png, image/jpeg" required>

            @if ($errors->has('malpraxis'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('malpraxis') }}</strong>
                </span>
            @endif
        </div> 

        <div class="form-group mt-4">
            <label for="other_certificates" class="tf-flex">
                <span>{{ __('Other Relevant Certificate(s)') }}</span>
                <small>(Image, PDF) <span class="teal">multiple files allowed</span></small>
            </label>

            <input id="other_certificates" type="file" class="form-control{{ $errors->has('other_certificates') ? ' is-invalid' : '' }}" name="other_certificates[]" value="{{ old('other_certificates') }}" accept="application/pdf, image/png, image/jpeg" multiple>

            @if ($errors->has('other_certificates'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('other_certificates') }}</strong>
                </span>
            @endif
        </div> 
      </div>
    </div> 

    <div class="form-group mb-4">
        <button type="submit" class="btn btn-primary btn-block">
            {{ __('Submit Application') }}
        </button>
    </div>
</form>