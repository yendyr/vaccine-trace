<div class="pr-1">
@switch($status)
@case(array_search('open', config('ppc.job-card.transaction-status')))
    @isset($executeable)
        @if($executeable == 'button')
            <button href="{{ $executeHref ?? '#' }}" class="{{ $executeButtonClass ?? 'executeBtn' }} btn btn-sm btn-outline btn-info ml-1 white-bg" value="{{ $executeValue ?? null }}" data-next-status="progress" data-toggle="tooltip" title="Execute">
                <i class="fa fa-play"></i> {{ $executeText ?? 'Execute'}}</button>
        @elseif($executeable == 'a')
            <a href="{{ $executeHref ?? '#' }}" class="{{ $executeButtonClass ?? 'executeBtn' }} btn btn-sm btn-outline btn-info ml-1 white-bg" data-next-status="progress" data-toggle="tooltip" title="Execute">
                <i class="fa fa-play"></i> {{ $executeText ?? 'Execute'}}</a>
        @endif
    @endisset
@break

@case(array_search('progress', config('ppc.job-card.transaction-status')))
    @isset($pauseable)
        @if($pauseable == 'button')
            <button href="{{ $pauseHref ?? '#' }}" class="{{ $pauseButtonClass ?? 'pauseBtn' }} btn btn-sm btn-outline btn-warning ml-1 white-bg" value="{{ $pauseValue ?? null }}" data-next-status="pause" data-toggle="tooltip" title="Pause">
                <i class="fa fa-pause"></i> {{ $pauseText ?? 'Pause' }}</button>
        @elseif($pauseable == 'a')
            <a href="{{ $pauseHref ?? '#' }}" class="pause btn btn-sm btn-outline btn-warning ml-1 white-bg" data-next-status="pause" data-toggle="tooltip" title="Pause">
                <i class="fa fa-pause"></i> {{ $pauseText ?? 'Pause' }}</a>
        @endif
    @endisset

    @isset($closeable)
        @if($closeable == 'button')
            <button href="{{ $closeHref ?? '#' }}" class="{{ $closeButtonClass ?? 'closeBtn' }} btn btn-sm btn-outline btn-info ml-1 white-bg" value="{{ $closeValue ?? null }}" data-next-status="close" data-toggle="tooltip" title="Close">
                <i class="fa fa-stop"></i> {{ $closeText ?? 'Close' }}</button>
        @elseif($closeable == 'a')
            <a href="{{ $closeHref ?? '#' }}" class="close btn btn-sm btn-outline btn-info ml-1 white-bg" data-next-status="close" data-toggle="tooltip" title="Close">
                <i class="fa fa-stop"></i> {{ $closeText ?? 'Close' }}</a>
        @endif
    @endisset

    @isset($defectable)
        @if($defectable == 'button')
            <button href="{{ $defectHref ?? '#' }}" class="{{ $defectButtonClass ?? 'defectBtn' }} btn btn-sm btn-outline btn-warning ml-1 white-bg" value="{{ $defectValue ?? null }}" data-toggle="tooltip" title="Found Defect">
                <i class="fa fa-search-plus"></i> {{ $defectText ?? 'Found Defect' }}</button>
        @elseif($defectable == 'a')
            <a href="{{ $defectHref ?? '#' }}" class="defect btn btn-sm btn-outline btn-warning ml-1 white-bg" data-toggle="tooltip" title="Found Defect">
                <i class="fa fa-search-plus"></i> {{ $defectText ?? 'Found Defect' }}</a>
        @endif
    @endisset
@break

@case(array_search('pause', config('ppc.job-card.transaction-status')))
    @isset($resumeable)
        @if($resumeable == 'button')
            <button href="{{ $resumeHref ?? '#' }}" class="{{ $resumeButtonClass ?? 'resumeBtn' }} btn btn-sm btn-outline btn-info ml-1 white-bg" value="{{ $resumeValue ?? null }}" data-next-status="progress" data-toggle="tooltip" title="Resume">
                <i class="fa fa-play"></i> {{ $resumeText ?? 'Resume'}}</button>
        @elseif($resumeable == 'a')
            <a href="{{ $resumeHref ?? '#' }}" class="{{ $resumeButtonClass ?? 'resumeBtn' }} btn btn-sm btn-outline btn-info ml-1 white-bg" data-next-status="progress" data-toggle="tooltip" title="Resume">
                <i class="fa fa-play"></i> {{ $resumeText ?? 'Resume'}}</a>
        @endif
    @endisset
    @isset($closeable)
        @if($closeable == 'button')
            <button href="{{ $closeHref ?? '#' }}" class="{{ $closeButtonClass ?? 'closeBtn' }} btn btn-sm btn-outline btn-danger ml-1 white-bg" value="{{ $closeValue ?? null }}" data-next-status="close" data-toggle="tooltip" title="Close">
                <i class="fa fa-stop"></i> {{ $closeText ?? 'Close' }}</button>
        @elseif($closeable == 'a')
            <a href="{{ $closeHref ?? '#' }}" class="close btn btn-sm btn-outline btn-danger ml-1 white-bg" data-next-status="close" data-toggle="tooltip" title="Close">
                <i class="fa fa-stop"></i> {{ $closeText ?? 'Close' }}</a>
        @endif
    @endisset

    @isset($defectable)
        <button type="button" name="defect" class="{{ $defectButtonClass ?? 'defectBtn' }} btn btn-sm btn-outline btn-danger pr-2" data-toggle="tooltip" title="Defect" value="{{ (isset($defectId) ? $defectId : '') }}">
            <i class="fa fa-trash"></i>
        </button>
    @endisset
@break
@case(array_search('close', config('ppc.job-card.transaction-status')))
    @isset($releaseable)
        @if($releaseable == 'button')
            <button href="{{ $releaseHref ?? '#' }}" class="{{ $releaseButtonClass ?? 'releaseBtn' }} btn btn-sm btn-outline btn-info ml-1 white-bg" value="{{ $releaseValue ?? null }}" data-next-status="release" data-toggle="tooltip" title="Release">
                <i class="fa fa-check"></i> {{ $releaseText ?? 'Release' }}</button>
        @elseif($releaseable == 'a')
            <a href="{{ $releaseHref ?? '#' }}" class="release btn btn-sm btn-outline btn-info ml-1 white-bg" data-next-status="release" data-toggle="tooltip" title="Release">
                <i class="fa fa-check"></i> {{ $releaseText ?? 'Release' }}</a>
        @endif
    @endisset
@break
@endswitch

@isset($printable)

@endisset

@isset($approvable)
@if($approvable == true)
    <button type="button" class="approveBtn btn btn-sm btn-outline btn-success pr-2" data-toggle="tooltip" title="Approve" value="{{ $approveId }}">
        <i class="fa fa-check-circle"></i>
    </button>
@endif
@endisset
</div>