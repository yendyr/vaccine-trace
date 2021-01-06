 

@foreach($menuGroups as $group => $menuGroupRow)
    @if( $menuGroupRow->random()->moduleHasActiveSubMenus(request()) > 0 )
    <li>
        <div class="nav-label text-white p-3 mt-2">{{ $group ?? '' }}</div>
    </li>
    @endif
    @foreach($menuGroupRow as $key => $menuRow)
        @if( sizeof($menuRow->subMenus) == 0 )
            @can('viewAny', $menuRow->menu_class)
                <li class="nav-first-level {{ $menuRow->isActive(request()) }}">
                    <a href="{{ $menuRow->renderLink() }}"><i class="fa {{ $menuRow->menu_icon ?? null }}"></i> <span class="nav-label">{{ $menuRow->menu_text ?? '' }}</span></a>
                </li>
            @endcan
        @else
            @if($menuRow->hasActiveSubMenus(request()) > 0)
                <li class="nav-first-level {{ $menuRow->isActive(request()) }}">
                    <a href="#"><i class="fa {{ $menuRow->menu_icon ?? '' }}"></i> <span class="nav-label">{{ $menuRow->menu_text ?? '' }}</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse">
                        @if( $menuRow->subMenus()->count() > 0)
                            @foreach($menuRow->subMenus as $subMenuRow)
                                @can('viewAny', $subMenuRow->menu_class)
                                <li class="{{ $subMenuRow->isActive(request()) }}">
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
        @endif
    @endforeach
@endforeach