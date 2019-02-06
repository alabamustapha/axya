@extends('layouts.master')

@section('title', 'Transactions Management/Dashboard')
@section('page-title')
    <i class="fa fa-handshake"></i>&nbsp;  {{ __('Transactions Management') }}
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
                    <i class="fa fa-handshake display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{$successful_transactions_count}}</h1>

                    <p>Successful Transactions</p>
                  </div>
                </div>
              </div>
              <div class="small-box-footer p-2">
                <form @submit.prevent="searchForTransaction" class="form-inline">
                  <div class="form-group mb-2 d-inline-block w-100">
                    <input
                      v-model="search"
                      @keyup="searchForTransaction"
                      type="search" name="search"
                      placeholder="search transactions...by ID" aria-label="Search Transactions..." 
                      class="form-control form-control-lg text-center w-100 bg-dark" id="transactionSearchForm">
        
                  </div>        
                  <button @click="searchForTransaction" type="submit" class="btn btn-primary d-block mx-auto">
                      <i class="fa fa-search "></i> Search
                  </button>                    
                </form>
              </div>

              <div class="bg-light">
                <transaction-search></transaction-search>
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
          <h3 class="card-title text-bold">Transactions Statistics</h3>

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

          @forelse($transactions as $transaction)
          <div class="table-responsive">
              <table class="table border">
                  <tr>
                      <td colspan="2"><kbd class="bg-info"><a href="{{route('transactions.show', $transaction)}}" class="card-link"><i class="fa fa-eye"></i> View Transaction</a></kbd></td>
                      <td></td>
                      <td colspan="2"><kbd><i class="fa fa-clock"></i> Created: {{$transaction->created_at}}</kbd></td>
                  </tr>

                  <tr>
                      <td title="View {{$transaction->user->name}}'s fee payment transactions" data-toggle="tooltip">
                          <span class="border p-1">
                              <img src="{{$transaction->user->avatar}}" height="45" alt="user avatar" class="rounded-circle">
                              <a href="{{route('transactions.index', $transaction->user)}}">
                                  {{$transaction->user->name}}&nbsp;
                                  <span class="text-muted mb-2 text-sm">Patient</span>
                              </a> 
                          </span>
                      </td>
                      <td title="View {{$transaction->doctor->name}}'s client transactions" data-toggle="tooltip">
                          <span class="border p-1">
                              <img src="{{$transaction->doctor->avatar}}" height="45" alt="doctor avatar" class="rounded-circle">
                              <a href="{{route('dr_transactions', $transaction->doctor)}}">
                                  {{$transaction->doctor->name}} &nbsp;
                                  <span class="text-muted mb-2 text-sm">Doctor <small>(${{$transaction->doctor->rate}})</small></span>
                              </a>
                          </span>
                      </td>
                      <td>
                          <span class="border px-4 text-center">
                              <span class="text-muted" style="font-size: .5rem;">Amount:</span> <br>
                              <span class="text-bold">${{$transaction->appointment->fee}}</span>
                          </span>
                      </td>
                      <td>
                          <span class="border px-4 text-center">
                              <span class="text-muted" style="font-size: .5rem;">Sessions:</span> <br>
                              <span class="text-bold">{{$transaction->appointment->no_of_sessions}}</span>
                          </span>
                      </td>
                      <td>
                          <span class="border px-4 text-center">
                              <span class="text-muted" style="font-size: .5rem;">Duration:</span> <br>
                              <span class="text-bold">{{$transaction->appointment->duration}}</span>
                          </span>
                      </td>
                  </tr>
                  <tr>
                      <td colspan="5" class="card-footer text-bold text-white bg-{{$transaction->status_indicator}}">
                          <span class="text-muted text-sm">
                              Status:&nbsp;
                          </span>
                           
                          {{$transaction->status_text}}
                      </td>
                  </tr>
              </table>
          </div>
          @empty
              
              <div class="col empty-list">No transactions at this time</div>

          @endforelse
          
          <div class="text-center py-3">
              {{ $transactions->appends(request()->query())->links() }}
          </div>

        </div>
        <!-- /.col-md-12 -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.col-md-9 -->

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