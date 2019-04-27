@extends('layouts.admin')

@section('title', 'Notifications Management')
@section('page-title')
    <i class="fa fa-bullhorn"></i>&nbsp;  {{ __('Notifications Management') }}
@endsection

@section('content')

  <div class="row">
    <div class="col-md-9 order-md-1 order-2 mb-3">

        <div class="col-sm-6">

        {{-- Send Message/Notifications
        - AS: text/email/push/notice
        - TO: 
          - User(s)
          - Doctor(s)
          - Admin(s)
          - Users/Doctors from City/Region
          - Everyone
        - TITLE
        - CONTENT (can contain attachments). --}}
          <form action="" class="card shadow shadow-md">
            <h4 class="card-header bg-light font-weight-bold p-4">
              New Message/Notification
            </h4>

            <div class="card-body pb-2">
              <div class="form-group">
                <label for="content">Send As:</label>

                <hr class="mt-0">
                
                <div class="custom-control">
                  <input type="checkbox" class="" id="asNotice" checked>
                  <label class="text-sm font-weight-normal mb-0" for="asNotice">In-app Notice</label>

                  <br>
                  <input type="checkbox" class="" id="asEmail">
                  <label class="text-sm font-weight-normal mb-0" for="asEmail">Email notifications</label>

                  <br>
                  <input type="checkbox" class="" id="asPush">
                  <label class="text-sm font-weight-normal mb-0" for="asPush">Push notifications</label>

                  <br>
                  <input type="checkbox" class="" id="asText">
                  <label class="text-sm font-weight-normal mb-0" for="asText">SMS notifications</label>
                </div>
              </div>

              <div class="form-group">
                <label for="mto">To:</label>

                <hr class="mt-0">

                <select class="form-control form-default mb-1" id="mto" required>
                  <option value="">Send To</option>
                  <option value="1">Everyone</option>
                  <option value="2">Admins</option>
                  <option value="3">Doctor(s)</option>
                  <option value="4">User(s)</option>
                </select>
                <div class="mb-1">
                  <location-selection
                      :set-row-class="'row'"
                      :region-div="'col-6'"
                      :city-div="'col-6'"
                      >
                </div>
                <div class="">
                  </location-selection>

                  <input type="email" class="form-control form-default" id="searchEmail" placeholder="user/doctor email seperated by ;">
                </div>
              </div>

              <div class="form-group">
                <label for="mtitle">Message:</label>

                <hr class="mt-0">

                <input class="form-control form-default" id="mtitle" type="text" placeholder="message title" autocomplete="off">
              </div>

              <div class="form-group">
                {{-- <label for="mcontent">Message:</label> --}}

                <textarea 
                  class="form-control form-default" id="mcontent"
                  style="min-height: 150px; max-height: 250px;"
                  placeholder="message content"
                  required 
                ></textarea>
              </div>
            </div>

            <div class="card-footer">
              <button class="btn btn-lg btn-block btn-secondary">
                <i class="fa a-paper-plane"></i>&nbsp; Send Message
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
    <!-- /.col -->
  </div>

@endsection