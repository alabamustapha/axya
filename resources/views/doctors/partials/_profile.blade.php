
                <div class="card mr-1 shadow-sm" style="min-width: 18rem;max-width: 18rem;">
                    <div style="display:block;min-height: 200px;height: 200px;overflow: hidden;">
                        <img class="card-img-top" src="{{ $doctor->dummyAvatar()/*$doctor->avatar*/ }}" alt="{{ $doctor->name }}" style="display:block;min-height: 200px;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title d-block text-truncate">
                            <a href="{{route('doctors.show', $doctor->user)}}">{{ $doctor->name }}</a>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <a href="#" style="color: inherit;">{{ $doctor->specialty->name }}</a>
                        </h6>
                        <p class="card-text">Practice Years: {{random_int(2,10)}}</p>
                    </div>
                    <div class="card-footer">
                        <span class="tf-flex mb-2">
                            <small class="text-muted">
                                <span class="fa fa-star text-primary p-0 m-0"></span>
                                <span class="fa fa-star text-primary p-0 m-0"></span>
                                <span class="fa fa-star text-primary p-0 m-0"></span>
                                <span class="fa fa-star text-primary p-0 m-0"></span>
                                <span class="fa fa-star text-primary p-0 m-0"></span>
                            </small>
                            <span>&nbsp;{{random_int(1,5)}}({{random_int(10,100)}})</span>
                        </span>
                        <a href="{{route('doctors.show', $doctor)}}" class="btn btn-primary btn-sm btn-block" title="View Profile and Make Appointment">
                            <i class="fa fa-user-check"></i>&nbsp; View Profile
                        </a>
                    </div>
                </div>