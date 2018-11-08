@extends('layouts.master')

@section('meta-description', $tag->name)
@section('meta-keywords', '')

@section('title', $tag->name)

@section('content')

<div class="row">
  <div class="col-md-8">
      <div class="card shadow-sm">
          <div class="card-body">
            {{--@can('edit', $tag)--}}
              <span class="mr-3">              
                <button id="navbarDropdown" class="btn btn-sm dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cog"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                    <button class="dropdown-item" data-toggle="modal" data-target="#tagUpdateForm" title="Update Keyword">
                      <i class="fa fa-edit teal"></i>&nbsp; edit
                    </button>
                    <form method="post" action="{{route('tags.destroy', $tag)}}">
                      @csrf
                      {{ method_field('DELETE') }} 
                      <button type="submit" class="dropdown-item" onclick="return confirm('You really want to delete this tag?');" title="Delete Keyword">
                        <i class="fa fa-trash red"></i>&nbsp; delete
                      </button>
                    </form>
                </div>
              </span>
            {{--@endcan--}}
            <span>
              <b>{{ $tag->name }}</b> - {{ $tag->description }}
            </span>
          </div>
      </div>

      <div class="card-deck">
      {{-- @foreach ($doctors as $doctor) --}}
          <div class="card mr-2" style="min-width: 16rem;max-width: 16rem;">
              <div style="display:block;min-height: 200px;height: 200px;overflow: hidden;">
                  <img class="card-img-top" src="{{ \App\Doctor::first()->dummyAvatar()/*$doctor->user->avatar*/ }}" alt="{{-- $doctor->user->name --}}" style="display:block;min-height: 200px;">
              </div>
              <div class="card-body">
                  <h5 class="card-title">
                      <a href="{{--route('doctors.show', $doctor->user)--}}">{{-- $doctor->user->name --}} Dr. Name</a>
                  </h5>
                  <h6 class="card-subtitle mb-2 text-muted">
                      <a href="#" style="color: inherit;">Spech{{-- $doctor->tag --}}</a>
                  </h6>
                  <p class="card-text">Practice Years: {{random_int(2,10)}}</p>
              </div>
              <div class="card-footer tf-flex">
                  <span>
                      <small class="text-muted">
                          <span class="fa fa-star text-primary"></span>
                          <span class="fa fa-star text-primary"></span>
                          <span class="fa fa-star text-primary"></span>
                          <span class="fa fa-star text-primary"></span>
                          <span class="fa fa-star text-primary"></span>
                      </small>
                      &nbsp;{{random_int(1,5)}}({{random_int(10,100)}})
                  </span>
                  <a href="{{--route('doctors.show', $doctor->user)--}}" class="btn btn-primary btn-sm">View Profile</a>
              </div>
          </div>
          <div class="card mr-2" style="min-width: 16rem;max-width: 16rem;">
              <div style="display:block;min-height: 200px;height: 200px;overflow: hidden;">
                  <img class="card-img-top" src="{{ \App\Doctor::first()->dummyAvatar()/*$doctor->user->avatar*/ }}" alt="{{-- $doctor->user->name --}}" style="display:block;min-height: 200px;">
              </div>
              <div class="card-body">
                  <h5 class="card-title">
                      <a href="{{--route('doctors.show', $doctor->user)--}}">{{-- $doctor->user->name --}} Dr. Name</a>
                  </h5>
                  <h6 class="card-subtitle mb-2 text-muted">
                      <a href="#" style="color: inherit;">Spech{{-- $doctor->tag --}}</a>
                  </h6>
                  <p class="card-text">Practice Years: {{random_int(2,10)}}</p>
              </div>
              <div class="card-footer tf-flex">
                  <span>
                      <small class="text-muted">
                          <span class="fa fa-star text-primary"></span>
                          <span class="fa fa-star text-primary"></span>
                          <span class="fa fa-star text-primary"></span>
                          <span class="fa fa-star text-primary"></span>
                          <span class="fa fa-star text-primary"></span>
                      </small>
                      &nbsp;{{random_int(1,5)}}({{random_int(10,100)}})
                  </span>
                  <a href="{{--route('doctors.show', $doctor->user)--}}" class="btn btn-primary btn-sm">View Profile</a>
              </div>
          </div>
          <div class="card mr-2" style="min-width: 16rem;max-width: 16rem;">
              <div style="display:block;min-height: 200px;height: 200px;overflow: hidden;">
                  <img class="card-img-top" src="{{ \App\Doctor::first()->dummyAvatar()/*$doctor->user->avatar*/ }}" alt="{{-- $doctor->user->name --}}" style="display:block;min-height: 200px;">
              </div>
              <div class="card-body">
                  <h5 class="card-title">
                      <a href="{{--route('doctors.show', $doctor->user)--}}">{{-- $doctor->user->name --}} Dr. Name</a>
                  </h5>
                  <h6 class="card-subtitle mb-2 text-muted">
                      <a href="#" style="color: inherit;">Spech{{-- $doctor->tag --}}</a>
                  </h6>
                  <p class="card-text">Practice Years: {{random_int(2,10)}}</p>
              </div>
              <div class="card-footer tf-flex">
                  <span>
                      <small class="text-muted">
                          <span class="fa fa-star text-primary"></span>
                          <span class="fa fa-star text-primary"></span>
                          <span class="fa fa-star text-primary"></span>
                          <span class="fa fa-star text-primary"></span>
                          <span class="fa fa-star text-primary"></span>
                      </small>
                      &nbsp;{{random_int(1,5)}}({{random_int(10,100)}})
                  </span>
                  <a href="{{--route('doctors.show', $doctor->user)--}}" class="btn btn-primary btn-sm">View Profile</a>
              </div>
          </div>
      {{-- @endforeach --}}
      </div>

  </div>

  <div class="col-md-4">
    {{--@can ('create', App\Tag::class)--}}
  
      @include('tags.partials.create-form')
    
    {{--@endcan--}}

    <div class="bg-white p-3 shadow text-center">
     Medical terms, illnesses, procedures under the specialty <b>{{$tag->specialty->name}}</b>.

      <hr>

      @foreach ($tag->specialty->tags as $tag2)
        <span class="keyword-labels" title="{{ $tag2->description }}">
          <a href="{{ route('tags.show', $tag2) }}" class="d-inline p-1">{{ $tag2->name }}</a>
        </span>
      @endforeach
    </div>

  </div>
</div>

{{--@can('edit', $tag)--}}
  <div class="modal bg-transparent" tabindex="-1" role="dialog" id="tagUpdateForm" style="display:none;" aria-labelledby="tagUpdateFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content px-2 bg-transparent shadow-none">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
          <span aria-hidden="true">&times;</span>
        </button>
        <br>
        <div class="modal-body">

          @include('tags.partials.edit-form')

        </div>
      </div>
    </div>
  </div>
{{--@endcan--}}

@endsection