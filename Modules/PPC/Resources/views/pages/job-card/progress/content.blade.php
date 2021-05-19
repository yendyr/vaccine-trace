<div class="ibox ">
    <div class="ibox-title">
        <h5>Job Card Activities </h5>
    </div>

    <div class="ibox-content">
        @if( $job_card->progresses()->count() > 0 )
        <div class="activity-stream">
            @foreach( $job_card->progresses as $progress_row)
            <div class="stream">
                <div class="stream-badge">
                    <i class="fa fa-{{ config('ppc.job-card.transaction-icon')[$progress_row->transaction_status] }} bg-{{ config('ppc.job-card.transaction-status-color')[$progress_row->transaction_status] }}"></i>
                </div>
                <div class="stream-panel">
                    <div class="stream-info">
                        <a href="#">
                            <img src="{{
                                        isset(\Illuminate\Support\Facades\Auth::user()->image)
                                        ? URL::asset('uploads/user/img/'.\Illuminate\Support\Facades\Auth::user()->image)
                                        : URL::asset('assets/default-user-image.png')
                                    }}" />
                            <span>{{ $progress_row->creator->name }}</span>
                            <span class="date">{{ Carbon\Carbon::now()->diffForHumans($progress_row->created_at) }} {{ $progress_row->created_at->format('H:i:s') }}</span>
                        </a>
                    </div>
                    {{ ucfirst($progress_row->progress_notes) ?? '-' }}
                    <strong class="text-default">{{ $progress_row->instruction->code ?? $progress_row->taskcard->code ?? '-' }}</strong>
                    ( <strong class="text-{{ config('ppc.job-card.transaction-status-color')[$progress_row->transaction_status] ?? 'success' }}">{{ ucfirst(config('ppc.job-card.transaction-status')[$progress_row->transaction_status]) ?? '-' }} </strong> )
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="font-italic text-center m-t-xl">No progress Found</p>
        @endif
    </div>
</div>