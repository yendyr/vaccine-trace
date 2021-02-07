<div class="pr-1">
@isset($updateable)
    @if($updateable == 'button')
        <button class="{{ $editButtonClass ?? 'editBtn' }} btn btn-sm btn-outline btn-primary ml-1" value="{{ $updateValue }}" data-toggle="tooltip" title="Update">
            <i class="fa fa-edit"></i></button>
    @elseif($updateable == 'a')
        <a href="{{ $href }}" class="edit btn btn-sm btn-outline btn-primary ml-1" data-toggle="tooltip" title="Update">
            <i class="fa fa-edit"></i></a>
    @endif
@endisset

@isset($deleteable)
    <button type="button" name="delete" class="{{ $deleteButtonClass ?? 'deleteBtn' }} btn btn-sm btn-outline btn-danger pr-2" data-toggle="tooltip" title="Delete"
    value="{{ (isset($deleteId) ? $deleteId : '') }}">
        <i class="fa fa-trash"></i>
    </button>
@endisset

@isset($printable)

@endisset

@isset($approvable)
@if($approvable == true)
    <button type="button" class="approveBtn btn btn-sm btn-outline btn-success pr-2" data-toggle="tooltip" title="Approve"
            value="{{ $approveId }}"><i class="fa fa-check-circle"></i>
    </button>
@endif
@endisset

</div>
