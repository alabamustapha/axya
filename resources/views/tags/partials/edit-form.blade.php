<div class="card card-primary card-outline text-center shadow">
  <div class="card-header">
    <div class="card-title">
      <h5>Update the Tag: <strong><i class="fa fa-tags"></i>&nbsp;{{$tag->name}}</strong> </h5>
    </div>
  </div>

  <div class="card-body">
    
    <form action="{{route('tags.update', $tag)}}" method="post">
      {{ csrf_field() }}
      {{ method_field('PATCH') }} 

      <div class="form-group">
        <select name="specialty_id" class="form-control{{ $errors->has('specialty_id') ? ' is-invalid' : '' }}" value="" required>
          <option value="">Select Specialty</option>
          @foreach($specialties as $specialty)
            <option value="{{ $specialty->id }}" {{ $tag->specialty_id == $specialty->id ? 'selected':'' }}>{{ $specialty->name }}</option>
          @endforeach
        </select>

        @if ($errors->has('specialty_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('specialty_id') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group">
        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $tag->name }}" placeholder="keyword, illness, procedure" required>

        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group">
        <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"  style="min-height: 100px;max-height: 150px;" placeholder="description" required>{{ $tag->description }}</textarea>

        @if ($errors->has('description'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('description') }}</strong>
            </span>
        @endif
      </div>

      <button type="submit" class="btn btn-block btn-primary">Update Keyword</button>
    </form>

  </div>
</div>
