<div class="pr-2">
@isset($updateable)
    @if($updateable == 'button')
        <button class="editBtn btn btn-sm btn-outline btn-primary mr-2" value="{{$updateValue}}" data-toggle="tooltip" title="Update">
            <i class="fa fa-edit"></i></button>
    @elseif($updateable == 'a')
        <a href="{{$href}}" class="edit btn btn-sm btn-outline btn-primary mr-2" data-toggle="tooltip" title="Update">
            <i class="fa fa-edit"></i></a>
    @endif
@endisset

@isset($deleteable)
    <button type="button" name="delete" class="delete btn btn-sm btn-outline btn-danger pr-1" id="{{(isset($deleteId) ? $deleteId : '')}}">
        <i class="fa fa-trash"> Delete </i></button>
@endisset

@isset($printable)

@endisset

@isset($approvable)
    <button type="button" class="approveBtn btn btn-sm btn-success mr-2" data-toggle="tooltip" title="Approve {{$approveStatus}}"
            value="{{$approveValue}}"><i class="fa fa-check-circle"></i></button>
@endisset

</div>