<template>
  <div>
    <tr>
      
      <td>
        <div class="justify-content-center">
          <label>
            <!-- Use this to target a day -->
            <input type="checkbox">
          </label>
        </div>
      </td>

      <td>
        <div class="px-3 font-weight-bold">Sunday</div>
      </td>

      <td>
        <div>
          <table cols="2" cellspacing="0" cellpadding="0">
            <tbody>

              <tr>
                <td>
                  <div>
                    <table cols="3" cellspacing="0" cellpadding="0">
                      <tbody>
                        
                        <tr>
                          <td>
                            <div>
                              <span placeholder="Time" autocomplete="off" autocorrect="off">
                                <label id="">
                                  <input class="" type="text" aria-autocomplete="list" aria-expanded="false" placeholder="8:00 AM" autocomplete="off" autocorrect="off" value="">
                                </label>
                              </span>
                            </div>
                          </td>
                          <td>
                            <div>–</div>
                          </td>
                          <td>
                            <div>
                              <span placeholder="Time" autocomplete="off" autocorrect="off">
                                <label id="">
                                  <input class="" type="text" aria-autocomplete="list" aria-expanded="false" placeholder="6:00 PM" autocomplete="off" autocorrect="off" value="">
                                </label>
                              </span>
                            </div>
                          </td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                </td>

                <td>
                  <div class="px-1">
                    <button class="" type="submit" value="1">
                      <i class="fa fa-plus text-primary"></i>
                      <!-- <span>Add</span> -->
                    </button>
                  </div>
                </td>
              </tr>

            </tbody>
          </table>                      
        </div>

        <!-- Hidden by default and called in when a new field is added -->
        <div style="display:block;"><!-- none -->
          <table cols="2" cellspacing="0" cellpadding="0">
            <tbody>

              <tr>
                <td>
                  <div>
                    <table cols="3" cellspacing="0" cellpadding="0">
                      <tbody>

                        <tr>
                          <td>
                            <div>
                              <span placeholder="Time" autocomplete="off" autocorrect="off">
                                <label id="">
                                  <input class="" type="text" aria-autocomplete="list" aria-expanded="false" placeholder="9:00 PM" autocomplete="off" autocorrect="off" value="">
                                </label>
                              </span>
                            </div>
                          </td>
                          <td>
                            <div>–</div>
                          </td>
                          <td>
                            <div>
                              <span placeholder="Time" autocomplete="off" autocorrect="off">
                                <label id="">
                                  <input class="" type="text" aria-autocomplete="list" aria-expanded="false" placeholder="11:00 PM" autocomplete="off" autocorrect="off" value="">
                                </label>
                              </span>
                            </div>
                          </td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                </td>

                <td>
                  <div class="px-1">
                    <button class="" type="submit" value="1">
                      <i class="fa fa-times text-danger"></i>
                      <!-- <span>Del</span> -->
                    </button>
                  </div>
                </td>
              </tr>

            </tbody>
          </table>                      
        </div>
      </td>
    </tr>
  </div>
</template>

<script>
  export default {
    //
  }
</script>