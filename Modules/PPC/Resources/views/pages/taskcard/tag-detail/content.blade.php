@if (sizeOf($Taskcard->tags) > 0)
<p class="m-b-xs">
@foreach ($Taskcard->tags as $tag)
    <label class="label label-warning">{{ $tag->name }}</label>
@endforeach
</p>
@else    
    <p class="m-b-xs">    
        <label class="text-success">-</label>
    </p>
@endif