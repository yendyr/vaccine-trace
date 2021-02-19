@if (sizeOf($Taskcard->zones) > 0)
<p class="m-b-xs">
@foreach ($Taskcard->zones as $zone)
    <label class="label label-warning">{{ $zone->name }}</label>
@endforeach
</p>
@else    
    <p class="m-b-xs">    
        <label class="text-success">-</label>
    </p>
@endif