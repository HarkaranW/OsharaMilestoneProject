{{-- Switcher Offcanvas (Template-compatible container) --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="switcher-canvas" aria-labelledby="offcanvasRightLabel">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title text-default" id="offcanvasRightLabel">Switcher</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body">
    <nav class="border-bottom border-block-end-dashed pb-3">
      <div class="nav nav-tabs nav-justified" id="switcher-main-tab" role="tablist">
        <button class="nav-link active" id="switcher-home-tab" data-bs-toggle="tab"
          data-bs-target="#switcher-home" type="button" role="tab"
          aria-controls="switcher-home" aria-selected="true">
          Theme Styles
        </button>

        <button class="nav-link" id="switcher-profile-tab" data-bs-toggle="tab"
          data-bs-target="#switcher-profile" type="button" role="tab"
          aria-controls="switcher-profile" aria-selected="false">
          Theme Colors
        </button>
      </div>
    </nav>

    <div class="tab-content pt-3" id="nav-tabContent">

      {{-- Theme Styles --}}
      <div class="tab-pane fade show active" id="switcher-home" role="tabpanel" aria-labelledby="switcher-home-tab">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <div>
            <p class="mb-0 fw-semibold">Theme Mode</p>
            <p class="text-muted fs-12 mb-0">Light / Dark</p>
          </div>

          <div class="btn-group" role="group" aria-label="Theme mode">
            <button type="button" class="btn btn-light btn-sm" id="themeLightBtn">Light</button>
            <button type="button" class="btn btn-dark btn-sm" id="themeDarkBtn">Dark</button>
          </div>
        </div>

        <div class="alert alert-light border">
          <div class="d-flex gap-2">
            <i class="fe fe-info mt-1"></i>
            <div class="fs-13">
              This switcher is UI-ready. If your template JS supports theme toggles, it will apply automatically.
              If not, we can wire it with a tiny JS snippet.
            </div>
          </div>
        </div>
      </div>

      {{-- Theme Colors --}}
      <div class="tab-pane fade" id="switcher-profile" role="tabpanel" aria-labelledby="switcher-profile-tab">
        <p class="fw-semibold mb-2">Primary Color</p>
        <div class="d-flex flex-wrap gap-2">
          <button class="btn btn-sm btn-primary">Blue</button>
          <button class="btn btn-sm btn-success">Green</button>
          <button class="btn btn-sm btn-warning">Yellow</button>
          <button class="btn btn-sm btn-danger">Red</button>
          <button class="btn btn-sm btn-dark">Dark</button>
        </div>

        <p class="text-muted fs-12 mt-3 mb-0">
          These are visual placeholders. If you want, we can map them to your template’s data-attributes so it actually changes theme colors.
        </p>
      </div>

    </div>
  </div>
</div>

@push('scripts')
<script>
  // Safe, minimal theme toggle (doesn't require changing CSS files)
  (function () {
    const lightBtn = document.getElementById('themeLightBtn');
    const darkBtn = document.getElementById('themeDarkBtn');

    function setTheme(mode) {
      document.documentElement.setAttribute('data-theme-mode', mode);
      localStorage.setItem('admin.themeMode', mode);
    }

    const saved = localStorage.getItem('admin.themeMode');
    if (saved) setTheme(saved);

    if (lightBtn) lightBtn.addEventListener('click', () => setTheme('light'));
    if (darkBtn) darkBtn.addEventListener('click', () => setTheme('dark'));
  })();
</script>
@endpush
