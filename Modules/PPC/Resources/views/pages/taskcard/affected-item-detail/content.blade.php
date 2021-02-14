@if (sizeOf($Taskcard->affected_items) > 0)
<p class="m-b-xs">
@foreach ($Taskcard->affected_items as $affected_item)
    <label class="label label-success">{{ $affected_item->code }} | {{ $affected_item->name }}</label>
@endforeach
</p>
@endif