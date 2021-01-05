 

@foreach($menuGroups as $group => $menuGroupRow)
    @php
        $is_modul = false;
    @endphp
    @foreach($menuGroupRow as $menuRow)
        @can('viewAny', $menuRow->menu_class)
            @php
                $is_modul = true;
            @endphp 
        @endcan
        @if( $menuRow->subMenus->count() > 0 )
            @foreach($menuRow->subMenus as $subMenu)
                @can('viewAny', $subMenu->menu_class)
                    @php
                        $is_modul = true;
                    @endphp 
                @endcan
            @endforeach
        @endif
    @endforeach
    @if( $is_modul )
    <li>
        <div class="nav-label text-white p-3 mt-2">{{ $group ?? '' }}</div>
    </li>
    @endif
    @foreach($menuGroupRow as $key => $menuRow)
        @php
            $is_active = null;
            $getActiveClasses = $menuRow->getActiveClasses();
            if ( !empty($getActiveClasses) ) {
                foreach( $getActiveClasses as $classRow ) {
                    if( request()->is($classRow) ) $is_active = 'active';
                }
            }                
        @endphp
        @if( sizeof($menuRow->subMenus) == 0 )
            @can('viewAny', $menuRow->menu_class)
                <li class="nav-first-level {{ $is_active }}">
                    <a href="{{ $menuRow->renderLink() }}"><i class="fa {{ $menuRow->menu_icon ?? null }}"></i> <span class="nav-label">{{ $menuRow->menu_text ?? '' }}</span></a>
                </li>
            @endcan
        @else
            <li class="nav-first-level {{ $is_active }}">
                <a href="#"><i class="fa {{ $menuRow->menu_icon ?? '' }}"></i> <span class="nav-label">{{ $menuRow->menu_text ?? '' }}</span><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level collapse">
                    @if( $menuRow->subMenus()->count() > 0)
                        @foreach($menuRow->subMenus as $subMenuRow)
                            @can('viewAny', $subMenuRow->menu_class)
                            @php
                                $is_active_sub = null;
                                $getActiveClassesSub = $subMenuRow->getActiveClasses();
                                if ( !empty($getActiveClassesSub) ) {
                                    foreach( $getActiveClassesSub as $classRow ) {
                                        if( request()->is($classRow) ) $is_active_sub = 'active';
                                    }
                                }                
                            @endphp
                            <li class="{{ $is_active_sub }}">
                                <a href="{{ $subMenuRow->renderLink() }}">
                                    <div class="nav-second-table-group">
                                        <span>
                                            <i class="fa {{ $subMenuRow->menu_icon ?? '' }}"></i>
                                        </span>
                                        <span>{{ $subMenuRow->menu_text ?? '' }}</span>
                                    </div>
                                </a>
                            </li>
                            @endcan
                        @endforeach
                    @endif
                </ul>
            </li>
        @endif
    @endforeach
@endforeach