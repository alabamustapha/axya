@extends('layouts.admin')

@section('title', 'Notifications Management')
@section('page-title')
    <i class="fa fa-bullhorn"></i>&nbsp;  {{ __('Notifications Management') }}
@endsection

@section('content')

  <div class="row">
    <div class="col-md-9 order-md-1 order-2 mb-3">

        <div class="col">
          <form action="{{ route('admin_notifications.store') }}" method="post" class="card shadow shadow-md">
            @csrf

            <h4 class="card-header bg-light font-weight-bold p-4">
              New Message/Notification
            </h4>

            <div class="card-body pb-2">
              <div class="row">
                <div class="form-group col-6">
                  <label for="content">Send As:</label>

                  <hr class="mt-0">
                  
                  <div class="custom-control">
                    <input type="checkbox" name="as_notice" value="1" class="" id="as_notice" {{ old('as_notice') ? 'checked' : '' }}>
                    <label class="text-sm font-weight-normal mb-0" for="as_notice">In-app Notice</label>

                    <br>
                    <input type="checkbox" name="as_email" value="1" class="" id="as_email" {{ old('as_email') ? 'checked' : '' }} disabled>
                    <label class="text-sm font-weight-normal mb-0" for="as_email">Email notifications</label>

                    <br>
                    <input type="checkbox" name="as_push" value="1" class="" id="as_push" {{ old('as_push') ? 'checked' : '' }} disabled>
                    <label class="text-sm font-weight-normal mb-0" for="as_push">Push notifications</label>

                    <br>
                    <input type="checkbox" name="as_text" value="1" class="" id="as_text" {{ old('as_text') ? 'checked' : '' }} disabled>
                    <label class="text-sm font-weight-normal mb-0" for="as_text">SMS notifications</label>
                  </div>
                </div>

                <div class="form-group col-6">
                  <label for="to">To:</label>

                  <hr class="mt-0">

                  <select class="form-control form-control-sm form-default mb-1" name="to" id="to" required>
                    <option value="">Send To</option>
                    <option {{ (old('to') == 'Everyone') ? 'selected' : '' }}>Everyone</option>
                    <option {{ (old('to') == 'Admins') ? 'selected' : '' }}>Admins</option>
                    <option {{ (old('to') == 'Doctors') ? 'selected' : '' }}>Doctors</option>
                    <option {{ (old('to') == 'Users') ? 'selected' : '' }}>Users</option>
                  </select>

                  <div class="mb-1">
                    <location-selection
                        :set-row-class="'row'"
                        :region-div="'col-6'"
                        :city-div="'col-6'"
                        :region-input-style="'form-control-sm'"
                        :city-input-style="'form-control-sm'"
                        >
                    </location-selection>
                  </div>

                  <small class="text-small text-danger">Selectively display Email/Location input fields</small>
                  
                  <div class="">
                    <input type="text" name="search_email" class="form-control form-control-sm form-default" id="search_email" placeholder="user/doctor email seperated by ;" value="{{ old('search_email') ?: '' }}">
                  </div>
                </div>
              </div>
              <div class="col text-center">
                <small class="text-small text-danger">(Mass emails must be handled with 3rd party services)</small>
              </div>

              <div class="form-group">
                <label for="title">Message:</label>

                <hr class="mt-0">

                <input class="form-control form-default" name="title" id="title" type="text" placeholder="message title" maxlength="50" autocomplete="off" value="{{ old('title') ?: '' }}">
              </div>

              <div class="form-group">
                {{-- <label for="mcontent">Message:</label> --}}

                <textarea name="content" 
                  class="form-control form-default" id="mcontent"
                  style="min-height: 150px; max-height: 250px;"
                  placeholder="message content" maxlength="450"
                  required 
                >{{ old('content') ?: '' }}</textarea>
              </div>
            </div>

            <div class="card-footer pt-0">
              <button class="btn btn-lg btn-block btn-secondary">
                <i class="fa fa-paper-plane"></i>&nbsp; Send Message
              </button>
            </div>
          </form>
        </div>
    </div>

    <div class="col-md-3 order-md-2 order-1 mb-3">
      <nav>
        
        <!-- Admin Nav -->
        @include('admin.partials.right-sidebar-nav')
        
      </nav>
    </div>
  </div>

  <div class="row">
    <div class="col">

      
      <div class="ibox ibox-table">
        <div class="ibox-header">
          <div class="row">

              <div class="col row justify-content-start align-content-center">
                <div class="col col-sm-7">
                  <h5 class="text-white font-weight-bold">
                    <span class="justify-content-center">Sent Notifications</span>
                  </h5>
                </div>
              </div>

              <div class="col row justify-content-end">
                <div class="col col-sm-7">
                  <form action="#">
                    <input type="text" class="form-control" placeholder="search...">
                  </form>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="table-responsive">

          <table id="table_id" class="display table table-striped">
            <thead>
                <tr>
                    <th scope="col">Sent As</th>
                    <th scope="col">Type</th>
                    <th scope="col">Regional</th>
                    <th scope="col">Title</th>
                    <th scope="col">Content</th>
                </tr>
            </thead>
            
            <tbody class="ibox-body">
              @forelse ($notifications as $notification)
                <tr>
                    <td>
                      {{ $notification->as_notice ? 'notice, ':'' }}
                      {{ $notification->as_email ? 'email, ':'' }}
                      {{ $notification->as_push ? 'push, ':'' }}
                      {{ $notification->as_text ? 'text ':'' }}
                      <br>
                      <span class="badge badge-warning badge-sm">
                        {{ $notification->created_at }}
                      </span>
                    </td>
                    <td>{{ $notification->to }}</td>
                    <td>
                      @if ($notification->region_id || $notification->city_id)
                        {!! ($notification->city_id) ? $notification->city->name .', <br>':'' !!}

                        {{ ($notification->region_id) ? $notification->region->name:'' }}
                      @endif
                    </td>
                    <td title="{{ $notification->content }}">{{ $notification->title }}</td>
                    <td>{{ $notification->content }}</td>
                </tr>
              @empty
                <tr>
                    <td colspan="5">No record yet</td>
                </tr>
              @endforelse
            </tbody>
          </table>

        </div>

        <div>{{ $notifications->links() }}</div>
      </div>
    </div>  
        
    <small class="card text-sm p-3 bg-dark rounded">
      <ul>
        <li><strong>Handling mass email/notifs</strong></li>
        <li><strong>Mailgun Hint by – NoNameProvided</strong> >> https://stackoverflow.com/questions/45910859/how-to-mass-email-with-laravel-mailgun</li>
        <li><strong>Google Guidelines by – Self</strong> >> https://support.google.com/a/answer/81126?hl=en</li>
        <li><strong>Laracast Hints by – Members</strong> >> https://laracasts.com/discuss/channels/general-discussion/send-mass-email-using-laravel</li>
      </ul>
    </small>        
  </div>

@endsection