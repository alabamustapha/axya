
      <div class="bg-white p-2 shadow text-center">
        Other medical terms, illnesses, procedures under the specialty <b>{{$tag->specialty->name}}</b>.

        <hr>

        @foreach ($tag->specialty->tags as $tag)
          <span class="keyword-labels">
            <a href="{{ route('tags.show', $tag) }}" class="d-inline p-1">{{ $tag->name }}</a>
          </span>
        @endforeach
      </div>