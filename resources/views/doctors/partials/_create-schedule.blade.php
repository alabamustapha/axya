                <table v-if="creating" class="w-100">
                  <tr>
                    <td class="tf-flex-ctrl">
                      <div>
                        <span class="d-inline-block">Start: 
                          <input v-model="form.start_at" 
                            :class="{ 'is-invalid': form.errors.has('start_at') }" 
                            @keyup.enter="store" 
                            type="text" maxlength="8" minlength="8" 
                            name="start_at" placeholder="eg 23:15:00" pattern="" 
                            id="start_at" class="form-control" 
                          required>
                          <has-error :form="form" field="start_at"></has-error>
                        </span>
                        
                        <span class="d-inline-block">End: 
                          <input v-model="form.end_at" 
                            :class="{ 'is-invalid': form.errors.has('end_at') }" 
                            @keyup.enter="store" 
                            type="text" maxlength="8" minlength="8" 
                            name="end_at" placeholder="eg 01:30:00" pattern="" 
                            id="end_at" class="form-control" 
                          required>
                          <has-error :form="form" field="end_at"></has-error>
                        </span>
                      </div>

                      @include('doctors.partials._schedule-controls')
                    </td>
                  </tr>
                </table>