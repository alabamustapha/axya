@extends('layouts.master')

@section('title', $user->name .' Dashboard')

@section('content')    
  
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header p-2">
          <ul class="nav nav-pills">
            <li class="nav-item">
                <a class="nav-link active" href="#visits" data-toggle="tab">
                    <i class="fa fa-h-square"></i> 
                    Visit History
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#transactions" data-toggle="tab">
                    <i class="fa fa-handshake"></i> 
                    Transaction History
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#tests" data-toggle="tab">
                    <i class="fa fa-stethoscope"></i> 
                    Medical tests 
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#treatments" data-toggle="tab">
                    <i class="fa fa-medkit"></i> 
                    Treatments
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#prescriptions" data-toggle="tab">
                    <i class="fa fa-prescription"></i> 
                    Prescriptions
                </a>
            </li>
          </ul>
        </div><!-- /.card-header -->
        <div class="card-body">
          <div class="tab-content">
            <div class="active tab-pane" id="visits">
              <!-- Visits -->
              Visits
            </div>

            <div class="tab-pane" id="transactions">
              <!-- Transactions -->
              Transactions
            </div>

            <div class="tab-pane" id="tests">
              <!-- Medical tests  -->
              Medical tests 
            </div>

            <div class="tab-pane" id="treatments">
              <!-- Treatments -->
              Treatments
            </div>

            <div class="tab-pane" id="prescriptions">
              <!-- Prescriptions -->
              Prescriptions
            </div>

          </div>
        </div><!-- /.card-body -->
      </div>
    </div>
  </div>

@endsection
