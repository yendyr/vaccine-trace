@if (sizeOf($Taskcard->document_libraries) > 0)
@foreach ($Taskcard->document_libraries as $document_library)
    <label class="label label-success">{{ $document_library->name }}</label>
@endforeach
@endif