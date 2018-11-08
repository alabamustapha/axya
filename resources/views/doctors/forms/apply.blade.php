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

        <div class="form-group">
            <label for="workplace" class="tf-flex">
                <span>{{ __('Present WorkPlace') }}</span>
                <small class="red">required</small>
            </label>

            <input id="workplace" type="text" class="form-control{{ $errors->has('workplace') ? ' is-invalid' : '' }}" name="workplace" value="{{ old('workplace') }}" placeholder="name, state, country" required>

            @if ($errors->has('workplace'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('workplace') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="workplace2" class="tf-flex">
                <span>{{ __('Previous WorkPlace') }}</span>
            </label>

            <input id="workplace2" type="text" class="form-control{{ $errors->has('workplace2') ? ' is-invalid' : '' }}" name="workplace2" value="{{ old('workplace2') }}" placeholder="name, state, country" required>

            @if ($errors->has('workplace2'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('workplace2') }}</strong>
                </span>
            @endif
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
                <span>{{ __('Medical School Certificate') }}</span>
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

        <div class="form-group">
            <label for="association_certificate" class="tf-flex">
                <span>{{ __('Relevant Medical Association Certificate') }}</span>
                <small>(Image, PDF) <span class="red">required</span></small>
            </label>

            <input id="association_certificate" type="file" class="form-control{{ $errors->has('association_certificate') ? ' is-invalid' : '' }}" name="association_certificate" value="{{ old('association_certificate') }}" accept="application/pdf, image/png, image/jpeg" required>

            @if ($errors->has('association_certificate'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('association_certificate') }}</strong>
                </span>
            @endif
        </div> 

        <div class="form-group">
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