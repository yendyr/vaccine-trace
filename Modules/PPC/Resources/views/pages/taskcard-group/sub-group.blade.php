@foreach($subGroups as $subGroup)
    <ul>
        <li>
            {{ $subGroup->name }}
        </li>
        @if(count($subGroup->subGroup))
            @include('ppc::pages.taskcard-group.sub-group',['subGroups' => $subGroup->subGroup])
        @endif
    </ul>
@endforeach