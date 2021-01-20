@if (sizeOf($Taskcard->zones) > 0)
@foreach ($Taskcard->zones as $zone)
    <label class="label label-warning">{{ $zone->name }}</label>
@endforeach
@endif