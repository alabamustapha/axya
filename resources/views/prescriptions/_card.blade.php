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

  <div class="card-body p-3">

    <div>          
      <h5 class="border-bottom">Drugs:</h5>

      <div class="table-responsive mb-3">
        <table class="table table-sm">
          <tr>
            <td>Name</td>
            <td>Texture</td>
            <td>Dosage</td>
            <td>Manufacturer</td>
            <td>Usage</td>
          </tr>
          {{-- @forelse($prescription->drugs as $drug) --}}
            <tr>
              <td>Chloroquine{{--$drug->name--}}</td>
              <td>tablet</td>
              <td>200mg{{--$drug->dosage--}}</td>
              <td>Emzor</td>
              <td>2-2-2{{--$drug->usage--}}</td>
            </tr>
          {{-- @empty
            <tr><td colspan="5" class="empty-list">0 drugs prescribed</td></tr>
          @endforelse --}}
            <tr>
              <td>Piritin</td>
              <td>syrup</td>
              <td>1tp (15ml)</td>
              <td>Drugfield</td>
              <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic a ex unde laudantium? Animi eum sapiente adipisci, voluptas optio quia eligendi quam, ea dignissimos consectetur ipsa aut earum maiores vel.</td>
            </tr>
            <tr>
              <td>Aspirin</td>
              <td>capsule</td>
              <td>20mg</td>
              <td>May and Baker</td>
              <td>1-0-1</td>
            </tr>
            <tr>
              <td>Astimycin</td>
              <td>capsule</td>
              <td>10mg</td>
              <td></td>
              <td>1-0-0</td>
            </tr>
        </table>                    
      </div>
{{-- 
      <ul class="mb-3">
        @forelse($prescription->drugs as $drug)
            <li>...</li>
        @empty
          <li class="bg-light p-3">0 drugs prescribed</li>
        @endforelse
      </ul> --}}

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