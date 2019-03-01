@extends('layouts.master')

@section('meta-description', $subscriptionPlan->name)
@section('meta-keywords', '')

@section('title', $subscriptionPlan->name)

@section('content')

<div class="row">
  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-body">
        @can('edit', $subscriptionPlan)  
          <span class="mr-3">
            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#subscriptionPlanUpdateForm" title="Update Subscription Plan">
              <i class="fa fa-edit"></i>&nbsp; edit
            </button>
          </span>
        @endcan
        <span>
          <b>{{ $subscriptionPlan->name }}</b> - {{ $subscriptionPlan->description }}
        </span>
      </div>
    </div>

    <div class="card-deck">
      @forelse ($doctors as $doctor)

        @include('doctors.partials._profile')

      @empty
        <div class="empty-list">0 doctors are on {{$subscriptionPlan->name}} subscriptions at the moment.</div>
      @endforelse
    </div>

  </div>

  <div class="col-md-4">
    ...
  </div>
</div>


@can('edit', $subscriptionPlan)
  <div class="modal bg-transparent" tabindex="-1" role="dialog" id="subscriptionPlanUpdateForm" style="display:none;" aria-labelledby="subscriptionPlanUpdateFormLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content px-0 pb-0 m-0 bg-transparent shadow-none">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
          <span aria-hidden="true">&times;</span>
        </button>
        <br>
        <div class="modal-body">

          <div class="card card-primary card-outline text-center shadow">
            <div class="card-header">
              <div class="card-title">
                <h5>Update the Subscription Plan: <strong><i class="fa fa-tags"></i>&nbsp;{{$subscriptionPlan->name}}</strong> </h5>
              </div>
            </div>

            <div class="card-body">
              
              <form action="{{route('subscription_plans.update', $subscriptionPlan)}}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }} 

                <div class="form-group">
                  <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') ?: $subscriptionPlan->name }}" placeholder="subscriptionPlan name" required>

                  @if ($errors->has('name'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"  style="min-height: 100px;max-height: 150px;" placeholder="description" required>{{ old('description') ?: $subscriptionPlan->description }}</textarea>

                  @if ($errors->has('description'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('description') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <input value="{{ old('price') ?:$subscriptionPlan->price }}" type="number" step="0.01" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" placeholder="price" required>

                  @if ($errors->has('price'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('price') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <input value="{{ old('discount') ?: $subscriptionPlan->discount }}" type="number" step="0.01" name="discount" class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" placeholder="discount" required>

                  @if ($errors->has('discount'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('discount') }}</strong>
                      </span>
                  @endif
                </div>

                <button type="submit" class="btn btn-block btn-primary">Update Subscription Plan</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endcan

@endsection