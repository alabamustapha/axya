<div class="container">
                          <div class="border-bottom p-2 tf-flex">
                            <span class="font-weight-bold">
                              <i class="fa fa-info-circle"></i> Appointment Description
                            </span>

                            @if ($appointment->creator && $appointment->schedule_period_pending)
                            <span class="p-2" style="cursor: pointer;" 
                              data-toggle="modal" data-target="#appointmentForm" 
                              title="Edit Appointment">
                              <i class="fa fa-edit"></i> Edit
                            </span>
                            @endif
                          </div>
                          <div class="border-bottom py-3 text-sm">
                            <span>{{$appointment->description}}</span>
                          </div>

                          <div class="row">
                            <ul class="list-unstyled bg-dark p-3 col-md-7">
                              <li class="tf-flex">
                                <span class="text-bold">Status:</span> <span>{{$appointment->status_text}}</span>
                              </li>
                              <li class="tf-flex">
                                <span class="text-bold">Appointment Start:</span> <span>{{$appointment->from}}</span>
                              </li>
                              <li class="tf-flex">
                                <span class="text-bold">Correspondence Ends At:</span> <span>{{$appointment->correspondence_ends_at}}</span>
                              </li>
                            </ul>

                            <ul class="list-unstyled bg-light p-3 col-md-5">
                              <li>
                                <span class="text-bold">Prescriptions:</span>
                              </li>
                              @if ($prescriptions)
                                <li>
                                  <ol>
                                    @foreach ($prescriptions as $key => $pr)
                                    {{--  class="btn btn-dark btn-sm btn-block text-white m-1" --}}
                                      <li class="p-1 m-1">
                                        <a href="#_{{ md5($pr) }}" class="py-1 px-2 m-1 bg-dark rounded">
                                          <span class="text-white">
                                            <span class="font-weight-bold">
                                              <i class="fa fa-prescription"></i>&nbsp;
                                              {{ \Carbon\Carbon::parse($key)->format('D, dS M, Y') }}
                                            </span>
                                             : View
                                          </span>
                                        </a>
                                      </li>
                                    @endforeach
                                  </ol>
                                </li>
                              @endif
                            </ul>
                          </div>
                        </div>