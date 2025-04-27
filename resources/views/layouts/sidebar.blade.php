<!-- Sidebar Offcanvas -->
<div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="offcanvasSidebar"
    aria-labelledby="offcanvasSidebarLabel">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title" id="offcanvasSidebarLabel">{{ config('app.name', 'Laravel') }}</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Dashboard Link -->
        @can('view_dashboard')
            <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
                Dashboard
            </a>
        @endcan

        <!-- Roles & Permissions Link -->
        @can('manage_roles_and_permission')
            <a href="{{ route('roles.index') }}" class="sidebar-link {{ request()->routeIs('roles*') ? 'active' : '' }}">
                Roles & Permissions
            </a>
        @endcan

        <!-- Manage Users Link -->
        @can('manage_users')
            <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users*') ? 'active' : '' }}">
                Manage Users
            </a>
        @endcan

        <!-- Manage Tours Link -->
        @can('view_tours')
            <a href="{{ route('tours.index') }}" class="sidebar-link {{ request()->routeIs('tours*') ? 'active' : '' }}">
                Manage Tours
            </a>
        @endcan
    </div>
</div>
