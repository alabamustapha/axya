<form method="POST" action="{{ route('applications.store') }}" enctype="multipart/form-data">
    @csrf
    
    <div class="card text-center shadow mb-4">
      <div class="card-header">
        <div class="card-title pt-4">
          <i class="fa fa-user-md"></i> Basic Details
        </div>
      </div>

      <div class="card-body">
        <div class="form-group">
            <label for="name" class="tf-flex">{{ __('Name') }}</label>

            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
        </div>

        <div class="form-group" data-toggle="tooltip" title="">
            <label for="specialties" class="tf-flex">
                <span>{{ __('Specialty') }}</span>
                <small title="required" class="red">**</small>
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

        

        <div class="form-group">
            <label for="region_id" class="tf-flex">
                <span>{{ __('Location') }}</span>
            </label>
            <div class="card border-secondary">
                <div class="card-body bg-transparent shadow-none">

                    <div class="row">
                        <div class="col-sm-6">
                            <label for="region_id" class="tf-flex">
                                <small style="size:10px;">{{ __('Region') }}</small>
                                <small title="required" class="red">**</small>
                            </label>

                            <select name="region_id" id="region_id" class="form-control{{ $errors->has('region_id') ? ' is-invalid' : '' }}" required>
                                <option value="">Select Region</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>

                            @if ($errors->has('region_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('region_id') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <label for="city_id" class="tf-flex">
                                <small style="size:10px;">{{ __('City') }}</small>
                                <small title="required" class="red">**</small>
                            </label>

                            <select name="city_id" id="city_id" class="form-control{{ $errors->has('city_id') ? ' is-invalid' : '' }}" required>
                                <option value="">Select City</option>
                            </select>

                            @if ($errors->has('city_id'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('city_id') }}</strong>
                                </span>
                            @endif                 
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>



    <div class="card text-center shadow mb-4">
      <div class="card-header">
        <div class="card-title pt-4">
          <i class="fa fa-hospital-alt"></i> Work Experience
        </div>
      </div>

      <div class="card-body">
        <div class="form-group">
            <label for="datepicker" class="tf-flex">
                <span>{{ __('Date You Started Work') }}
                    <small class="text-muted">(First Appointment)</small>
                </span>
                <small title="required" class="red">**</small>
            </label>

            <input 
                id="datepicker" id="first_appointment" 
                type="text{{-- date --}}" 
                class="form-control{{ $errors->has('first_appointment') ? ' is-invalid' : '' }}" 
                name="first_appointment" 
                value="{{ old('first_appointment') }}" 
                placeholder="select date" 
                required
                autocomplete="off"
            >

            @if ($errors->has('first_appointment'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('first_appointment') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="workplace" class="tf-flex">
                <span>{{ __('Current Work Details') }}</span>
            </label>
            <div class="card border-secondary">
                <div class="card-body bg-transparent shadow-none">
                    <label for="workplace" class="tf-flex">
                        <small style="size:10px;">{{ __('Name') }}</small>
                        <small title="required" class="red">**</small>
                    </label>

                    <input id="workplace" type="text" class="form-control{{ $errors->has('workplace') ? ' is-invalid' : '' }}" name="workplace" value="{{ old('workplace') }}" placeholder="name of hospital, clinic..." required>

                    @if ($errors->has('workplace'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('workplace') }}</strong>
                        </span>
                    @endif

                    <div class="row">
                        <div class="col-sm-6 mt-3">
                            <label for="workplace_address" class="tf-flex">
                                <small style="size:10px;">{{ __('Address') }}</small>
                                <small title="required" class="red">**</small>
                            </label>
                            <input id="workplace_address" type="text" class="form-control{{ $errors->has('workplace_address') ? ' is-invalid' : '' }}" name="workplace_address" value="{{ old('workplace_address') }}" placeholder="eg state, country" required>

                            @if ($errors->has('workplace_address'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('workplace_address') }}</strong>
                                </span>
                            @endif                    
                        </div>
                        <div class="col-sm-6 mt-3">
                            <label for="datepicker2" class="tf-flex">
                                <small style="size:10px;">{{ __('Date Started') }}</small>
                                <small title="required" class="red">**</small>
                            </label>
                            <input 
                                id="datepicker2" id="workplace_start" 
                                type="text{{-- date --}}" 
                                class="form-control{{ $errors->has('workplace_start') ? ' is-invalid' : '' }}"
                                name="workplace_start" 
                                value="{{ old('workplace_start') }}" 
                                placeholder="select date" 
                                required
                                autocomplete="off">

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


    <div class="card text-center shadow mb-4">
      <div class="card-header">
        <div class="card-title">
          <i class="fa fa-certificate"></i> Certifications
        </div>
      </div>

      <div class="card-body">

        <div class="form-group">
            <div class="card border-secondary">
                <label for="medical_college" class="text-left pt-3 px-3 pb-0">
                    <span>{{ __('Medical College Practice Certificate') }}</span>
                </label>

                <div class="card-body bg-transparent shadow-none pb-0">
                    <div class="form-group row">
                        <div class="col-sm-6">
                            <label for="medical_college" class="tf-flex">
                                <small>{{ __('Certificate') }}</small>
                                <small> (pdf) <span title="required" class="red">**</span></small>
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
                        <div class="col-sm-6">
                            <label for="datepicker3" class="tf-flex">
                                <small>{{ __('Expiry Date') }}</small>
                                <small title="required" class="red">**</small>
                            </label>
                            <input 
                                id="datepicker3" id="medical_college_expiry" 
                                type="text{{-- date --}}" 
                                class="form-control{{ $errors->has('medical_college_expiry') ? ' is-invalid' : '' }}" 
                                name="medical_college_expiry" v
                                alue="{{ old('medical_college_expiry') }}"  
                                placeholder="select date" 
                                required
                                autocomplete="off"
                            >

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

        <div class="form-group mt-4 border border-secondary p-3 rounded">
            <label for="specialist_diploma" class="tf-flex mb-3">
                <span>{{ __('Specialist Diploma') }}</span>
                <small>(pdf) <span title="required" class="red">**</span></small>
            </label>

            <input id="specialist_diploma" type="file" class="form-control{{ $errors->has('specialist_diploma') ? ' is-invalid' : '' }}" name="specialist_diploma" value="{{ old('specialist_diploma') }}" accept="application/pdf" required>

            @if ($errors->has('specialist_diploma'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('specialist_diploma') }}</strong>
                </span>
            @endif
        </div> 

        <div class="form-group mt-4 border border-secondary p-3 rounded">
            <label for="competences" class="tf-flex mb-3">
                <span>{{ __('Competences Certificate') }}</span>
                <small>(pdf) <span title="required" class="red">**</span></small>
            </label>

            <input id="competences" type="file" class="form-control{{ $errors->has('competences') ? ' is-invalid' : '' }}" name="competences" value="{{ old('competences') }}" accept="application/pdf" required>

            @if ($errors->has('competences'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('competences') }}</strong>
                </span>
            @endif
        </div> 

        <div class="form-group mt-4 border border-secondary p-3 rounded">
            <label for="malpraxis" class="tf-flex mb-3">
                <span>{{ __('Malpraxis Insurance') }}</span>
                <small>(pdf) <span title="required" class="red">**</span></small>
            </label>

            <input id="malpraxis" type="file" class="form-control{{ $errors->has('malpraxis') ? ' is-invalid' : '' }}" name="malpraxis" value="{{ old('malpraxis') }}" accept="application/pdf" required>

            @if ($errors->has('malpraxis'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('malpraxis') }}</strong>
                </span>
            @endif
        </div> 
        {{-- 
            <div class="form-group mt-4 border border-secondary p-3 rounded">
                <label for="other_certificates" class="tf-flex">
                    <span>{{ __('Other Relevant Certificate(s)') }}</span>
                    <small>(pdf) <span class="teal">multiple files allowed</span></small>
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
        <small class="text-sm">
            <ul class="text-left">
                <li>All details and documents must be correct and valid!</li>
                <li>If your application is rejected, <b class="red">you may only re-apply one week after the rejection date</b>.</li>
                <li>Kindly supply appropriate details once.</li>
            </ul>
        </small>
      </div>
    </div> 

    <div class="form-group mb-4">
        <button type="submit" class="btn btn-primary btn-block" onclick="return confirm('All details and documents are correct and valid?');">
            {{ __('Submit Application') }}
        </button>
    </div>
</form>