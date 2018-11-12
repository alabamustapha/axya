<form method="POST" action="{{ route('applications.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group card shadow text-center">
        <div class="card-body">
            <span class="h1">
                <strong><i class="fa fa-user-md"></i>&nbsp; Doctor's Application</strong>
            </span>
            <br>
            Kindly supply all <span class="red">required</span> details and documents with this form.
        </div>
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

            <select id="specialty_id" class="form-control{{ $errors->has('specialty_id') ? ' is-invalid' : '' }}" name="specialty_id[]" {{-- multiple --}} required autofocus>
                <option value="">Select Specialty</option>
                @foreach ($specialties as $specialty)
                    <option value="{{$specialty->id}}" 
                        {{
                            old('specialty_id') 
                                ? (in_array($specialty->id, old('specialty_id')) ? 'selected':'')
                                :''
                        }}>{{$specialty->name}}</option>
                @endforeach
            </select>

            @if ($errors->has('specialty_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('specialty_id') }}</strong>
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
                <span>{{ __('Date You Started Work (First Appointment)') }}</span>
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
            </label>
            <div class="card border-secondary">
                <div class="card-body bg-transparent shadow-none">
                    <label for="workplace" class="tf-flex">
                        <small style="size:10px;">{{ __('Name of Hospital') }}</small>
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
                            <label for="workplace_address" class="tf-flex">
                                <small style="size:10px;">{{ __('Address') }}</small>
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
                            <label for="workplace_start" class="tf-flex">
                                <small style="size:10px;">{{ __('Date Started') }}</small>
                                <small class="red">(yyyy-mm-dd) required</small>
                            </label>
                            <input id="workplace_start" type="date" class="form-control{{ $errors->has('workplace_start') ? ' is-invalid' : '' }}" name="workplace_start" value="{{ old('workplace_start') }}" placeholder="yyyy-mm-dd" required>

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
            <label for="medical_college" class="tf-flex">
                <span>{{ __('Medical College Practice Certificate') }}</span>
            </label>
            <div class="card border-secondary">
                <div class="card-body bg-transparent shadow-none">
                    <div class="form-group row">
                        <div class="col-sm-7">
                            <label for="medical_college" class="tf-flex">
                                <small>{{ __('Certificate') }}</small>
                                <small> (PDF) <span class="red">required</span></small>
                            </label>

                            <div class="">
                                <input id="medical_college" type="file" class="form-control{{ $errors->has('medical_college') ? ' is-invalid' : '' }}" name="medical_college" value="{{ old('medical_college') }}" placeholder="Medical school certificate" accept="application/pdf" required>

                                @if ($errors->has('medical_college'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('medical_college') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <label for="medical_college_expiry" class="tf-flex">
                                <small>{{ __('Expiry Date') }}</small>
                                <small class="red">required</small>
                            </label>
                            <input id="medical_college_expiry" type="date" class="form-control{{ $errors->has('medical_college_expiry') ? ' is-invalid' : '' }}" name="medical_college_expiry" value="{{ old('medical_college_expiry') }}"  placeholder="yyyy-mm-dd" required>

                            @if ($errors->has('medical_college_expiry'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('medical_college_expiry') }}</strong>
                                </span>
                            @endif                    
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mt-4">
            <label for="specialist_diploma" class="tf-flex">
                <span>{{ __('Specialist Diploma') }}</span>
                <small>(PDF) <span class="red">required</span></small>
            </label>

            <input id="specialist_diploma" type="file" class="form-control{{ $errors->has('specialist_diploma') ? ' is-invalid' : '' }}" name="specialist_diploma" value="{{ old('specialist_diploma') }}" accept="application/pdf" required>

            @if ($errors->has('specialist_diploma'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('specialist_diploma') }}</strong>
                </span>
            @endif
        </div> 

        <div class="form-group mt-4">
            <label for="competences" class="tf-flex">
                <span>{{ __('Competences Certificate') }}</span>
                <small>(PDF) <span class="red">required</span></small>
            </label>

            <input id="competences" type="file" class="form-control{{ $errors->has('competences') ? ' is-invalid' : '' }}" name="competences" value="{{ old('competences') }}" accept="application/pdf" required>

            @if ($errors->has('competences'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('competences') }}</strong>
                </span>
            @endif
        </div> 

        <div class="form-group mt-4">
            <label for="malpraxis" class="tf-flex">
                <span>{{ __('Malpraxis Insurance') }}</span>
                <small>(PDF) <span class="red">required</span></small>
            </label>

            <input id="malpraxis" type="file" class="form-control{{ $errors->has('malpraxis') ? ' is-invalid' : '' }}" name="malpraxis" value="{{ old('malpraxis') }}" accept="application/pdf" required>

            @if ($errors->has('malpraxis'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('malpraxis') }}</strong>
                </span>
            @endif
        </div> 
        {{-- 
            <div class="form-group mt-4">
                <label for="other_certificates" class="tf-flex">
                    <span>{{ __('Other Relevant Certificate(s)') }}</span>
                    <small>(PDF) <span class="teal">multiple files allowed</span></small>
                </label>

                <input id="other_certificates" type="file" class="form-control{{ $errors->has('other_certificates') ? ' is-invalid' : '' }}" name="other_certificates[]" value="{{ old('other_certificates') }}" accept="application/pdf" multiple>

                @if ($errors->has('other_certificates'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('other_certificates') }}</strong>
                    </span>
                @endif
            </div>
        --}}
      </div>
      <div class="card-footer">
            <small>All details and documents must be correct and valid! <br>
              If your application is rejected, <b class="red">you may only re-apply one week after the rejection date</b>. Kindly supply appropriate details once.
            </small>
      </div>
    </div> 

    <div class="form-group mb-4">
        <button type="submit" class="btn btn-primary btn-block" onclick="return confirm('All details and documents are correct and valid?');">
            {{ __('Submit Application') }}
        </button>
    </div>
</form>