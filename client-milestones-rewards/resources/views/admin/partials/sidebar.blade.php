<aside class="app-sidebar sticky" id="sidebar">
  <div class="main-sidebar" id="sidebar-scroll">
    <div id="responsive-overlay"></div>


    <nav class="main-menu-container nav nav-pills flex-column sub-open">

      <div class="main-sidebar-header mb-24">
        <a href="{{ url('/admin/dashboard') }}" class="header-logo">
          <img src="{{ asset('admin/assets/images/brand-logos/desktop-logo.png') }}" alt="logo" class="desktop-logo">
          <img src="{{ asset('admin/assets/images/brand-logos/toggle-logo.png') }}" alt="logo" class="toggle-logo">
          <img src="{{ asset('admin/assets/images/brand-logos/desktop-dark.png') }}" alt="logo" class="desktop-dark">
          <img src="{{ asset('admin/assets/images/brand-logos/toggle-dark.png') }}" alt="logo" class="toggle-dark">
        </a>
      </div>

      <ul class="main-menu">

        <li class="slide__category"><span class="category-name">Main Menu</span></li>

        {{-- Admin dropdown --}}
        <li class="slide has-sub">
          <a href="javascript:void(0);" class="side-menu__item">
            <i class="bx bx-home side-menu__icon"></i>
            <span class="side-menu__label">Admin</span>
            <i class="fe fe-chevron-right side-menu__angle"></i>
          </a>

          <ul class="slide-menu child1">
            <li class="slide side-menu__label1">
              <a href="javascript:void(0)">Admin</a>
            </li>
            <li class="slide">
              <a href="{{ url('/admin/dashboard') }}" class="side-menu__item">Dashboard</a>
            </li>
            <li class="slide">
              <a href="{{ url('/admin/milestones') }}" class="side-menu__item">Milestones</a>
            </li>
            <li class="slide">
              <a href="{{ url('/admin/rewards') }}" class="side-menu__item">Rewards</a>
            </li>
            <li class="slide">
              <a href="{{ url('/admin/logs') }}" class="side-menu__item">Logs / Audit</a>
            </li>
            <li class="slide">
              <a href="{{ url('/admin/manual-trigger') }}" class="side-menu__item">Manual Trigger</a>
            </li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>
</aside>
