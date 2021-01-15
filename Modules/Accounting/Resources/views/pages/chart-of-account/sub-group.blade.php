@foreach($subGroups as $subGroup)
    <ol class="dd-list">
        <li class="dd-item">
            <button data-action="collapse" type="button" style="">Collapse</button>
            <button data-action="expand" type="button" style="display: none;">Expand</button>
            <div class="dd-handle">
                {{ $subGroup->name }}
            </div>
        </li>
        @if(count($subGroup->subGroup))
            @include('ppc::pages.taskcard-group.sub-group',['subGroups' => $subGroup->subGroup])
        @endif
    </ol>
@endforeach