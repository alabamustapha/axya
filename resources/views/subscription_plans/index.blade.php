@extends('layouts.app')

@section('meta-description', '')
@section('meta-keywords', '')

@section('title', "Subscription Plans Index")

@section('content')
  
    <!-- Start section -->
    <section id="subscription">
        <!-- Page title -->
        <div class="page-title text-center mb-4">
            <h1 class="h3">Premium Healthcare platform</h1>
        </div>
        <!-- end -->
        <div class="container">
            <div class="df-container py-5">

                <h2 class="subscription-title">Subscription Plans <small>(<i class="fas fa-user-md"></i> &nbsp;Doctors only)</small></h2>
                @can('create', App\SubscriptionPlan::class)  
                  <div class="text-center">
                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#subscriptionPlanCreateForm" title="Create New Subscription Plan">
                      <i class="fa fa-plus mr-1"></i> Add New Plan
                    </button>
                  </div>
                @endcan

                <div class="subscription">
                    @forelse ($subscriptionPlans as $i => $subscriptionPlan)                    

                      <div class="subscription-plan subscription-plan--{{ ($i % 2 === 0) ? 'white':'blue' }}">
                          @can('edit', $subscriptionPlan)  
                            <div class="row">
                              <p class="subscription-plan--type border-bottom pb-2">
                                  <span>
                                    <a href="{{ $subscriptionPlan->link }}" class="btn btn-sm btn-info" title="Vew or Update Subscription Plan">
                                      <i class="fa fa-eye mr-1"></i> View/Edit <i class="fa fa-edit ml-1"></i>
                                    </a>
                                  </span>
                              </p>
                            </div>
                          @endcan

                          <p class="subscription-plan--type">
                            {{ $subscriptionPlan->name }}
                          </p>
                          <p class="subscription-plan--price">
                              <span class="price">
                                <span class="text-sm">{{ setting('base_currency') }}</span>
                                {{ $subscriptionPlan->price }}
                              </span>
                              /{{ $subscriptionPlan->months_count }} {{ str_plural('month', $subscriptionPlan->months_count) }}
                          </p>
                          <ul class="subscription-plan--detail">
                              @foreach ($subscriptionPlan->planInformation as $info)
                                <li>{{ $info }}</li>
                              @endforeach
                          </ul>
                          
                          @auth
                            @if (Auth::user()->is_doctor)
                              <form action="{{route('subscriptions.store')}}" method="post" id="subscription-form" class="text-center">
                                @csrf

                                <input type="hidden" name="type" value="{{ $subscriptionPlan->id }}">
                                {{-- <span class="d-inline-block mb-1" style="width: 60px" title="Multiples">
                                  <input type="number" name="multiple" value="1" min="1" class="form-control form-control-sm text-center" required>
                                </span> --}}

                                <button type="submit" class="btn {{ ($i % 2 === 0) ? 'btn-theme-blue':'bg-white text-theme-blue' }} subscription-plan--btn btn-lg rounded-pill" onclick="return confirm('Go ahead with this new subscription?');">                              
                                    @if (Auth::user()->doctor->is_subscribed)
                                      <span title="Extend your current subscription">Extend Sub.</span>
                                    @else
                                      <span title="Subscribe Now">Subscribe</span>
                                    @endif                              
                                </button>
                              </form>
                            @else
                              <p class="p-2 border rounded text-center">
                                <small class="d-block pb-2 mb-2 border-bottom" style="font-size: 75% !important; font-weignt:bold !important;">
                                  <a href="{{ route('doctors.create') }}">Apply as Doctor</a> and...
                                </small>

                                <span class="btn {{ ($i % 2 === 0) ? 'btn-theme-blue':'bg-white text-theme-blue' }} subscription-plan--btn btn-lg rounded-pill">
                                  Subscribe
                                </span>
                              </p>
                            @endif
                          @else
                            <p class="p-2 border rounded text-center">
                              <small class="d-block pb-2 mb-2 border-bottom" style="font-size: 75% !important; font-weignt:bold !important;">
                                Login, Apply as Doctor and...
                              </small>

                              <span class="btn {{ ($i % 2 === 0) ? 'btn-theme-blue':'bg-white text-theme-blue' }} subscription-plan--btn btn-lg rounded-pill">
                                Subscribe
                              </span>
                            </p>
                          @endauth
                      </div>

                    @empty
                      <em class="col text-center border-top border-bottom p-4 bg-light">No available subscription plans.</em>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- end -->

  @can('create', App\SubscriptionPlan::class)
    <div class="modal bg-transparent" tabindex="-1" role="dialog" id="subscriptionPlanCreateForm" style="display:none;" aria-labelledby="subscriptionPlanCreateFormLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content px-0 pb-0 m-0 bg-transparent shadow-none">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
            <span aria-hidden="true">&times;</span>
          </button>
          <br>
          <div class="modal-body">

            <div class="card card-primary text-center shadow">
              <div class="card-header">
                <div class="card-title">
                  <i class="fas fa-plus"></i> Add New Subscription Plan
                </div>
              </div>

              <div class="card-body">              
                
                @if (Auth::user()->isAuthenticatedAdmin())
                  <form action="{{route('subscription_plans.store')}}" method="post">
                    {{ csrf_field() }}

                    <div class="form-group text-left">
                      <label class="text-muted" for="name">Subscription Name</label>
                      <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="Monthly Plan" required>

                      @if ($errors->has('name'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="form-group text-left">
                      <label class="text-muted d-inline-block" for="months_count">Number of Months <small class="text-info float-right">(eg 6 months)</small></label>
                      <input value="{{ old('months_count') }}" type="number" name="months_count" class="form-control{{ $errors->has('months_count') ? ' is-invalid' : '' }}" placeholder="12" required>

                      @if ($errors->has('months_count'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('months_count') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="form-group text-left">
                      <label class="text-muted" for="description">Description<br>
                        <small>
                          <ul>
                            <li>In short sentences.</li>
                            <li>Each sentence must be seperated by <strong>double semi-colons <kbd class="text-warning">;;</kbd></strong>.</li>
                          </ul>
                        </small>
                      </label>
                      <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"  style="min-height: 100px;max-height: 150px;" placeholder="short description ;; another short description;;" required>{{ old('description') }}</textarea>

                      @if ($errors->has('description'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('description') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="form-group text-left">
                      <label class="text-muted" for="price">Price ({{ setting('base_currency') }})</label>
                      <input value="{{ old('price') }}" type="number" step="0.01" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="1000" required>

                      @if ($errors->has('price'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('price') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="form-group text-left">
                      <label class="text-muted" for="discount">Discount (%)</label>
                      <input value="{{ old('discount') }}" type="number" step="0.01" name="discount" class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="5" required>

                      @if ($errors->has('discount'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('discount') }}</strong>
                          </span>
                      @endif
                    </div>

                    <button type="submit" class="btn btn-block btn-primary">Create Subscription Plan</button>
                  </form>
                @else
                  <p class="font-weight-bold p-3 text-center text-dark">
                    You must be signed in as admin to access this section.
                    <br>
                    <a href="{{ route('admin.login') }}" class="btn btn-primary">
                      <i class="fa fa-user-tie"></i> Admin Sign In <i class="fa fa-sign-in-alt"></i>
                    </a>
                  </p>
                @endif

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endcan
@endsection
