<form action="{{ route('reviews.store') }}" method="post" 
  class="mb-2 p-3 bg-dark d-block text-center" style="border-radius: 4px;">
  {{ csrf_field() }}  
  <input type="hidden" name="appointment_id" value="{{$appointment->id}}">
  <input type="hidden" name="doctor_id" value="{{$appointment->doctor_id}}">
  <h5 class="border-bottom p-2">Rate This Service</h5>

  <span class="d-inline-block mb-3">Star Rating: 
    <br>
    <small>(1 = lowest, highest = 5)</small>
  </span>

  <div class="table-responsive">
    <small class="text-muted mb-2">
      <span class="tf-flex text-center text-muted mb-3">

        <label class="px-2 mr-1 bg-light rating-pad" title="Very Unsatisfactory">
          <input value="1" type="radio" name="rating" id="rating-1" class="d-block">
          <span class="fa fa-star text-primary p-0 m-0"></span>
          <br> 1
        </label>

        <label class="px-2 mr-1 bg-light rating-pad" title="Unsatisfatory">
          <input value="2" type="radio" name="rating" id="rating-2" class="d-block">
          <span class="fa fa-star text-primary p-0 m-0"></span>
          <br> 2
        </label>

        <label class="px-2 mr-1 bg-light rating-pad" title="Just Ok">
          <input value="3" type="radio" name="rating" id="rating-3" class="d-block">
          <span class="fa fa-star text-primary p-0 m-0"></span>
          <br> 3
        </label>

        <label class="px-2 mr-1 bg-light rating-pad" title="Satisfactory">
          <input value="4" type="radio" name="rating" id="rating-4" class="d-block">
          <span class="fa fa-star text-primary p-0 m-0"></span>
          <br> 4
        </label>

        <label class="px-2 mr-0 bg-light rating-pad" title="Excellent! Very Satisfactory">
          <input value="5" type="radio" name="rating" id="rating-5" class="d-block">
          <span class="fa fa-star text-primary p-0 m-0"></span>
          <br> 5
        </label>
      </span>
    </small>
  </div>

  <textarea name="comment" id="" 
    style="min-height: 70px; max-height: 170px;" 
    class="form-control form-control-sm mb-2" 
    placeholder="write your comment"
    required>{{old('comment')}}</textarea>

  <button class="btn btn-sm my-1 btn-info">Submit Review</button>
</form>