@extends('layouts.master')

@section('meta-description', $specialty->name)
@section('meta-keywords', '')

@section('title', $specialty->name)

@section('content')

<div class="row">
  <div class="col-md-8">
    <div class="card shadow-sm">
      <div class="card-body">
        @can('edit', $specialty)  
          <span class="mr-3">
            <button class="btn btn-sm" data-toggle="modal" data-target="#specialtyUpdateForm" title="Update Keyword">
              <i class="fa fa-edit teal"></i>&nbsp; edit
            </button>
          </span>
        @endcan
        <span>
          <b>{{ $specialty->name }}</b> - {{ $specialty->description }}
        </span>
      </div>
    </div>

    <div class="card-deck">
      @forelse ($doctors as $doctor)

                @include('doctors.partials._profile')

      @empty
        <div class="empty-list">0 doctors are specialized in {{$specialty->name}} at the moment.</div>
      @endforelse
    </div>

  </div>

  <div class="col-md-4">
    @can ('create', App\Specialty::class)
      <div class="card card-primary card-outline text-center shadow">
        <div class="card-header">
          <div class="card-title">
            <i class="fa fa-tags"></i> Add New Keyword
            <br>
            <span style="font-size:12px;">
              <i class="fa fa-info-circle red"></i> For doctors only! {{-- Only medical doctors can see this form. --}}
              <br>
              Add tags or keywords that are relevant to <b>{{$specialty->name}}</b> with this form.
            </span>
          </div>
        </div>

        <div class="card-body">
          <form action="{{ route('tags.store') }}" method="post">
            @csrf
            <input type="hidden" name="specialty_id" value="{{$specialty->id}}">

            <div class="form-group">
              <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="keyword, illness, procedure" required>

              @if ($errors->has('name'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('name') }}</strong>
                  </span>
              @endif
            </div>

            <div class="form-group">
              <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="short description" style="min-height: 100px;max-height: 150px;" required>{{ old('description') }}</textarea>

              @if ($errors->has('description'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('description') }}</strong>
                  </span>
              @endif
            </div>

            <button type="submit" class="btn btn-block btn-primary">Create Keyword</button>
          </form>
        </div>

        <div class="card-footer">
          <span class="text-danger"><b>Relevant keywords help patients in locating relevant doctors easily.</b></span>
        </div>
      </div>
    @endcan

    <div class="p-3 shadow bg-white text-center">
      Medical terms, illnesses, procedures under <b>{{$specialty->name}}</b> 
      <span class="badge badge-primary">{{$specialty->tags->count()}}</span>.
      
      <hr>
      
      @foreach ($specialty->tags as $tag)
        <span class="keyword-labels" title="{{$tag->description}}">
          <a href="{{ route('tags.show', $tag) }}">{{ $tag->name }}</a>
        </span>
      @endforeach
    </div>
  </div>
</div>


@can('edit', $specialty)
  <div class="modal bg-transparent" tabindex="-1" role="dialog" id="specialtyUpdateForm" style="display:none;" aria-labelledby="specialtyUpdateFormLabel" aria-hidden="true">
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
                <h5>Update the Specialty: <strong><i class="fa fa-tags"></i>&nbsp;{{$specialty->name}}</strong> </h5>
              </div>
            </div>

            <div class="card-body">
              
              <form action="{{route('specialties.update', $specialty)}}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }} 

                <div class="form-group">
                  <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $specialty->name }}" placeholder="specialty name" required>

                  @if ($errors->has('name'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('name') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"  style="min-height: 100px;max-height: 150px;" placeholder="description" required>{{ $specialty->description }}</textarea>

                  @if ($errors->has('description'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('description') }}</strong>
                      </span>
                  @endif
                </div>

                <button type="submit" class="btn btn-block btn-primary">Update Specialty</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endcan

@endsection