@if (sizeOf($Taskcard->aircraft_types) > 0)
<p class="m-b-xs">
@foreach ($Taskcard->aircraft_types as $aircraft_type)
    <label class="label label-success">{{ $aircraft_type->name }}</label>
@endforeach
</p>
@endif