  <!-- Sidebar Offcanvas -->
  <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="offcanvasSidebar"
      aria-labelledby="offcanvasSidebarLabel">
      <div class="offcanvas-header border-bottom border-secondary">
          <h5 class="offcanvas-title" id="offcanvasSidebarLabel">{{ config('app.name', 'Laravel') }}</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
          <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
              Dashboard</a>
          <a href="{{ route('roles.index') }}" class="sidebar-link {{ request()->routeIs('roles*') ? 'active' : '' }}">
              Roles & Permissions</a>

      </div>
  </div>
