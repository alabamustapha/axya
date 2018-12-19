<div class="card shadow">
  <div class="card-header">
    <div class="card-title">
      <div class="border-bottom" style="font-size:12px;">
        <span class="text-bold border-bottom">
          <i class="fa fa-info"></i> Consultation Reason: 
        </span>
        <p>
          {{ $prescription->appointment->patient_info }}
        </p>
      </div>

      <div>
        Attending Doctor: 

        <a href="{{ route('doctors.show', $prescription->doctor) }}" target="_blank" style="color:#6c757d !important;">
          {{ $prescription->doctor->name }}
        </a>
      </div>
    </div>
  </div>

  <div class="card-body p-3">

    <div>          
      <h5 class="border-bottom">Drugs:</h5>

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