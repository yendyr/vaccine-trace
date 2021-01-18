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
                            @if (Auth::user()->name == 'Super Admin')
                                @foreach($menuRow->subMenus as $subMenuRow)
                                    @if( $subMenuRow->subMenus()->count() > 0 )
                                        <li class="{{ $subMenuRow->isActive(request()) }}">
                                            <a href="#">
                                                <span>
                                                    <i class="fa {{ $subMenuRow->menu_icon ?? '' }}"></i>
                                                </span>
                                                <span class="nav-label">{{ $subMenuRow->menu_text ?? '' }} </span>
                                                <span class="fa arrow"></span>
                                            </a>
                                            <ul class="nav nav-third-level">
                                                @foreach( $subMenuRow->subMenus as $subMenuThirdLevel)
                                                <li class="{{ $subMenuThirdLevel->isActive(request()) }}">
                                                    <a href="{{ $subMenuThirdLevel->renderLink() }}">
                                                        <span>
                                                            <i class="fa {{ $subMenuThirdLevel->menu_icon ?? '' }}"></i>
                                                        </span>
                                                        <span>{{ $subMenuThirdLevel->menu_text ?? '' }} </span>
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @else
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
                                    @endif
                                @endforeach
                            @else
                                @if( $subMenuRow->subMenus()->count() > 0 )
                                    @can('viewAny', $subMenuRow->menu_class)
                                        <li class="{{ $subMenuRow->isActive(request()) }}">
                                            <a href="#">
                                                <div class="nav-second-table-group">
                                                    <span>
                                                        <i class="fa {{ $subMenuRow->menu_icon ?? '' }}"></i>
                                                    </span>
                                                    <span>{{ $subMenuRow->menu_text ?? '' }}</span>
                                                    <span class="fa arrow"></span>
                                                </div>
                                            </a>
                                            <ul class="nav nav-third-level">
                                                @foreach( $subMenuRow->subMenus as $subMenuThirdLevel)
                                                <li class="{{ $subMenuThirdLevel->isActive(request()) }}">
                                                    <a href="{{ $subMenuThirdLevel->renderLink() }}">
                                                        <span>
                                                            <i class="fa {{ $subMenuThirdLevel->menu_icon ?? '' }}"></i>
                                                        </span>
                                                        <span>{{ $subMenuThirdLevel->menu_text ?? '' }}</span>
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endcan
                                @else
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
                                @endif
                            @endif
                        @endif
                    </ul>
                </li>
            @endif
        @endif
    @endforeach
@endforeach