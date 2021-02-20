@if (sizeOf($Taskcard->affected_manuals) > 0)
<p class="m-b-xs">
@foreach ($Taskcard->affected_manuals as $affected_manual)
    <label class="label label-primary">{{ $affected_manual->name ?? '' }}</label>
@endforeach
</p>
@else        
<p class="m-b-xs">    
    <label class="text-success">-</label>
</p>
@endif