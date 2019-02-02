<div>
    <div class="mb-3">
        <h2>
            <div class="tf-flex mb-3">
            {{-- <div class="text-center"> --}}
                <span class="border p-2">
                    <span class="text-muted" style="font-size: 1rem;">Amount:</span>
                    <span class="text-bold">${{$appointment->fee}}</span>
                </span>
                <span class="border p-2">
                    <span class="text-muted" style="font-size: 1rem;">Sessions:</span>
                    <span class="text-bold">{{$appointment->no_of_sessions}}</span>
                </span>

                <span class="border p-2">
                    <span class="text-muted" style="font-size: 1rem;">Duration:</span>
                    <span class="text-bold">{{$appointment->duration}}</span>
                </span>
            </div>
        </h2>
    </div>

    <div class="card shadow-none">
        <div class="card-body pb-0">
            <h5 class="card-title tf-flex text-center">
                <span>
                    <span class="text-muted mb-2" style="font-size: 1rem;">Patient</span>
                    <br>
                    <a href="{{route('users.show', $appointment->user)}}">{{$appointment->user->name}}</a>
                </span>
                <span>
                    <span class="text-muted mb-2" style="font-size: 1rem;">Doctor <small>(${{$appointment->doctor->rate}})</small></span>
                    <br>
                    <a href="{{route('doctors.show', $appointment->doctor)}}">{{$appointment->doctor->name}}</a>
                </span>
            </h5>

            <div class="card-text border-top py-3">
                {{$appointment->description}}
            </div>

            <blockquote class="blockquote">
                <footer class="blockquote-footer">
                    <cite title="{{$appointment->schedule}}">{{$appointment->schedule}}</cite>, {{$appointment->day}}
                </footer>
            </blockquote>
        </div>
    </div>

    <form action="{{route('transactions.store')}}" method="post">
        @csrf
        <input type="hidden" name="appointment_id" value="{{$appointment->id}}">
        <button type="submit" class="btn btn-lg btn-block btn-info">Pay Consultation Fee</button>
    </form>
</div>    