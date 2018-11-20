<tr>
                      <td class="w-100">

                        <!-- The Sub Template Section-->
                        <schedule :the_doctor_id="{{ $doctor->id }}" :the_schedule="{{ $schedule }}" inline-template v-cloak>
                          <div class="tf-flex-ctrl">
                            <div v-if="editing">
                              <span class="d-inline-block mr-2">
                                Start: 
                                <input v-model="form.start_at" 
                                  :class="{ 'is-invalid': form.errors.has('start_at') }" 
                                  @keyup.enter="update" 
                                  type="text" minlength="8" maxlength="8" 
                                  name="start_at" placeholder="eg 23:15:00" pattern=""
                                  style="width:100px;" id="start_at" class="form-control"
                                required>
                                <has-error :form="form" field="start_at"></has-error>
                              </span>
                              
                              <span class="d-inline-block mr-2">
                                End: 
                                <input v-model="form.end_at" 
                                  :class="{ 'is-invalid': form.errors.has('end_at') }" 
                                  @keyup.enter="update" 
                                  type="text" minlength="8" maxlength="8" 
                                  name="end_at" placeholder="eg 01:30:00" pattern=""
                                  style="width:100px;" id="end_at" class="form-control"
                                required>
                                <has-error :form="form" field="end_at"></has-error>
                              </span>
                            </div>

                            <div v-else>
                              <span>
                                <span>{{$schedule->start}} - {{$schedule->end}}</span>
                              </span>
                            </div>

                            @include('doctors.partials._schedule-controls')
                          </div>
                        </schedule>
                      </td>
                    </tr>