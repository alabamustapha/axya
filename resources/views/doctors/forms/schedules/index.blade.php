@extends('layouts.app')
@section('title', 'Schedule Sandbox')
 
@section('styles')
{{-- <style>
  .schedule-table {
    color: #660f0b;
    font-size: 14px;
  }
  .schedule-table__font-size {
    color: gray;
    font-size: 12px;
  }

  td div label input[type='text'] {
    font-family: monospace;
    background: yellow;
    color: green;
    border: thin solid red;
    padding-left: 5px;
    line-height: 1;
    width: 225px;
    height: 18px;
    box-sizing: border-box;
    /*border-color: red;*/
    /*display: flex;
    align-content: space-around;*/
  }
</style> --}}
@endsection


@section('content')

  <schedule-index></schedule-index>

  {{-- <div class="schedule-table table-responsive">
    <table cols="2" cellspacing="0" cellpadding="0" style="table">
      <tbody>
        <tr>
          <td>
            <div class="px-3">
              <h5 class="font-weight-bold text-uppercase">Schedules</h5>
            </div>
          </td>

          <td>
            <!-- Availability Hours -->
            <div class="px-3 mb-2 border-bottom">
              <div class="d-block">
                <label>
                  <input type="radio" name="avialability_type"> &nbsp;
                  <span>Available Always</span>
                </label>
              </div>
              <div class="d-block">
                <label>
                  <input type="radio" name="avialability_type"> &nbsp;
                  <span>Available on Selected Hours</span>
                </label>
              </div>
              <div class="d-block">
                <label>
                  <input type="radio" name="avialability_type"> &nbsp;
                  <span>Not Available</span>
                </label>
              </div>
            </div>

            <!-- Availability Hours Gangan -->
            <div class="px-3 schedule-table__font-size">
              <div>
                <table cols="3" cellspacing="0" cellpadding="0">
                  <tbody>
                    @include('doctors.forms.schedules.sunday')
                  </tbody>
                </table>
              </div>
            </div>
            <!-- \Availability Hours Gangan -->
          </td>
        </tr>
      </tbody>
    </table>
  </div> --}}
@endsection