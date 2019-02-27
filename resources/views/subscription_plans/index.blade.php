@extends('layouts.master')

@section('meta-description', '')
@section('meta-keywords', '')

@section('title', "Subscription Plans Index")

@section('content')
  
<div class="row">
	<div class="col-md-8">
    <div class="card shadow-sm">
        <div class="card-body">
          <h1>Subscription Plans</h1>
        </div>
    </div>

		@forelse ($subscriptionPlans as $subscriptionPlan)
      
      <div class="card shadow-sm">
        <div class="card-body">
          <blockquote class="blockquote mb-0">
            <a href="{{ route('subscription_plans.show', $subscriptionPlan) }}">
              <p>
                {{ $subscriptionPlan->name }}
                <span class="pull-right" style="color: inherit;">
                  <span class="badge badge-dark badge-sm" title="Doctors with {{ $subscriptionPlan->name }} subscription plan">
                    {{ $subscriptionPlan->doctors_count }}
                    <small>Doctor(s)</small>
                  </span>
                </span>
              </p>
            </a>
            <footer class="blockquote-footer">{{ $subscriptionPlan->description }}</footer>
          </blockquote>
        </div>
      </div>
    @empty
      <div class="text-center">
        <div class="display-3"><i class="fa fa-rss"></i></div> 

        <br>

        <p><strong>0</strong> subscription plans available.</p>
      </div>
		@endforelse
	</div>

  <div class="col-md-4">
    @can ('create', App\SubscriptionPlan::class)
      <div class="card card-primary card-outline text-center shadow">
        <div class="card-header">
          <div class="card-title">
            <i class="fa fa-rss"></i> Add New Subscription Plan
          </div>
        </div>

        <div class="card-body">
					<form action="{{route('subscription_plans.store')}}" method="post">
						{{ csrf_field() }}

	       		<div class="form-group">
							<input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="subscription plan name" required>

	            @if ($errors->has('name'))
	                <span class="invalid-feedback" role="alert">
	                    <strong>{{ $errors->first('name') }}</strong>
	                </span>
	            @endif
	          </div>

            <div class="form-group">
              <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"  style="min-height: 100px;max-height: 150px;" placeholder="description" required>{{ old('description') }}</textarea>

              @if ($errors->has('description'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('description') }}</strong>
                  </span>
              @endif
            </div>

            <div class="form-group">
              <input value="{{ old('price') }}" type="number" step="0.01" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="price" required>

              @if ($errors->has('price'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('price') }}</strong>
                  </span>
              @endif
            </div>

	       		<div class="form-group">
							<input value="{{ old('discount') }}" type="number" step="0.01" name="discount" class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="discount" required>

	            @if ($errors->has('discount'))
	                <span class="invalid-feedback" role="alert">
	                    <strong>{{ $errors->first('discount') }}</strong>
	                </span>
	            @endif
	          </div>

						<button type="submit" class="btn btn-block btn-primary">Create Subscription Plan</button>
					</form>
        </div>
      </div>
    @endcan

    <div class="p-3 shadow bg-white text-center">
      ...
    </div>
  </div>
</div>

@endsection
