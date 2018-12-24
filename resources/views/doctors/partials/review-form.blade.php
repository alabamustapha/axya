<form action="{{ route('reviews.store') }}" method="post" 
  class="mb-2 p-3 bg-dark d-block text-center" style="border-radius: 4px;">
  {{ csrf_field() }}  
  <input type="hidden" name="appointment_id" value="{{$appointment->id}}">
  <input type="hidden" name="doctor_id" value="{{$appointment->doctor_id}}">
  <h5 class="border-bottom p-2">Rate This Service</h5>

  <span class="d-inline-block mb-3">Star Rating: 
    <br>
    <small>(Rated once per service per patient)</small>
  </span>

  <div class="table-responsive">
    <small class="text-muted mb-2">
      <span class="tf-flex text-center text-muted mb-3">
        <span class="px-3 mr-1 bg-light" style="border-radius:4px; cursor: pointer;" title="Very Unsatisfactory">
          <span class="fa fa-star text-primary p-0 m-0"></span>
          <br> 1
        </span>
        <span class="px-3 mr-1 bg-light" style="border-radius:4px; cursor: pointer;" title="Unsatisfatory">
          <span class="fa fa-star text-primary p-0 m-0"></span>
          <br> 2
        </span>
        <span class="px-3 mr-1 bg-light" style="border-radius:4px; cursor: pointer;" title="Just Ok">
          <span class="fa fa-star text-primary p-0 m-0"></span>
          <br> 3
        </span>
        <span class="px-3 mr-1 bg-light" style="border-radius:4px; cursor: pointer;" title="Satisfactory">
          <span class="fa fa-star text-primary p-0 m-0"></span>
          <br> 4
        </span>
        <span class="px-3 mr-0 bg-light" style="border-radius:4px; cursor: pointer;" title="Excellent! Very Satisfactory">
          <span class="fa fa-star text-primary p-0 m-0"></span>
          <br> 5
        </span>
      </span>
    </small>
  </div>

  <textarea name="comment" id="" style="min-height: 70px; max-height: 170px;" class="form-control form-control-sm mb-2" placeholder="write your comment">{{old('comment')}}</textarea>
  <button class="btn btn-sm my-1 btn-info">Submit Review</button>
</form>