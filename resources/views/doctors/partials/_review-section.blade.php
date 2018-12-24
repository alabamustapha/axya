<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">Reviews</h3>
  </div>
  <div class="card-body box-profile">

    <ul class="list-group list-group-unbordered mb-0">
      @forelse ($reviews as $review)
      <li class="list-group-item">
        <span class="tf-flex">
          <span>{{$review->user->name}}:</span>

          @auth
            @if(Auth::id() == $review->user_id)
              <button class="btn btn-link btn-sm" title="Update this review">
                <i class="fa fa-cog"></i>
              </button>
            @endif
          @endauth
        </span>

        <dfn class="text-muted">{{$review->comment}}</dfn> <br> 

        <span class="tf-flex" style="font-size: 10px;">
          <span>
            @for($i=1; $i <= $review->rating; $i++)
              <i class="fa fa-star text-info"></i>
            @endfor
            @for($i=1; $i <= (5 - $review->rating); $i++)
              <i class="fa fa-star text-black-50"></i>
            @endfor
          </span>
          <span>{{$review->created_at}}</span>
        </span>
      </li>
      @empty
        <li class="list-group-item empty-list">0 reviews at the moment</li>
      @endforelse
    </ul>
    <div>
      {{ $reviews->links() }}
    </div>
  </div>
</div>