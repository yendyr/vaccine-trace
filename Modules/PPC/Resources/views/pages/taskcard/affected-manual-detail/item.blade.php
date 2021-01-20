@if (sizeOf($Taskcard->affected_manuals) > 0)
@foreach ($Taskcard->affected_manuals as $affected_manual)
    <label class="label label-primary">{{ $affected_manual->name ?? '' }}</label>
@endforeach
@endif