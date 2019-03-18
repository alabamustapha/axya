<div class="card shadow">
  <div class="card-header">
    <div class="card-title">

      <div class="tf-flex border-bottom mb-3 pb-2">
          <span class="text-bold">
            <i class="fa fa-calendar-alt"></i> Appointment Details <small class="text-sm"><em>{{ $prescription->created_at }}</em></small>
          </span>
          @if($prescription->canBeDeleted())
          <form action="{{ route('prescriptions.destroy', $prescription) }}" method="post" class="d-inline">
            @csrf
            {{ method_field('DELETE') }}
            <button type="submit" 
              class="btn btn-link btn-xs p-0 bg-transparent"
              onclick="return confirm('Delete this prescription?');" 
              >
              <i class="fa fa-ellipsis-h red" style="font-size: 12px;"></i>
            </button>
          </form>
          @endif
      </div>

      <div class="media">
        @if (Auth::id() === $prescription->doctor->id)

          <a href="{{ route('users.show', $prescription->user) }}" target="_blank" title="{{ $prescription->user->name }}" class="text-muted font-weight-bold pr-2 mr-3">
            <img src="{{ $prescription->user->avatar }}" alt="{{ $prescription->user->name }}" class="img-md img-circle">
          </a>

        @else

          <a href="{{ route('doctors.show', $prescription->doctor) }}" target="_blank" title="{{ $prescription->doctor->name }}" class="text-muted font-weight-bold pr-2 mr-3">
            <img src="{{ $prescription->doctor->avatar }}" alt="{{ $prescription->doctor->name }}" class="img-md img-circle">
          </a>

        @endif
        <div class="media-body">
          <h5 class="mt-0">
            @if (Auth::id() === $prescription->doctor->id)
              <a href="{{ route('users.show', $prescription->user) }}" target="_blank" title="{{ $prescription->user->name }}" class="text-muted font-weight-bold">
                {{ $prescription->user->name }}
              </a>
              (Patient)
            @else
              <a href="{{ route('doctors.show', $prescription->doctor) }}" target="_blank" title="{{ $prescription->doctor->name }}" class="text-muted font-weight-bold">
                {{ $prescription->doctor->name }}
              </a>
              (Attending Doctor)
            @endif
          </h5>

          <p class="text-sm">{{ $prescription->appointment->description }}</p>
        </div>
      </div>

    </div>
  </div>

  <div class="card-body p-3">

    <div>          
      <h3 class="font-weight-bold">Prescriptions:</h3>

      <div class="table-responsive mb-3">
        <table class="table table-sm table-bordered">
          <tr>
            <td>#</td>
            <td>Name</td>
            <td>Texture</td>
            <td>Dosage</td>
            <td>Manufacturer</td>
            {{--  --}}
          </tr>
          @forelse($prescription->drugs as $i => $drug)
          <tbody class="{{(($i % 2) == 0) ? 'bg-light':'bg-dark'}}">
            <tr>
              <td rowspan="2">{{ $i + 1 }}</td>
              <td>{{ $drug->name }}</td>
              <td>{{ $drug->texture }}</td>
              <td>{{ $drug->dosage }}</td>
              <td>{{ $drug->manufacturer }}</td>
            </tr>
            <tr>
              <td colspan="4">
                <span class="text-bold">Usage:&nbsp;</span>
                {{ $drug->usage }}
              </td>
            </tr>
          </tbody>
          @empty
            <tr><td colspan="5" class="empty-list">0 drugs prescribed</td></tr>
          @endforelse
        </table>                    
      </div>

    </div>

    <div>          
      <h5 class="border-bottom">General Usage Information</h5>
      <p>{{$prescription->usage}}</p>
    </div>
  </div>

  @if ($prescription->comment)
  <div class="card-footer">
    <h5 class="border-bottom">Comment</h5>
    <p>{{$prescription->comment}}</p>
  </div>
  @endif
</div>