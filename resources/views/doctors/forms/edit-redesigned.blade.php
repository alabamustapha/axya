<!-- PAGE CONTENT -->
<main>
    <!-- Start section -->
    <section id="doc-form">
        <div class="container">
            <div class="df-container">
                <form action="{{route('doctors.update', $doctor)}}" method="post">
                    @csrf
                    {{method_field('PATCH')}}

                    <!-- form section -->
                    <div class="form-section">
                        <div class="fs-title">
                            <div class="fs-icon">
                                <svg  viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M40 20C40 8.97236 31.0276 0 20 0C8.97236 0 0 8.97236 0 20C0 25.8247 2.50473 31.0749 6.49164 34.7331L6.47273 34.7498L7.12145 35.2967C7.16364 35.3324 7.20945 35.3615 7.25164 35.3964C7.59636 35.6822 7.95345 35.9535 8.31709 36.216C8.43491 36.3011 8.55273 36.3862 8.67273 36.4691C9.06109 36.7367 9.45964 36.9905 9.86691 37.2313C9.95564 37.2836 10.0451 37.3345 10.1345 37.3855C10.5804 37.6393 11.0356 37.8785 11.5018 38.0982C11.536 38.1142 11.5709 38.1287 11.6051 38.1447C13.1244 38.8509 14.7462 39.3695 16.4422 39.6756C16.4865 39.6836 16.5309 39.6916 16.576 39.6996C17.1025 39.7905 17.6349 39.8633 18.1738 39.912C18.2393 39.9178 18.3047 39.9215 18.3709 39.9273C18.9076 39.9716 19.4502 40 20 40C20.5447 40 21.0822 39.9716 21.616 39.9287C21.6836 39.9229 21.7513 39.9193 21.8189 39.9135C22.3535 39.8647 22.8815 39.7942 23.4029 39.7047C23.448 39.6967 23.4938 39.6887 23.5389 39.68C25.2095 39.3804 26.808 38.8735 28.3076 38.1855C28.3629 38.16 28.4189 38.136 28.4742 38.1098C28.9229 37.8989 29.3615 37.6713 29.7913 37.4291C29.8982 37.3687 30.0044 37.3076 30.1105 37.2451C30.5018 37.0145 30.8865 36.7738 31.2604 36.5178C31.3949 36.4262 31.5265 36.3295 31.6596 36.2335C31.9789 36.0036 32.2924 35.7665 32.5971 35.5185C32.6647 35.464 32.7375 35.4167 32.8036 35.3607L33.4691 34.8051L33.4495 34.7884C37.4713 31.1287 40 25.8545 40 20ZM1.45455 20C1.45455 9.77382 9.77382 1.45455 20 1.45455C30.2262 1.45455 38.5455 9.77382 38.5455 20C38.5455 25.5105 36.1273 30.4647 32.2989 33.864C32.0851 33.7164 31.8698 33.584 31.6495 33.4735L25.4916 30.3949C24.9389 30.1185 24.5956 29.5629 24.5956 28.9455V26.7949C24.7382 26.6189 24.8887 26.4196 25.0444 26.2007C25.8415 25.0749 26.4807 23.8225 26.9469 22.4749C27.8684 22.0371 28.4633 21.1193 28.4633 20.0829V17.5047C28.4633 16.8742 28.232 16.2625 27.8182 15.7818V12.3876C27.856 12.0102 27.9898 9.88 26.4487 8.12291C25.1084 6.59273 22.9389 5.81818 20 5.81818C17.0611 5.81818 14.8916 6.59273 13.5513 8.12218C12.0102 9.87927 12.144 12.0095 12.1818 12.3869V15.7811C11.7687 16.2618 11.5367 16.8735 11.5367 17.504V20.0822C11.5367 20.8829 11.896 21.6298 12.5113 22.1338C13.1004 24.4415 14.3127 26.1884 14.7607 26.7804V28.8851C14.7607 29.4785 14.4371 30.024 13.9156 30.3091L8.16509 33.4458C7.98182 33.5455 7.8 33.6618 7.61818 33.792C3.83709 30.3942 1.45455 25.4705 1.45455 20ZM30.8793 35.0051C30.6247 35.1898 30.3658 35.3687 30.1033 35.5396C29.9825 35.6182 29.8625 35.6967 29.7396 35.7731C29.3964 35.9855 29.0473 36.1876 28.6909 36.3767C28.6124 36.4182 28.5331 36.4575 28.4538 36.4982C27.6349 36.9178 26.7876 37.2785 25.9171 37.5716C25.8865 37.5818 25.856 37.5927 25.8247 37.6029C25.3687 37.7542 24.9069 37.8887 24.44 38.0044C24.4385 38.0044 24.4371 38.0051 24.4356 38.0051C23.9644 38.1215 23.4873 38.2182 23.0073 38.2975C22.9942 38.2996 22.9811 38.3025 22.968 38.3047C22.5164 38.3782 22.0611 38.4313 21.6044 38.4713C21.5236 38.4785 21.4429 38.4836 21.3615 38.4895C20.9098 38.5236 20.456 38.5455 20 38.5455C19.5389 38.5455 19.0793 38.5229 18.6218 38.4887C18.5425 38.4829 18.4633 38.4778 18.3847 38.4705C17.9236 38.4298 17.4647 38.3753 17.0102 38.3011C16.9898 38.2975 16.9695 38.2938 16.9491 38.2902C15.9876 38.1295 15.0415 37.8931 14.12 37.584C14.0916 37.5745 14.0625 37.5644 14.0342 37.5549C13.5767 37.3993 13.1244 37.2269 12.68 37.0364C12.6771 37.0349 12.6735 37.0335 12.6705 37.032C12.2502 36.8509 11.8378 36.6502 11.4305 36.4385C11.3775 36.4109 11.3236 36.3847 11.2713 36.3564C10.8996 36.1578 10.536 35.9433 10.1775 35.7193C10.0713 35.6524 9.96582 35.5847 9.86109 35.5164C9.53091 35.3004 9.20509 35.0756 8.888 34.8378C8.85527 34.8131 8.824 34.7869 8.79127 34.7622C8.81455 34.7491 8.83782 34.736 8.86109 34.7229L14.6116 31.5862C15.6007 31.0465 16.2153 30.0116 16.2153 28.8851L16.2145 26.2655L16.0473 26.0633C16.0313 26.0451 14.4589 24.1324 13.8647 21.5425L13.7985 21.2545L13.5505 21.0938C13.2007 20.8676 12.9913 20.4895 12.9913 20.0815V17.5033C12.9913 17.1651 13.1345 16.8502 13.3964 16.6138L13.6364 16.3971V12.3462L13.6298 12.2509C13.6276 12.2335 13.4131 10.4844 14.6451 9.08C15.6967 7.88145 17.4989 7.27273 20 7.27273C22.4916 7.27273 24.288 7.87636 25.3425 9.06618C26.5731 10.456 26.3716 12.2378 26.3702 12.2524L26.3636 16.3985L26.6036 16.6153C26.8647 16.8509 27.0087 17.1665 27.0087 17.5047V20.0829C27.0087 20.6015 26.656 21.072 26.1498 21.2284L25.7884 21.3396L25.672 21.6996C25.2429 23.0327 24.632 24.264 23.8567 25.3593C23.6662 25.6284 23.4807 25.8669 23.3215 26.0495L23.1411 26.2553V28.9455C23.1411 30.1178 23.7927 31.1724 24.8415 31.696L30.9993 34.7745C31.0385 34.7942 31.0771 34.8145 31.1156 34.8349C31.0378 34.8938 30.9578 34.9484 30.8793 35.0051Z"
                                        fill="black" />
                                </svg>

                            </div>
                            <span>Profile</span>
                        </div>
                        <div class="fs-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="fname">Name</label>

                                        <input type="text" class="form-control" value="{{$doctor->name}}" readonly>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="username">Email</label>

                                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') ?: $doctor->email }}" placeholder="johndoe@example.com" required>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif                                            
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>

                                        <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') ?: $doctor->phone }}">

                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                
                                    </div>
                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        <label for="available">{{ __('Availability for Appointments') }}</label>

                                        <div>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="available" id="available" value="1" 
                                              {{(old('available') == '1' || $doctor->available == '1') ? 'checked':''}}>
                                            <label class="form-check-label text-success" for="available">Available</label>
                                          </div>
                                          <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="available" id="unavailable" value="0" 
                                              {{(old('available') == '0' || $doctor->available == '0') ? 'checked':''}}>
                                            <label class="form-check-label text-danger" for="unavailable">Not Available</label>
                                          </div>

                                          @if ($errors->has('available'))
                                              <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $errors->first('available') }}</strong>
                                              </span>
                                          @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col">
                                    <label for="about">{{ __('About You') }}</label>

                                    <textarea id="about" class="form-control{{ $errors->has('about') ? ' is-invalid' : '' }}" 
                                      maxlength="1500" style="max-height: 150px;height: 150px;"
                                      name="about" placeholder="write about your specialization, expertise and work history etc"
                                      >{{ old('about') ?: $doctor->about }}</textarea>

                                    @if ($errors->has('about'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('about') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- form section end -->

                    <!-- form section -->
                    <div class="form-section">
                        <div class="fs-title">
                            <div class="fs-icon">
                                <svg viewBox="0 0 38 45" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M30.875 18.75H11.0833C10.6463 18.75 10.2916 19.0853 10.2916 19.5C10.2916 19.9147 10.6463 20.25 11.0833 20.25H30.875C31.312 20.25 31.6666 19.9147 31.6666 19.5C31.6666 19.0853 31.312 18.75 30.875 18.75Z"
                                        fill="black" />
                                    <path d="M11.0833 14.25H19C19.437 14.25 19.7916 13.9147 19.7916 13.5C19.7916 13.0853 19.437 12.75 19 12.75H11.0833C10.6463 12.75 10.2916 13.0853 10.2916 13.5C10.2916 13.9147 10.6463 14.25 11.0833 14.25Z"
                                        fill="black" />
                                    <path d="M30.875 24.75H11.0833C10.6463 24.75 10.2916 25.0853 10.2916 25.5C10.2916 25.9147 10.6463 26.25 11.0833 26.25H30.875C31.312 26.25 31.6666 25.9147 31.6666 25.5C31.6666 25.0853 31.312 24.75 30.875 24.75Z"
                                        fill="black" />
                                    <path d="M30.875 30.75H11.0833C10.6463 30.75 10.2916 31.0853 10.2916 31.5C10.2916 31.9147 10.6463 32.25 11.0833 32.25H30.875C31.312 32.25 31.6666 31.9147 31.6666 31.5C31.6666 31.0853 31.312 30.75 30.875 30.75Z"
                                        fill="black" />
                                    <path d="M30.875 36.75H11.0833C10.6463 36.75 10.2916 37.0853 10.2916 37.5C10.2916 37.9147 10.6463 38.25 11.0833 38.25H30.875C31.312 38.25 31.6666 37.9147 31.6666 37.5C31.6666 37.0853 31.312 36.75 30.875 36.75Z"
                                        fill="black" />
                                    <path d="M34.0417 10.9395V0H0V41.25H3.95833V45H38V14.6895L34.0417 10.9395ZM26.9167 6.3105L34.0417 13.0605L35.2972 14.25H26.9167V6.3105ZM1.58333 39.75V1.5H32.4583V9.4395L26.4528 3.75H3.95833V39.75H1.58333ZM5.54167 43.5V41.25V5.25H25.3333V15.75H36.4167V43.5H5.54167Z"
                                        fill="black" />
                                </svg>
                            </div>
                            <span>Education</span>
                        </div>
                        <div class="fs-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="graduate_school">School</label>
                                        <input id="graduate_school" type="tel" class="form-control{{ $errors->has('graduate_school') ? ' is-invalid' : '' }}" name="graduate_school" value="{{ old('graduate_school') ?: $doctor->graduate_school }}" placeholder="Your school">

                                        @if ($errors->has('graduate_school'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('graduate_school') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="degree">Degree</label>
                                        <input id="degree" type="text" class="form-control{{ $errors->has('degree') ? ' is-invalid' : '' }}" name="degree" value="{{ old('degree') ?: $doctor->degree }}" placeholder="Degree attained">

                                        @if ($errors->has('degree'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('degree') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                           <div class="row">
                               <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="residency">Residency</label>

                                        <input id="residency" type="text" class="form-control{{ $errors->has('residency') ? ' is-invalid' : '' }}" name="residency" 
                                            value="{{ old('residency') ?: $doctor->residency }}" placeholder="Your Residence">
                                        @if ($errors->has('residency'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('residency') }}</strong>
                                            </span>
                                        @endif                                    
                                    </div>
                               </div>
                               <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="specialty_id">Speciality</label>

                                        <select id="specialty_id" class="custom-select form-control{{ $errors->has('specialty_id') ? ' is-invalid' : '' }}" name="specialty_id" required>
                                            <option>Select Specialty</option>
                                            @foreach($specialties as $specialty)
                                                <option value="{{$specialty->id}}" 
                                                    {{(old('specialty_id') == $specialty->id || $doctor->specialty_id == $specialty->id) ? 'selected':''}}
                                                    >
                                                    {{$specialty->name}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('specialty_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('specialty_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                               </div>
                           </div>
                        </div>
                    </div>
                    <!-- form section end -->

                    <!-- form section -->
                    <div class="form-section">
                        <div class="fs-title">
                            <div class="fs-icon">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M39.7799 18.252L33.7929 12.7275V3.67686H26.8963V6.36409L19.9997 0L0.220136 18.252C-0.0584876 18.5097 -0.0750394 18.9435 0.184274 19.2211C0.442897 19.498 0.879453 19.5138 1.15946 19.2567L3.44845 17.1445V40H14.483H25.5176H36.5522V17.1438L38.8412 19.2561C38.9736 19.3787 39.1426 19.439 39.3109 19.439C39.4964 19.439 39.6806 19.3657 39.8157 19.2204C40.075 18.9435 40.0585 18.5097 39.7799 18.252ZM28.2756 5.04755H32.4136V11.4548L28.2756 7.63677V5.04755ZM15.8617 38.6293V24.194C15.8617 23.8396 16.1513 23.5518 16.5079 23.5518H23.4914C23.848 23.5518 24.1376 23.8396 24.1376 24.194V38.6293H15.8617ZM35.1722 38.6293H25.517V24.194C25.517 23.0837 24.6087 22.1811 23.4914 22.1811H16.5079C15.3906 22.1811 14.4824 23.0837 14.4824 24.194V38.6293H4.82708V15.8712L19.9997 1.8703L29.848 10.9579L33.7929 14.5978L35.1722 15.8705V38.6293Z"
                                        fill="black" />
                                </svg>


                            </div>
                            <span>Location</span>
                        </div>
                        <div class="fs-body">
                        
                            <div class="form-group">
                                <label for="home_address">Home Address</label>
                                <input id="home_address" type="tel" class="form-control{{ $errors->has('home_address') ? ' is-invalid' : '' }}" name="home_address" value="{{ old('home_address') ?: $doctor->home_address }}" placeholder="Address - Home">

                                @if ($errors->has('home_address'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('home_address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        
                            <div class="form-group">
                                <label for="workplace_id">{{ __('Current Workplace') }}</label>

                                <select id="workplace_id" class="form-control{{ $errors->has('workplace_id') ? ' is-invalid' : '' }}" name="workplace_id" required>
                                    <option value="">Select Workplace</option>
                                    @foreach($workplaces as $workplace)
                                      <option value="{{$workplace->id}}" {{(old('workplace_id') == $workplace->id || $current_workplace->id == $workplace->id) ? 'selected':''}}>{{$workplace->name}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('workplace_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('workplace_id') }}</strong>
                                    </span>
                                @endif
                            </div>
  
                        </div>
                    </div>
                    <!-- form section end -->

                    <!-- form section -->
                    <div class="form-section">
                       
                        <div class="fs-body">
                            <div class="fs-icon">
                            
                                <svg viewBox="0 0 43 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21.5 0C9.62584 0 0 9.62584 0 21.5C0 33.3742 9.62584 43 21.5 43C33.3742 43 43 33.3742 43 21.5C42.9841 9.63248 33.3675 0.0159438 21.5 0ZM16.1854 2.17416C14.0569 4.18018 12.4428 6.66935 11.4796 9.43101C9.87949 9.04244 8.31253 8.52874 6.79303 7.89461C9.32919 5.14925 12.5825 3.16787 16.1854 2.17416ZM5.80742 9.03483C7.48478 9.79385 9.2241 10.4081 11.0061 10.8708C9.99726 14.0775 9.46012 17.4139 9.41168 20.7753V20.7463H1.48809C1.63702 16.4807 3.15096 12.3755 5.80742 9.03483ZM5.80742 33.8879C3.15096 30.5472 1.63702 26.442 1.48809 22.1764L9.41168 22.1957C9.45734 25.5668 9.99448 28.9132 11.0061 32.1292C9.2264 32.5669 7.48731 33.1553 5.80742 33.8879ZM6.79303 35.0861V35.0281C8.31253 34.3938 9.87949 33.8801 11.4796 33.4917C12.4317 36.2811 14.0465 38.7978 16.1854 40.8258C12.5803 39.8267 9.32677 37.8384 6.79303 35.0861ZM20.7753 41.4829C17.5285 41.0674 14.6876 37.9173 12.8807 33.2405C15.4806 32.7171 18.1234 32.4356 20.7753 32.3998V41.4829ZM20.7753 30.8924C17.9602 30.9282 15.155 31.2324 12.3975 31.8007C11.4304 28.6988 10.9161 25.4735 10.8708 22.2247V22.1957H20.7753V30.8924ZM20.7753 20.7463H10.8708C10.9077 17.4683 11.4221 14.2131 12.3975 11.0834C15.153 11.6711 17.9583 11.9947 20.7753 12.0497V20.7463ZM20.7753 10.6002C18.1238 10.5674 15.481 10.2892 12.8807 9.76921C14.6876 5.07303 17.5285 1.93258 20.7753 1.51708V10.6002ZM37.1926 9.09281C39.849 12.4335 41.363 16.5387 41.5119 20.8043H33.5883C33.5446 17.4267 33.0073 14.0737 31.9939 10.8515C33.7736 10.4137 35.5127 9.82538 37.1926 9.09281ZM36.1973 7.91393C34.6778 8.54806 33.1108 9.06177 31.5108 9.45034C30.5531 6.68263 28.9421 4.1867 26.8146 2.17416C30.4162 3.17487 33.6662 5.16302 36.1973 7.91393ZM22.2247 1.51708C25.4715 1.93258 28.3124 5.0827 30.1193 9.75955C27.5194 10.2828 24.8766 10.5642 22.2247 10.6002V1.51708ZM22.2247 12.0497C25.0398 12.0139 27.8452 11.7098 30.6025 11.1413C31.5779 14.271 32.0923 17.5262 32.1292 20.8043H22.2247V12.0497ZM22.2247 22.2537H32.1292C32.0923 25.5317 31.5779 28.7869 30.6025 31.9166C27.847 31.3288 25.0417 31.0053 22.2247 30.9503V22.2537ZM22.2247 41.4829V32.3998C24.8762 32.4325 27.519 32.7107 30.1193 33.2308C28.3124 37.927 25.4715 41.0674 22.2247 41.4829ZM26.8146 40.8258C28.9444 38.817 30.5586 36.3245 31.5204 33.5593C33.1205 33.9478 34.6875 34.4615 36.207 35.0957C33.672 37.8446 30.4186 39.8295 26.8146 40.8258ZM37.1926 33.9652C35.5152 33.2061 33.776 32.5918 31.9939 32.1292C33.0027 28.9225 33.5399 25.5861 33.5883 22.2247V22.2537H41.5119C41.363 26.5193 39.849 30.6245 37.1926 33.9652Z"
                                        fill="black" />
                                </svg>
                            
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="country_id">Country</label>
                                       
                                        <select id="country_id" class="custom-select form-control{{ $errors->has('country_id') ? ' is-invalid' : '' }}" name="country_id" required>
                                            <option>Select Country</option>
                                            <option value="1" {{ (old('country_id') == 1 || $doctor->country_id == 1) ? 'selected' : '' }}>Romania</option>
                                            <option value="2" {{ (old('country_id') == 2 || $doctor->country_id == 2) ? 'selected' : '' }}>Nigeria</option>   
                                        </select>
                                        @if ($errors->has('country_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('country_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="state_id">State</label>

                                        <select id="state_id" class="custom-select form-control{{ $errors->has('state_id') ? ' is-invalid' : '' }}" name="state_id" required>
                                            <option>Select State</option>
                                            <option value="1" {{ (old('state_id') == 1 || $doctor->state_id == 1) ? 'selected' : '' }}>Vrancea</option>
                                            <option value="2" {{ (old('state_id') == 2 || $doctor->state_id == 2) ? 'selected' : '' }}>ancea</option>               
                                        </select>
                                        @if ($errors->has('state_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('state_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- form section end -->

                    <!-- form section -->
                    <div class="form-section">
                       
                        <div class="fs-body">
                            
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                       
                                        <label for="main_language">Language <small>(main)</small></label>
                                        <select id="main_language" class="custom-select form-control{{ $errors->has('main_language') ? ' is-invalid' : '' }}" name="main_language" required>
                                            <option>Select Language</option>
                                            <option value="1" {{ (old('main_language') == 1 || $doctor->main_language == 1) ? 'selected' : '' }}>Romanian</option>
                                            <option value="2" {{ (old('main_language') == 2 || $doctor->main_language == 2) ? 'selected' : '' }}>English</option>
                                           
                                        </select>

                                        @if ($errors->has('main_language'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('main_language') }}</strong>
                                            </span>
                                        @endif                            
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                   
                                    <label for="second_language">Second Language Proficiency</label>
                                        
                                    <div class="custom-control{{ $errors->has('second_language') ? ' is-invalid' : '' }} custom-radio">
                                        <input type="radio" id="second_language1" name="second_language" class="custom-control-input" value="1" {{ (old('second_language') == 1 || $doctor->second_language == 1) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="second_language1">Romanian</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="second_language2" name="second_language" class="custom-control-input" value="2" {{ (old('second_language') == 2 || $doctor->second_language == 2) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="second_language2">English</label>
                                    </div>

                                    @if ($errors->has('second_language'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('second_language') }}</strong>
                                        </span>
                                    @endif                                              
                                </div>
                            </div>
                    
                           
                        </div>
                    </div>
                    <!-- form section end -->

                    <!-- form section -->
                    <div class="form-section">
                    
                        <div class="fs-body">
                            <div class="fs-icon">
                                <svg width="40" height="50" viewBox="0 0 40 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M39.2857 3.33333H34.2857V0.833333C34.2857 0.3725 33.9664 0 33.5714 0H28.5714C28.1764 0 27.8571 0.3725 27.8571 0.833333V3.33333H12.1429V0.833333C12.1429 0.3725 11.8236 0 11.4286 0H6.42857C6.03357 0 5.71429 0.3725 5.71429 0.833333V3.33333H0.714286C0.319286 3.33333 0 3.70583 0 4.16667V13.3333V49.1667C0 49.6275 0.319286 50 0.714286 50H39.2857C39.6807 50 40 49.6275 40 49.1667V13.3333V4.16667C40 3.70583 39.6807 3.33333 39.2857 3.33333ZM29.2857 1.66667H32.8571V4.16667V6.66667H29.2857V4.16667V1.66667ZM7.14286 1.66667H10.7143V4.16667V6.66667H7.14286V4.16667V1.66667ZM1.42857 5H5.71429V7.5C5.71429 7.96083 6.03357 8.33333 6.42857 8.33333H11.4286C11.8236 8.33333 12.1429 7.96083 12.1429 7.5V5H27.8571V7.5C27.8571 7.96083 28.1764 8.33333 28.5714 8.33333H33.5714C33.9664 8.33333 34.2857 7.96083 34.2857 7.5V5H38.5714V12.5H1.42857V5ZM1.42857 48.3333V14.1667H38.5714V48.3333H1.42857Z"
                                        fill="black" />
                                    <path d="M25.7143 19.1667H20.7143H19.2857H14.2857H12.8572H6.42859V26.6667V28.3333V34.1667V35.8333V43.3333H12.8572H14.2857H19.2857H20.7143H25.7143H27.1429H33.5714V35.8333V34.1667V28.3333V26.6667V19.1667H27.1429H25.7143ZM20.7143 20.8333H25.7143V26.6667H20.7143V20.8333ZM25.7143 34.1667H20.7143V28.3333H25.7143V34.1667ZM14.2857 28.3333H19.2857V34.1667H14.2857V28.3333ZM14.2857 20.8333H19.2857V26.6667H14.2857V20.8333ZM7.85716 20.8333H12.8572V26.6667H7.85716V20.8333ZM7.85716 28.3333H12.8572V34.1667H7.85716V28.3333ZM12.8572 41.6667H7.85716V35.8333H12.8572V41.6667ZM19.2857 41.6667H14.2857V35.8333H19.2857V41.6667ZM25.7143 41.6667H20.7143V35.8333H25.7143V41.6667ZM32.1429 41.6667H27.1429V35.8333H32.1429V41.6667ZM32.1429 34.1667H27.1429V28.3333H32.1429V34.1667ZM32.1429 20.8333V26.6667H27.1429V20.8333H32.1429Z"
                                        fill="black" />
                                </svg>

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                    
                                        <label for="school">Schedule</label>
                                        
                    
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        
                                    <input type="text" class="form-control" placeholder="">
                    
                                    </div>
                                </div>
                            </div>
                    
                           
                        </div>
                    </div>
                    <!-- form section end -->

                    <!-- form section -->
                    <div class="form-section">
                        <div class="fs-title">
                            <div class="fs-icon">
                                <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.931 1.40351C19.0717 1.40351 20 2.34807 20 3.50877C20 4.66947 19.0717 5.61404 17.931 5.61404C17.5497 5.61404 17.2414 5.92772 17.2414 6.31579C17.2414 6.70386 17.5497 7.01754 17.931 7.01754C19.8324 7.01754 21.3793 5.44351 21.3793 3.50877C21.3793 1.57404 19.8324 0 17.931 0C17.5497 0 17.2414 0.313684 17.2414 0.701754C17.2414 1.08982 17.5497 1.40351 17.931 1.40351Z"
                                        fill="black" />
                                    <path d="M22.069 1.40351C23.2097 1.40351 24.138 2.34807 24.138 3.50877C24.138 4.66947 23.2097 5.61404 22.069 5.61404C21.6876 5.61404 21.3793 5.92772 21.3793 6.31579C21.3793 6.70386 21.6876 7.01754 22.069 7.01754C23.9704 7.01754 25.5173 5.44351 25.5173 3.50877C25.5173 1.57404 23.9704 0 22.069 0C21.6876 0 21.3793 0.313684 21.3793 0.701754C21.3793 1.08982 21.6876 1.40351 22.069 1.40351Z"
                                        fill="black" />
                                    <path d="M29.5855 2.80702C29.2648 1.20772 27.8724 0 26.2069 0C25.8255 0 25.5172 0.313684 25.5172 0.701754C25.5172 1.08982 25.8255 1.40351 26.2069 1.40351C27.3476 1.40351 28.2759 2.34807 28.2759 3.50877C28.2759 4.66947 27.3476 5.61404 26.2069 5.61404C25.8255 5.61404 25.5172 5.92772 25.5172 6.31579C25.5172 6.70386 25.8255 7.01754 26.2069 7.01754C27.8717 7.01754 29.2648 5.80982 29.5855 4.21053H38.6207V4.91228C38.24 4.91228 37.931 5.22667 37.931 5.61404C37.931 6.0014 38.24 6.31579 38.6207 6.31579V9.12281C38.24 9.12281 37.931 9.43719 37.931 9.82456C37.931 10.2119 38.24 10.5263 38.6207 10.5263V11.2281H1.37931V10.5263C1.76 10.5263 2.06897 10.2119 2.06897 9.82456C2.06897 9.43719 1.76 9.12281 1.37931 9.12281V6.31579C1.76 6.31579 2.06897 6.0014 2.06897 5.61404C2.06897 5.22667 1.76 4.91228 1.37931 4.91228V4.21053H11.0345H13.1034C13.4848 4.21053 13.7931 3.89684 13.7931 3.50877C13.7931 3.1207 13.4848 2.80702 13.1034 2.80702H11.851C12.1366 1.99158 12.8952 1.40351 13.7931 1.40351C14.9338 1.40351 15.8621 2.34807 15.8621 3.50877C15.8621 4.66947 14.9338 5.61404 13.7931 5.61404C13.4117 5.61404 13.1034 5.92772 13.1034 6.31579C13.1034 6.70386 13.4117 7.01754 13.7931 7.01754C15.6945 7.01754 17.2414 5.44351 17.2414 3.50877C17.2414 1.57404 15.6945 0 13.7931 0C12.1283 0 10.7352 1.20772 10.4145 2.80702H0V12.6316V40H40V12.6316V2.80702H29.5855ZM38.6207 38.5965H1.37931V12.6316H38.6207V38.5965Z"
                                        fill="black" />
                                    <path d="M8.47788 21.5488C8.61236 21.6856 8.78891 21.7544 8.96546 21.7544C9.14201 21.7544 9.31857 21.6856 9.45305 21.5488L12.4137 18.5361V34.3859H10.3448C9.96339 34.3859 9.65512 34.6996 9.65512 35.0877C9.65512 35.4758 9.96339 35.7895 10.3448 35.7895H15.862C16.2434 35.7895 16.5517 35.4758 16.5517 35.0877C16.5517 34.6996 16.2434 34.3859 15.862 34.3859H13.793V16.8421C13.793 16.7509 13.7751 16.6596 13.7399 16.574C13.6703 16.4021 13.5358 16.2652 13.3668 16.1944C13.1986 16.1235 13.0089 16.1235 12.8399 16.1944C12.7551 16.2302 12.6786 16.2821 12.6151 16.3466L8.47788 20.5565C8.20822 20.8309 8.20822 21.2744 8.47788 21.5488Z"
                                        fill="black" />
                                    <path d="M20.6897 30.1754C20.6897 33.2709 23.1649 35.7895 26.2069 35.7895C29.249 35.7895 31.7242 33.2709 31.7242 30.1754C31.7242 28.0211 30.5242 26.1488 28.7697 25.2077C30.1276 24.3375 31.0345 22.8028 31.0345 21.0526C31.0345 18.3446 28.8683 16.1404 26.2069 16.1404C23.5456 16.1404 21.3794 18.3446 21.3794 21.0526C21.3794 22.8028 22.2862 24.3375 23.6442 25.2077C21.8897 26.1488 20.6897 28.0211 20.6897 30.1754ZM22.7587 21.0526C22.7587 19.1179 24.3056 17.5439 26.2069 17.5439C28.1083 17.5439 29.6552 19.1179 29.6552 21.0526C29.6552 22.9874 28.1083 24.5614 26.2069 24.5614C24.3056 24.5614 22.7587 22.9874 22.7587 21.0526ZM26.2069 25.9649C28.489 25.9649 30.3449 27.8533 30.3449 30.1754C30.3449 32.4975 28.489 34.386 26.2069 34.386C23.9249 34.386 22.069 32.4975 22.069 30.1754C22.069 27.8533 23.9249 25.9649 26.2069 25.9649Z"
                                        fill="black" />
                                    <path d="M5.51729 6.31579C5.89818 6.31579 6.20695 6.0016 6.20695 5.61404C6.20695 5.22647 5.89818 4.91228 5.51729 4.91228C5.13641 4.91228 4.82764 5.22647 4.82764 5.61404C4.82764 6.0016 5.13641 6.31579 5.51729 6.31579Z"
                                        fill="black" />
                                    <path d="M5.51729 10.5263C5.89818 10.5263 6.20695 10.2121 6.20695 9.82456C6.20695 9.43699 5.89818 9.12281 5.51729 9.12281C5.13641 9.12281 4.82764 9.43699 4.82764 9.82456C4.82764 10.2121 5.13641 10.5263 5.51729 10.5263Z"
                                        fill="black" />
                                    <path d="M3.4482 8.42105C3.82909 8.42105 4.13786 8.10687 4.13786 7.7193C4.13786 7.33173 3.82909 7.01754 3.4482 7.01754C3.06731 7.01754 2.75854 7.33173 2.75854 7.7193C2.75854 8.10687 3.06731 8.42105 3.4482 8.42105Z"
                                        fill="black" />
                                    <path d="M7.58614 8.42105C7.96703 8.42105 8.27579 8.10687 8.27579 7.7193C8.27579 7.33173 7.96703 7.01754 7.58614 7.01754C7.20525 7.01754 6.89648 7.33173 6.89648 7.7193C6.89648 8.10687 7.20525 8.42105 7.58614 8.42105Z"
                                        fill="black" />
                                    <path d="M9.65523 6.31579C10.0361 6.31579 10.3449 6.0016 10.3449 5.61404C10.3449 5.22647 10.0361 4.91228 9.65523 4.91228C9.27435 4.91228 8.96558 5.22647 8.96558 5.61404C8.96558 6.0016 9.27435 6.31579 9.65523 6.31579Z"
                                        fill="black" />
                                    <path d="M9.65523 10.5263C10.0361 10.5263 10.3449 10.2121 10.3449 9.82456C10.3449 9.43699 10.0361 9.12281 9.65523 9.12281C9.27435 9.12281 8.96558 9.43699 8.96558 9.82456C8.96558 10.2121 9.27435 10.5263 9.65523 10.5263Z"
                                        fill="black" />
                                    <path d="M13.7932 10.5263C14.1741 10.5263 14.4828 10.2121 14.4828 9.82456C14.4828 9.43699 14.1741 9.12281 13.7932 9.12281C13.4123 9.12281 13.1035 9.43699 13.1035 9.82456C13.1035 10.2121 13.4123 10.5263 13.7932 10.5263Z"
                                        fill="black" />
                                    <path d="M11.7241 8.42105C12.105 8.42105 12.4137 8.10687 12.4137 7.7193C12.4137 7.33173 12.105 7.01754 11.7241 7.01754C11.3432 7.01754 11.0344 7.33173 11.0344 7.7193C11.0344 8.10687 11.3432 8.42105 11.7241 8.42105Z"
                                        fill="black" />
                                    <path d="M15.862 8.42105C16.2429 8.42105 16.5517 8.10687 16.5517 7.7193C16.5517 7.33173 16.2429 7.01754 15.862 7.01754C15.4811 7.01754 15.1724 7.33173 15.1724 7.7193C15.1724 8.10687 15.4811 8.42105 15.862 8.42105Z"
                                        fill="black" />
                                    <path d="M17.9311 10.5263C18.312 10.5263 18.6208 10.2121 18.6208 9.82456C18.6208 9.43699 18.312 9.12281 17.9311 9.12281C17.5502 9.12281 17.2415 9.43699 17.2415 9.82456C17.2415 10.2121 17.5502 10.5263 17.9311 10.5263Z"
                                        fill="black" />
                                    <path d="M22.069 10.5263C22.4499 10.5263 22.7587 10.2121 22.7587 9.82456C22.7587 9.43699 22.4499 9.12281 22.069 9.12281C21.6882 9.12281 21.3794 9.43699 21.3794 9.82456C21.3794 10.2121 21.6882 10.5263 22.069 10.5263Z"
                                        fill="black" />
                                    <path d="M20 8.42105C20.3808 8.42105 20.6896 8.10687 20.6896 7.7193C20.6896 7.33173 20.3808 7.01754 20 7.01754C19.6191 7.01754 19.3103 7.33173 19.3103 7.7193C19.3103 8.10687 19.6191 8.42105 20 8.42105Z"
                                        fill="black" />
                                    <path d="M24.1379 8.42105C24.5188 8.42105 24.8276 8.10687 24.8276 7.7193C24.8276 7.33173 24.5188 7.01754 24.1379 7.01754C23.757 7.01754 23.4482 7.33173 23.4482 7.7193C23.4482 8.10687 23.757 8.42105 24.1379 8.42105Z"
                                        fill="black" />
                                    <path d="M30.3449 6.31579C30.7258 6.31579 31.0346 6.0016 31.0346 5.61404C31.0346 5.22647 30.7258 4.91228 30.3449 4.91228C29.964 4.91228 29.6553 5.22647 29.6553 5.61404C29.6553 6.0016 29.964 6.31579 30.3449 6.31579Z"
                                        fill="black" />
                                    <path d="M26.207 10.5263C26.5879 10.5263 26.8966 10.2121 26.8966 9.82456C26.8966 9.43699 26.5879 9.12281 26.207 9.12281C25.8261 9.12281 25.5173 9.43699 25.5173 9.82456C25.5173 10.2121 25.8261 10.5263 26.207 10.5263Z"
                                        fill="black" />
                                    <path d="M30.3449 10.5263C30.7258 10.5263 31.0346 10.2121 31.0346 9.82456C31.0346 9.43699 30.7258 9.12281 30.3449 9.12281C29.964 9.12281 29.6553 9.43699 29.6553 9.82456C29.6553 10.2121 29.964 10.5263 30.3449 10.5263Z"
                                        fill="black" />
                                    <path d="M28.2758 8.42105C28.6567 8.42105 28.9655 8.10687 28.9655 7.7193C28.9655 7.33173 28.6567 7.01754 28.2758 7.01754C27.895 7.01754 27.5862 7.33173 27.5862 7.7193C27.5862 8.10687 27.895 8.42105 28.2758 8.42105Z"
                                        fill="black" />
                                    <path d="M32.4138 8.42105C32.7947 8.42105 33.1034 8.10687 33.1034 7.7193C33.1034 7.33173 32.7947 7.01754 32.4138 7.01754C32.0329 7.01754 31.7241 7.33173 31.7241 7.7193C31.7241 8.10687 32.0329 8.42105 32.4138 8.42105Z"
                                        fill="black" />
                                    <path d="M34.4829 6.31579C34.8638 6.31579 35.1725 6.0016 35.1725 5.61404C35.1725 5.22647 34.8638 4.91228 34.4829 4.91228C34.102 4.91228 33.7932 5.22647 33.7932 5.61404C33.7932 6.0016 34.102 6.31579 34.4829 6.31579Z"
                                        fill="black" />
                                    <path d="M34.4829 10.5263C34.8638 10.5263 35.1725 10.2121 35.1725 9.82456C35.1725 9.43699 34.8638 9.12281 34.4829 9.12281C34.102 9.12281 33.7932 9.43699 33.7932 9.82456C33.7932 10.2121 34.102 10.5263 34.4829 10.5263Z"
                                        fill="black" />
                                    <path d="M36.5517 8.42105C36.9326 8.42105 37.2414 8.10687 37.2414 7.7193C37.2414 7.33173 36.9326 7.01754 36.5517 7.01754C36.1708 7.01754 35.8621 7.33173 35.8621 7.7193C35.8621 8.10687 36.1708 8.42105 36.5517 8.42105Z"
                                        fill="black" />
                                </svg>

                            </div>
                            <span>Appointments</span>
                        </div>
                        <div class="fs-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="rate" class="d-block">Cost</label>

                                        <input type="number" name="rate" min="5.00" max="1500.00" step="0.01" 
                                            value="{{ old('rate') ?: $doctor->rate }}" maxlength="7" placeholder="20.50" 
                                            id="rate" class="d-inline-block py-1 px-2 form-control{{ $errors->has('rate') ? ' is-invalid' : '' }}"
                                            required> <span>per hour</span>

                                        @if ($errors->has('rate'))
                                          <span class="invalid-feedback" role="alert">
                                              <strong>{{ $errors->first('rate') }}</strong>
                                          </span>
                                        @endif
                                        {{-- <input type="text" class="d-inline-block py-1 px-2" placeholder=""> <span>per hour</span> --}}
                            
                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="session">Session Length <small>(minutes)</small></label>
                                        <input type="number" name="session" min="10" max="600" class="form-control"value="{{ old('rate') ?: $doctor->session }}"  placeholder="30">
                            
                                    </div>

                                    @if ($errors->has('session'))
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $errors->first('session') }}</strong>
                                      </span>
                                    @endif

                                </div>
                            </div>
                    
                            
                    
                        </div>
                    </div>
                    <!-- form section end -->

                    <!-- form section -->
                    <div class="form-section">
                        <div class="fs-title">
                            <div class="fs-icon">
                                <svg  viewBox="0 0 50 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M26.6584 24.2857H39.9875C40.4873 24.2857 40.8205 24 40.8205 23.5715V17.1429C40.8205 16.7143 40.4873 16.4286 39.9875 16.4286H26.6584C26.1585 16.4286 25.8253 16.7143 25.8253 17.1429V23.5715C25.8252 23.9999 26.1585 24.2857 26.6584 24.2857ZM27.4914 17.8571H39.1545V22.8571H27.4914V17.8571Z"
                                        fill="black" />
                                    <path d="M4.16538 14.9999H10.83C11.3298 14.9999 11.663 14.7142 11.663 14.2857C11.663 13.8571 11.3298 13.5714 10.83 13.5714H4.16538C3.66553 13.5714 3.33234 13.8571 3.33234 14.2857C3.33234 14.7142 3.66553 14.9999 4.16538 14.9999Z"
                                        fill="black" />
                                    <path d="M14.1623 14.9999H20.8269C21.3267 14.9999 21.6599 14.7142 21.6599 14.2857C21.6599 13.8571 21.3267 13.5714 20.8269 13.5714H14.1623C13.6624 13.5714 13.3292 13.8571 13.3292 14.2857C13.3292 14.7142 13.6624 14.9999 14.1623 14.9999Z"
                                        fill="black" />
                                    <path d="M4.16538 17.8571H14.9953C15.4951 17.8571 15.8283 17.5714 15.8283 17.1429C15.8283 16.7143 15.4951 16.4286 14.9953 16.4286H4.16538C3.66553 16.4286 3.33234 16.7143 3.33234 17.1429C3.33234 17.5714 3.66553 17.8571 4.16538 17.8571Z"
                                        fill="black" />
                                    <path d="M20.8268 16.4285H18.3275C17.8277 16.4285 17.4945 16.7142 17.4945 17.1428C17.4945 17.5714 17.8277 17.8571 18.3275 17.8571H20.8268C21.3266 17.8571 21.6598 17.5714 21.6598 17.1428C21.6598 16.7142 21.3266 16.4285 20.8268 16.4285Z"
                                        fill="black" />
                                    <path d="M49.2346 7.57141C48.6515 6.92855 47.9017 6.57138 46.9853 6.49998L44.986 6.29222V4.28563V2.85712C44.986 1.28572 43.4864 4.08695e-09 41.6537 4.08695e-09H3.33226C1.49953 -8.37013e-05 0 1.28563 0 2.85712V4.28572V10V25.7143C0 27.0045 1.01111 28.1014 2.38724 28.453C2.34526 29.8979 3.62035 31.1523 5.33173 31.2857L43.8197 35C43.903 35 44.0696 35 44.1529 35C45.8191 35 47.3186 33.9286 47.4852 32.5715L49.9844 9.64287C50.0677 8.92852 49.8177 8.14278 49.2346 7.57141ZM1.66618 4.99998H43.3199V6.85715V9.28569H1.66618V4.99998ZM3.33226 1.42852H41.6536C42.57 1.42852 43.3198 2.07137 43.3198 2.85712V3.57138H1.66618V2.85712C1.66618 2.07137 2.41594 1.42852 3.33226 1.42852ZM1.66618 25.7142V10.7142H43.3199V25.7142C43.3199 26.5 42.5701 27.1428 41.6537 27.1428H3.41563H3.33236C2.41594 27.1428 1.66618 26.5 1.66618 25.7142ZM48.3182 9.35709L45.819 32.2857C45.7357 33.0714 44.9026 33.6428 43.9863 33.5714L5.58156 29.8571C4.74852 29.7857 4.1653 29.2143 4.08203 28.5714H41.6536C43.4863 28.5714 44.9859 27.2857 44.9859 25.7143V9.99995V7.64281L46.902 7.78569C47.3185 7.78569 47.735 7.99998 47.9849 8.28567C48.2349 8.57135 48.4016 8.99992 48.3182 9.35709Z"
                                        fill="black" />
                                </svg>


                            </div>
                            <span>Payment Options</span>
                        </div>
                        <div class="fs-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="password" >Password</label>
                                        <input type="password" class="form-control" >
                            
                                    </div>

                                </div>
                                
                               
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="c_password">Confirm Password</label>
                                        <input type="password" class="form-control">
                                
                                    </div>
                                
                                </div>
                                
                               
                            </div>
                    
                            
                    
                        </div>
                    </div>
                    <!-- form section end -->

                    <div class="text-center py-4 mt-4">
                        <button type="submit" class="btn btn-lg btn-theme-blue px-4">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- end -->
</main>