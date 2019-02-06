@extends('layouts.master')

@section('title', 'Subscriptions Management/Dashboard')
@section('page-title')
    <i class="fa fa-rss"></i>&nbsp;  {{ __('Subscriptions Management') }}
@endsection

@section('content')

<div class="container-fluid">
  <div class="row">
    <!-- Left col -->
    <div class="col-md-10">

      <div class="order-sm-1 order-2 text-center">
        <div class="row">
          <div class="col-md-12">
            <!-- small box -->
            <div class="small-box bg-info p-1">
              <div class="inner pt-5">
                <div class="row">
                  <div class="col-sm-5">
                    <i class="fa fa-rss display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{$successful_subscriptions_count}}</h1>

                    <p>Successful Subscriptions</p>
                  </div>
                </div>
              </div>
              <div class="small-box-footer p-2">
                <form @submit.prevent="searchForSubscription" class="form-inline">
                  <div class="form-group mb-2 d-inline-block w-100">
                    <input
                      v-model="search"
                      @keyup="searchForSubscription"
                      type="search" name="search"
                      placeholder="search subscriptions...by ID" aria-label="Search Subscriptions..." 
                      class="form-control form-control-lg text-center w-100 bg-dark" id="subscriptionSearchForm">
        
                  </div>        
                  <button @click="searchForSubscription" type="submit" class="btn btn-primary d-block mx-auto">
                      <i class="fa fa-search "></i> Search
                  </button>                    
                </form>
              </div>

              <div class="bg-light">
                <subscription-search></subscription-search>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- ./row -->
      </div>

      <!-- MAP & BOX PANE -->
      {{-- <div class="card text-center shadow-none">
        <div class="card-header">
          <h3 class="card-title text-bold">Subscriptions Statistics</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0 mb-4 shadow-sm">
          //
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card --> --}}


      <div class="row">
        <div class="col-md-12">

          @forelse($subscriptions as $subscription)
          <div class="table-responsive">
              <table class="table border">
                  <tr>
                      <td colspan="2"><kbd class="bg-info"><a href="{{route('subscriptions.show', $subscription)}}" class="card-link"><i class="fa fa-eye"></i> View Subscription</a></kbd></td>
                      <td></td>
                      <td colspan="2"><kbd><i class="fa fa-clock"></i> Created: {{$subscription->created_at}}</kbd></td>
                  </tr>

                  <tr>
                      <td>
                          <span class="border p-1 text-sm tf-flex">
                              <span title="View {{$subscription->doctor->name}}'s subscription payments" data-toggle="tooltip">
                                  <img src="{{$subscription->doctor->avatar}}" height="45" alt="doctor avatar" class="rounded-circle">
                                  <a href="{{route('subscriptions.index', $subscription->doctor)}}">
                                      {{$subscription->doctor->name}}&nbsp;
                                  </a> 
                              </span>
                              <a href="{{route('doctors.show', $subscription->doctor)}}" class="text-bold" title="View {{$subscription->doctor->name}}'s profile" data-toggle="tooltip">
                                  Profile
                              </a>
                          </span>
                      </td>
                      <td>
                          <span class="border px-4 text-center">
                              <span class="text-muted" style="font-size: .5rem;">Amount:</span> <br>
                              <span class="text-bold">${{$subscription->amount}}</span>
                          </span>
                      </td>
                      <td>
                          <span class="border px-4 text-center">
                              <span class="text-muted" style="font-size: .5rem;">Type:</span> <br>
                              <span class="text-bold">{{$subscription->type_text}}</span>
                          </span>
                      </td>
                      <td>
                          <span class="border px-4 text-center">
                              <span class="text-muted" style="font-size: .5rem;">Multiples:</span> <br>
                              <span class="text-bold">{{$subscription->multiple}}</span>
                          </span>
                      </td>
                      <td>
                          <span class="border px-4 text-center">
                              <span class="text-muted" style="font-size: .5rem;">End Date:</span> <br>
                              <span class="text-bold">{{$subscription->end}}</span>
                          </span>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="5" class="card-footer text-bold text-white bg-{{$subscription->status_indicator}}">
                          <span class="text-muted text-sm">
                              Status:&nbsp;
                          </span>
                           
                          {{$subscription->status_text}}
                      </td>
                  </tr>
              </table>
          </div>
          @empty
              
              <div class="col empty-list">No subscriptions at this time</div>

          @endforelse
          
          <div class="text-center py-3">
              {{ $subscriptions->appends(request()->query())->links() }}
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.col -->

    
    <div class="col-md-2">
      <!-- Info Boxes Style 2 -->
      <div class="info-box mb-3 bg-success">
        <span class="info-box-icon"><i class="fa"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Successful</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-warning">
        <span class="info-box-icon"><i class="fa"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Pending</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-danger">
        <span class="info-box-icon"><i class="fa"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Failed</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
</div>

@endsection