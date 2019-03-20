@extends('layouts.master')

@section('meta-description', '')
@section('meta-keywords', '')

@section('title', Auth::user()->name . ' Bank Accounts')

@section('content')
  
<div class="row">
	<div class="col-md-8">
    <div class="card shadow-sm">
        <div class="card-body">
          <h1>
            <span>Bank Accounts</span>
            <button data-toggle="modal" data-target="#newBankAccountForm" title="New Bank Account">
              <i class="fa fa-bank"></i>&nbsp; Add Bank Account
            </button>
          </h1>
        </div>
    </div>

		@forelse ($bank_accounts as $bank_account)
      
      <div class="card shadow-sm">
        <div class="card-body">
          <i class="fas fa-trash fa-fw red"></i>
          <blockquote class="blockquote mb-0">
            {{-- <a href="{{ route('bank_accounts.show', $bank_account) }}"> --}}
              <p>
                {{ $bank_account->name }}
                <span class="pull-right" style="color: inherit;">
                  <span class="badge badge-dark badge-sm" title="Transactions with {{ $bank_account->account_name }} account">
                    {{-- $bank_account->transactions_count --}}
                    <small>Transaction(s)</small>
                  </span>
                </span>
              </p>
            {{-- </a> --}}
            <footer class="blockquote-footer">
              {{ $bank_account->name }} <br>  
              {{ $bank_account->account_number }}
            </footer>
          </blockquote>
        </div>
      </div>
    @empty
      <div class="text-center">
        <div class="display-3"><i class="fa fa-bank"></i></div> 

        <br>

        <p>You have <strong>0</strong> bank accounts at this time.</p>
      </div>
		@endforelse
	</div>

  <div class="col-md-4">
    <div class="p-3 shadow bg-white text-center">
      ...
    </div>
  </div>
</div>

  @can ('create', App\Specialty::class)

  <div class="modal" tabindex="-1" role="dialog" id="newBankAccountForm" style="display:none;" aria-labelledby="newBankAccountFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content px-3">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
          <span aria-hidden="true">&times;</span>
        </button>
        <br>
        <div class="modal-body">

          <div class="text-center">
            <div class="form-group text-center">
              <label for="avatar" class="h5">Add New Bank Account</label>
            </div>
          </div>

          <div class="card text-center shadow">
            <div class="card-header">
              <div class="card-title">
                <i class="fa fa-bank"></i> Add New Bank Account
              </div>
            </div>

            <div class="card-body">
              <form action="{{route('bank_accounts.store')}}" method="post">
                {{ csrf_field() }}

                <div class="form-group">
                  <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="bank name" required>

                  @if ($errors->has('name'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <input type="text" name="account_name" class="form-control{{ $errors->has('account_name') ? ' is-invalid' : '' }}" value="{{ old('account_name') }}" placeholder="account owner name" required>

                  @if ($errors->has('account_name'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('account_name') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <input type="text" name="account_number" class="form-control{{ $errors->has('account_number') ? ' is-invalid' : '' }}" value="{{ old('account_number') }}" placeholder="account number" required>

                  @if ($errors->has('account_number'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('account_number') }}</strong>
                      </span>
                  @endif
                </div>

                <button type="submit" class="btn btn-block btn-primary">Create Bank Account</button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
  @endcan
@endsection
