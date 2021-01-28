@if (sizeOf($Taskcard->document_libraries) > 0)
<p class="m-b-xs">
@foreach ($Taskcard->document_libraries as $document_library)
    <label class="label label-danger">{{ $document_library->name }}</label>
@endforeach
</p>
@endif