<div class="review-content my-2">
  <!-- REVIEW iTEMS  -->
  @forelse ($reviews as $review)
    <div class="media">
      <img src="{{ $review->user->avatar }}" alt="{{ $review->user->name }} avatar" height="50" class="rounded-circle">

      <div class="media-body pl-2 border-bottom pb-3 mb-3">
        <div class="review-head d-flex justify-content-between align-items-center">
          <p class="lead name m-0">
            {{ $review->user->name }}

            {{-- @auth
              @if(Auth::id() == $review->user_id)
                <button class="btn btn-link btn-sm" title="Update this review">
                  <i class="fa fa-cog"></i>
                </button>
              @endif
            @endauth --}}
          </p>
          <span class="text-review review-star">

            @for($i=1; $i <= $review->rating; $i++)
              <i class="fas fa-star"></i>
            @endfor
            
          </span>
        </div>

        <span class="review-time small">{{$review->created_at}}</span>
        <br>

        <span class="review-message">
          {{ $review->comment }}
        </span>
      </div>

    </div>
  @empty
    <p class="list-group-item empty-list">0 reviews</p>
  @endforelse
</div>