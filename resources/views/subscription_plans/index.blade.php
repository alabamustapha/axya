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

                <h2 class="subscription-title">Subscription Plans</h2>
                @can('create', App\SubscriptionPlan::class)  
                  <div class="text-center">
                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#subscriptionPlanCreateForm" title="Create New Subscription Plan">
                      <i class="fa fa-plus mr-1"></i> Add New Plan
                    </button>
                  </div>
                @endcan

                <div class="subscription">
                    @foreach ($subscriptionPlans as $i => $subscriptionPlan)
                    

                    <div class="subscription-plan subscription-plan--{{ ($i % 2 === 0) ? 'white':'blue' }}">
                        <div class="row">
                          <p class="subscription-plan--type border-bottom pb-2">
                            @can('edit', $subscriptionPlan)  
                              <span>
                                <a href="{{ $subscriptionPlan->link }}" class="btn btn-sm btn-info" title="Vew or Update Subscription Plan">
                                  <i class="fa fa-eye mr-1"></i> View/Edit <i class="fa fa-edit ml-1"></i>
                                </a>
                              </span>
                            @endcan
                          </p>
                        </div>

                        <p class="subscription-plan--type">
                          {{ $subscriptionPlan->name }}
                        </p>
                        <p class="subscription-plan--price">
                            <span class="price">
                              <span class="text-sm">{{ setting('base_currency') }}</span>
                              {{ $subscriptionPlan->price }}
                            </span>
                            /4 Months {{ $subscriptionPlan->info_1 }}
                        </p>
                        <ul class="subscription-plan--detail">
                            {{ $subscriptionPlan->info_2_4_5 ?:'' }}
                            <li>No Ads</li>
                            <li>Unlimited Appointments </li>
                            <li>Vip Treatment</li>
                            {{ $subscriptionPlan->description }}
                        </ul>
                        
                        <a href="#" class="btn {{ ($i % 2 === 0) ? 'btn-theme-blue':'bg-white text-theme-blue' }} subscription-plan--btn btn-lg rounded-pill">subscribe</a>
                    </div>

                    @endforeach
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
                    <label class="text-muted" for="description">Description</label>
                    <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"  style="min-height: 100px;max-height: 150px;" placeholder="short description" required>{{ old('description') }}</textarea>

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

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endcan
@endsection
