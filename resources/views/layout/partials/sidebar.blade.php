@if (Auth::user() != null)

    <!-- Sidebar -->
    @if (Route::is(['index-two']))
        <div class="container">
    @endif
    @if (!Route::is(['index-one', 'index-two', 'index-three', 'index-four']))
        <div class="sidebar" id="sidebar">
    @endif
    @if (Route::is(['index-one']))
        <div class="sidebar sidebar-one hide-sidebar" id="sidebar">
    @endif
    @if (Route::is(['index-two']))
        <div class="sidebar sidebar-two" id="sidebar">
    @endif
    @if (Route::is(['index-three']))
        <div class="sidebar sidebar-three hide-sidebar" id="sidebar">
    @endif
    @if (Route::is(['index-four']))
        <div class="sidebar sidebar-four" id="sidebar">
    @endif
    <div class="sidebar-inner slimscroll">
        @if (!Route::is(['index-four']))
            <div id="sidebar-menu" class="sidebar-menu">
        @endif
        @if (!Route::is(['index-two', 'index-four']))
            <ul>
                @if (Session::has('active'))
                    <li>
                        <div style="padding: 10px 15px;">
                            <i class="fas fa-store me-2"></i><span class="badge rounded-pill"
                                style="background: #ff9f43; padding: 10px 15px">{{ Str::headline(Session::get('name')) }}</span>
                        </div>
                    </li>
                @endif
                @foreach ($menus as $menuItem)
                    @if (!isset($menuItem->menu->subMenu[0]))
                        @if ($menuItem->subscribe == 1 && Auth::user()->isSubscribe == 1)
                            <li>
                                <a class="{{ Request::is($menuItem->menu->url) ? 'active' : '' }}"
                                    href="{{ url($menuItem->menu->url) }}"><i
                                        class="{{ $menuItem->menu->icon }}"></i><span>
                                        {{ Str::title($menuItem->menu->name) }}</span> </a>
                            </li>
                        @elseif ($menuItem->subscribe == 0)
                            <li>
                                <a class="{{ Request::is($menuItem->menu->url) ? 'active' : '' }}"
                                    href="{{ url($menuItem->menu->url) }}"><i
                                        class="{{ $menuItem->menu->icon }}"></i><span>
                                        {{ Str::title($menuItem->menu->name) }}</span> </a>
                            </li>
                        @endif
                    @else
                        <?php
                        $subMenuItem = [];
                        foreach ($menuItem->menu->subMenu as $subMenuItems) {
                            array_push($subMenuItem, $subMenuItems->url);
                        }
                        ?>
                        @if ($menuItem->subscribe == 1 && Auth::user()->isSubscribe == 1)
                            <li class="submenu">
                                <a class="{{ Request::is(...$subMenuItem) ? 'active' : '' }}"
                                    href="javascript:void(0);"><i class="{{ $menuItem->menu->icon }}"></i><span>
                                        {{ Str::title($menuItem->menu->name) }}</span> <span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    @foreach ($menuItem->menu->subMenu as $subMenuItems)
                                        <li><a class="{{ Request::is($subMenuItems->url) ? 'active' : '' }}"
                                                href="{{ url($subMenuItems->url) }}">{{ Str::title($subMenuItems->name) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @elseif ($menuItem->subscribe == 0)
                            <li class="submenu">
                                <a class="{{ Request::is(...$subMenuItem) ? 'active' : '' }}"
                                    href="javascript:void(0);"><i class="{{ $menuItem->menu->icon }}"></i><span>
                                        {{ Str::title($menuItem->menu->name) }}</span> <span
                                        class="menu-arrow"></span></a>
                                <ul>
                                    @foreach ($menuItem->menu->subMenu as $subMenuItems)
                                        <li><a class="{{ Request::is($subMenuItems->url) ? 'active' : '' }}"
                                                href="{{ url($subMenuItems->url) }}">{{ Str::title($subMenuItems->name) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endif
                @endforeach
            </ul>
            @if (Session::has('active'))
                <div style="position: absolute; bottom: 1rem;right: 1rem;"><a href="{{ route('owner.deleteSession') }}"
                        class="btn btn-danger mt-2">
                        {{ Str::ucfirst('back select store') }}</a></div>
            @endif
        @endif
    </div>
    </div>
    </div>
    <!-- /Sidebar -->

@endif
