<header class="app-header">
    <div class="main-header-container container-fluid">

        <div class="header-content-left">
            <div class="header-element">
                <div class="horizontal-logo">
                    <a href="{{ url('/admin/dashboard') }}" class="header-logo">
                        <img src="{{ asset('admin/assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
                        <img src="{{ asset('admin/assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
                        <img src="{{ asset('admin/assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
                        <img src="{{ asset('admin/assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
                    </a>
                </div>
            </div>

            <div class="header-element">
                <a aria-label="Hide Sidebar"
                   class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle"
                   data-bs-toggle="sidebar"
                   href="javascript:void(0);">
                    <span></span>
                </a>
            </div>

            <div class="header-element header-search">
                <a href="javascript:void(0);" class="header-link" data-bs-toggle="modal" data-bs-target="#searchModal">
                    <i class="bx bx-search-alt-2 header-link-icon"></i>
                </a>
            </div>
        </div>

        <div class="header-content-right">

            {{-- Theme toggle --}}
            <div class="header-element header-theme-mode">
                <a href="javascript:void(0);" class="header-link layout-setting" id="themeToggle">
                    <span class="light-layout">
                        <i class="bx bx-moon header-link-icon"></i>
                    </span>
                    <span class="dark-layout">
                        <i class="bx bx-sun header-link-icon"></i>
                    </span>
                </a>
            </div>

            {{-- Notifications: real support messages --}}
            <div class="header-element notifications-dropdown">
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <i class="bx bx-bell header-link-icon"></i>
                    <span class="badge bg-primary rounded-pill header-icon-badge">{{ $unreadSupportCount ?? 0 }}</span>
                </a>

                <ul class="main-header-dropdown dropdown-menu dropdown-menu-end">
                    <li>
                        <div class="dropdown-item d-flex justify-content-between align-items-center">
                            <span class="fw-semibold">Support Notifications</span>
                            <span class="badge bg-primary-transparent rounded-pill">{{ $unreadSupportCount ?? 0 }} New</span>
                        </div>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    @forelse(($supportNotifications ?? collect()) as $n)
                        <li>
                            <a href="{{ url('/admin/support-messages/'.$n->id) }}" class="dropdown-item">
                                <div class="d-flex align-items-start">
                                    <div class="pe-2">
                                        <span class="avatar avatar-md bg-primary-transparent rounded-circle">
                                            <i class="ti ti-message-circle fs-18"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0 fw-semibold">{{ $n->subject }}</p>
                                        <span class="text-muted fs-12 d-block">{{ $n->name }} — {{ $n->email }}</span>
                                        <span class="text-muted fs-11">{{ $n->created_at?->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li>
                            <span class="dropdown-item text-muted">No support messages yet.</span>
                        </li>
                    @endforelse

                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a href="{{ url('/admin/support-messages') }}" class="dropdown-item text-center fw-semibold">
                            View all support messages
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Settings --}}
            <div class="header-element">
                <a href="{{ url('/admin/general-settings') }}" class="header-link">
                    <i class="bx bx-cog header-link-icon"></i>
                </a>
            </div>

            {{-- Profile dropdown --}}
            <div class="header-element">
                <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="d-flex align-items-center">
                        <div class="me-sm-2 me-0">
                            <img src="{{ asset('admin/assets/images/faces/9.jpg') }}" alt="img" width="32" height="32" class="rounded-circle">
                        </div>
                        <div class="d-sm-block d-none">
                            <p class="fw-semibold mb-0 lh-1">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <span class="op-7 fw-normal d-block fs-11">{{ auth()->user()->email ?? 'admin@example.com' }}</span>
                        </div>
                    </div>
                </a>

                <ul class="main-header-dropdown dropdown-menu pt-0 header-profile-dropdown dropdown-menu-end">
                    <li>
                        <div class="main-header-profile bg-primary">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <img src="{{ asset('admin/assets/images/faces/9.jpg') }}" alt="img" width="48" height="48" class="rounded-circle">
                                </div>
                                <div>
                                    <p class="mb-0 text-fixed-white fw-semibold">{{ auth()->user()->name ?? 'Admin' }}</p>
                                    <span class="fs-12 op-7 text-fixed-white">{{ auth()->user()->email ?? 'admin@example.com' }}</span>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex" href="{{ url('/profile') }}">
                            <i class="ti ti-user-circle fs-18 me-2 op-7"></i>Profile
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex" href="{{ url('/inbox') }}">
                            <i class="ti ti-mail fs-18 me-2 op-7"></i>Inbox
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex" href="{{ url('/settings') }}">
                            <i class="ti ti-settings fs-18 me-2 op-7"></i>Profile Settings
                        </a>
                    </li>

                    <li>
                        <form method="POST" action="{{ url('/logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex text-danger">
                                <i class="ti ti-logout fs-18 me-2 op-7"></i>Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</header>