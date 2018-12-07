<div class="card shadow">
  <div class="card-header">
    <div class="card-title">
      <div class="border-bottom" style="font-size:12px;">
        <span class="text-bold border-bottom">
          <i class="fa fa-info"></i> Consultation Reason: 
        </span>
        <p>
          {{$prescription->appointment->patient_info}}
        </p>
      </div>

      <div>
        Attending Doctor: 
        <strong>
          <a href="{{route('doctors.show', $prescription->doctor)}}" target="_blank">
            {{$prescription->doctor->name}}
          </a>
        </strong>
      </div>
    </div>
  </div>

  <div class="card-body">

    <div>          
      <h5 class="border-bottom">Drugs:</h5>
      <ul class="mb-3">
        @forelse($prescription->drugs as $drug)
            <li>...</li>
        @empty
          <li class="empty-list">0 drugs prescribed</li>
        @endforelse
      </ul>
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