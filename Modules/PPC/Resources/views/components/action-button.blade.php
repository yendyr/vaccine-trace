<div class="pr-1">
@isset($closeable)
    @if($closeable == 'button')
        <button class="{{ $editButtonClass ?? 'editBtn' }} btn btn-sm btn-outline btn-primary ml-1 white-bg" value="{{ $closeValue }}" data-toggle="tooltip" title="Close">
            <i class="fa fa-edit"></i></button>
    @elseif($closeable == 'a')
        <a href="{{ $href }}" class="edit btn btn-sm btn-outline btn-primary ml-1 white-bg" data-toggle="tooltip" title="Close">
            <i class="fa fa-edit"></i></a>
    @endif
@endisset

@isset($executeable)
    @if($executeable == 'button')
        <button class="{{ $executeButtonClass ?? 'executeBtn' }} btn btn-sm btn-outline btn-info ml-1 white-bg" value="{{ $executeValue }}" data-toggle="tooltip" title="Execute">
            <i class="fa fa-paste"></i> {{ $executeText ?? 'Execute'}}</button>
    @elseif($executeable == 'a')
        <a href="{{ $href }}" class="execute btn btn-sm btn-outline btn-info ml-1 white-bg" data-toggle="tooltip" title="Execute">
            <i class="fa fa-paste"></i> {{ $executeText ?? 'Execute'}}</a>
    @endif
@endisset

@isset($defectable)
    <button type="button" name="defect" class="{{ $defectButtonClass ?? 'defectBtn' }} btn btn-sm btn-outline btn-danger pr-2" data-toggle="tooltip" title="Defect" value="{{ (isset($defectId) ? $defectId : '') }}">
        <i class="fa fa-trash"></i>
    </button>
@endisset

@isset($printable)

@endisset

@isset($approvable)
@if($approvable == true)
    <button type="button" class="approveBtn btn btn-sm btn-outline btn-success pr-2" data-toggle="tooltip" title="Approve" value="{{ $approveId }}">
        <i class="fa fa-check-circle"></i>
    </button>
@endif
@endisset

@isset($usable)
    <button type="button" class="useBtn btn btn-sm btn-outline btn-success text-nowrap pr-2" data-toggle="tooltip" title="Use" value="{{ $idToUse }}">
            <i class="fa fa-check-square-o"></i>&nbsp;Use
    </button>
@endisset

@isset($viewable)
    <button type="button" class="viewBtn btn btn-sm btn-outline btn-primary text-nowrap pr-2" data-toggle="tooltip" title="View" value="{{ $idToView }}">
            <i class="fa fa-search"></i>&nbsp;View
    </button>
@endisset

</div>