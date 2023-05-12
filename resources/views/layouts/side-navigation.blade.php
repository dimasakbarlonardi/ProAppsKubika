@if (Session::get('user')->login_user == 'admin@admin.com')
    {{-- main form admin --}}
    <li class="nav-item">
        <!-- label-->
        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
            <div class="col-auto navbar-vertical-label">Main Form</div>
            <div class="col ps-0">
                <hr class="mb-0 navbar-vertical-divider" />
            </div>
        </div>

        <!-- parent pages-->
        <a class="nav-link {{ request()->is('admin/groups*') ? 'active' : '' }}" href="{{ route('groups.index') }}"
            role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                        class="fas fa-users"></span></span><span class="nav-link-text ps-1">Group</span>
            </div>
        </a>

        <!-- parent pages-->
        <a class="nav-link {{ request()->is('admin/penguruses*') ? 'active' : '' }}"
            href="{{ route('penguruses.index') }}" role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                        class="fas fa-user"></span></span><span class="nav-link-text ps-1">Pengurus</span>
            </div>
        </a>

        <!-- parent pages-->
        <a class="nav-link {{ request()->is('admin/sites*') ? 'active' : '' }}" href="{{ route('sites.index') }}"
            role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                        class="fas fa-building"></span></span><span class="nav-link-text ps-1">Site</span>
            </div>
        </a>

        <!-- parent pages-->
        <a class="nav-link" href="#" role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                        class="fas fa-check"></span></span><span class="nav-link-text ps-1">Strata
                    Status</span>
            </div>
        </a>

        <!-- parent pages-->
        <a class="nav-link {{ request()->is('admin/logins*') ? 'active' : '' }}" href="{{ route('logins.index') }}"
            role="button">
            <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                        class="fas fa-lock"></span></span><span class="nav-link-text ps-1">Login</span>
            </div>
        </a>
    </li>
@endif

@foreach (Session::get('side-navigation') as $key => $nav)
    <li class="nav-item">
        <!-- label-->
        <div class="row navbar-vertical-label-wrapper mt-3 mb-2">
            <div class="col-auto navbar-vertical-label">{{ $nav->heading }}</div>
            <div class="col ps-0">
                <hr class="mb-0 navbar-vertical-divider" />
            </div>
        </div>
        @foreach ($nav->menus as $menu)
            @if (count($menu->subMenus) == 0)
                <!-- parent pages-->
                <a class="nav-link {{ request()->is('admin/groups*') ? 'active' : '' }}"
                    href="{{ route($menu->route_name) }}" role="button">
                    <div class="d-flex align-items-center"><span class="nav-link-icon"><span
                                class="{{ $menu->icon }}"></span></span><span
                            class="nav-link-text ps-1">{{ $menu->caption }}</span>
                    </div>
                </a>
            @else
                <a class="nav-link {{ count($menu->subMenus) > 0 ? 'dropdown-indicator' : '' }}"
                    href="#{{ $menu->route_name }}" role="button" data-bs-toggle="collapse" aria-expanded="false"
                    aria-controls="{{ $menu->route_name }}">
                    <div class="d-flex align-items-center">
                        <span class="nav-link-icon"><span class="{{ $menu->icon }}"></span></span><span
                            class="nav-link-text ps-1">{{ $menu->caption }}</span>
                    </div>
                </a>
                <ul class="nav collapse" id="{{ $menu->route_name }}">
                    <li class="nav-item">
                        @if (!$menu->subMenus)
                            <!-- parent pages-->
                            <a class="nav-link" href="" role="button">
                                <div class="d-flex align-items-center">
                                    <span class="nav-link-text ps-1">{{ $menu->subMenus->caption }}</span>
                                </div>
                            </a>
                        @else
                            @foreach ($menu->subMenus as $subMenu)
                                @if (count($subMenu->subMenus2) == 0)
                                    <a class="nav-link" href="{{ route($subMenu->route_name) }}" role="button"
                                        aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text ps-1">{{ $subMenu->caption }}</span>
                                        </div>
                                    </a>
                                @else
                                    <a class="nav-link dropdown-indicator" href="#{{ $subMenu->route_name }}"
                                        role="button" data-bs-toggle="collapse" aria-controls="checklist-monitoring">
                                        <div class="d-flex align-items-center">
                                            <span class="nav-link-text ps-1">{{ $subMenu->caption }}</span>
                                        </div>
                                    </a>
                                @endif
                                <ul class="nav collapse" id="{{ $subMenu->route_name }}">
                                    <li class="nav-item">
                                        @foreach ($subMenu->subMenus2 as $subMenu2)
                                            <a class="nav-link" href="{{ route($subMenu2->route_name) }}">
                                                <div class="d-flex align-items-center">
                                                    <span class="nav-link-text ps-1">{{ $subMenu2->caption }}
                                                    </span>
                                                </div>
                                            </a>
                                            <!-- more inner pages-->
                                        @endforeach
                                    </li>
                                </ul>
                            @endforeach
                        @endif
                    </li>
                </ul>
            @endif
        @endforeach
    </li>
@endforeach
