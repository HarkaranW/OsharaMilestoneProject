{{-- Search Modal (Template-compatible) --}}
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">

        <div class="input-group">
          <a href="javascript:void(0);" class="input-group-text" id="Search-Grid">
            <i class="fe fe-search header-link-icon fs-18"></i>
          </a>

          <input
            type="search"
            class="form-control border-0 px-2"
            placeholder="Search"
            aria-label="Search"
          >

          <a href="javascript:void(0);" class="input-group-text" id="voice-search">
            <i class="fe fe-mic header-link-icon"></i>
          </a>

          <a href="javascript:void(0);" class="btn btn-light btn-icon" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fe fe-more-vertical"></i>
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
            <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a></li>
          </ul>
        </div>

        <div class="mt-4">
          <p class="font-weight-semibold text-muted mb-2">Are You Looking For.</p>

          <span class="search-tags">
            <i class="fe fe-user me-2"></i>People
            <a href="javascript:void(0)" class="tag-addon"><i class="fe fe-x"></i></a>
          </span>

          <span class="search-tags">
            <i class="fe fe-file-text me-2"></i>Pages
            <a href="javascript:void(0)" class="tag-addon"><i class="fe fe-x"></i></a>
          </span>

          <span class="search-tags">
            <i class="fe fe-align-left me-2"></i>Articles
            <a href="javascript:void(0)" class="tag-addon"><i class="fe fe-x"></i></a>
          </span>
        </div>

        <div class="mt-4">
          <p class="font-weight-semibold text-muted mb-2">Quick Links</p>
          <div class="list-group">

            <a class="list-group-item list-group-item-action" href="{{ url('/admin/dashboard') }}">
              <i class="fe fe-home me-2"></i> Dashboard
            </a>

            <a class="list-group-item list-group-item-action" href="{{ url('/admin/milestones') }}">
              <i class="fe fe-flag me-2"></i> Milestones
            </a>

            <a class="list-group-item list-group-item-action" href="{{ url('/admin/rewards') }}">
              <i class="fe fe-gift me-2"></i> Rewards
            </a>

            <a class="list-group-item list-group-item-action" href="{{ url('/admin/logs') }}">
              <i class="fe fe-list me-2"></i> Logs / Audit
            </a>

            <a class="list-group-item list-group-item-action" href="{{ url('/admin/manual-trigger') }}">
              <i class="fe fe-zap me-2"></i> Manual Trigger
            </a>

          </div>
        </div>

        <div class="mt-4 d-flex justify-content-end gap-2">
          <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>
</div>
