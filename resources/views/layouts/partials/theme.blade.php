@php
    $__saved = session('business.theme_settings') ?? [];
    $__theme = [];
    foreach (\App\Support\Theme::DEFAULTS as $__key => $__fallback) {
        $__theme[$__key] = \App\Support\Theme::hex($__saved[$__key] ?? null, $__fallback);
    }

    $__primary = $__theme['primary_color'];
    $__success = $__theme['success_color'];
    $__warning = $__theme['warning_color'];
    $__danger = $__theme['danger_color'];
    $__info = $__theme['info_color'];
    $__header = $__theme['header_color'];
    $__sidebar = $__theme['sidebar_color'];
@endphp
<style>
:root {
    --ui-header: {{ $__header }};
    --ui-header-2: {{ \App\Support\Theme::shade($__header, -12) }};
    --ui-on-header: {{ \App\Support\Theme::on($__header) }};
    --ui-sidebar: {{ $__sidebar }};
    --ui-sidebar-2: {{ \App\Support\Theme::shade($__sidebar, 10) }};
    --ui-on-sidebar: {{ \App\Support\Theme::on($__sidebar) }};
    --ui-brand: {{ $__primary }};
    --ui-brand-2: {{ \App\Support\Theme::shade($__primary, 12) }};
    --ui-primary: {{ $__primary }};
    --ui-primary-hover: {{ \App\Support\Theme::shade($__primary, -14) }};
    --ui-primary-rgb: {{ \App\Support\Theme::rgb($__primary) }};
    --ui-on-primary: {{ \App\Support\Theme::on($__primary) }};
    --ui-success: {{ $__success }};
    --ui-success-hover: {{ \App\Support\Theme::shade($__success, -14) }};
    --ui-success-rgb: {{ \App\Support\Theme::rgb($__success) }};
    --ui-on-success: {{ \App\Support\Theme::on($__success) }};
    --ui-warning: {{ $__warning }};
    --ui-warning-hover: {{ \App\Support\Theme::shade($__warning, -14) }};
    --ui-warning-rgb: {{ \App\Support\Theme::rgb($__warning) }};
    --ui-on-warning: {{ \App\Support\Theme::on($__warning) }};
    --ui-danger: {{ $__danger }};
    --ui-danger-hover: {{ \App\Support\Theme::shade($__danger, -14) }};
    --ui-danger-rgb: {{ \App\Support\Theme::rgb($__danger) }};
    --ui-on-danger: {{ \App\Support\Theme::on($__danger) }};
    --ui-info: {{ $__info }};
    --ui-info-hover: {{ \App\Support\Theme::shade($__info, -14) }};
    --ui-info-rgb: {{ \App\Support\Theme::rgb($__info) }};
    --ui-on-info: {{ \App\Support\Theme::on($__info) }};
}

body.hold-transition .main-header .navbar {
    background: linear-gradient(135deg, var(--ui-header) 0%, var(--ui-brand) 58%, var(--ui-primary) 100%) !important;
}
body.hold-transition .main-header .logo,
body.hold-transition .main-sidebar .logo {
    background: var(--ui-header) !important;
    color: var(--ui-on-header) !important;
}
body.hold-transition .main-header .logo:hover,
body.hold-transition .main-sidebar .logo:hover {
    background: var(--ui-header-2) !important;
}
body.hold-transition .main-header .navbar .nav > li > a,
body.hold-transition .main-header .navbar .sidebar-toggle {
    color: var(--ui-on-header) !important;
}
body.hold-transition .main-header li.user-header {
    background-color: var(--ui-header) !important;
}

body.hold-transition.sidebar-mini .main-sidebar,
body.hold-transition.sidebar-mini .main-sidebar .sidebar,
body.hold-transition.sidebar-mini .main-sidebar .user-panel {
    background-color: var(--ui-sidebar) !important;
}
body.hold-transition.sidebar-mini .sidebar-menu > li > a,
body.hold-transition.sidebar-mini .sidebar-menu > li.header,
body.hold-transition.sidebar-mini .sidebar-menu .treeview-menu > li > a {
    color: var(--ui-on-sidebar) !important;
}
body.hold-transition.sidebar-mini .sidebar-menu > li.header {
    opacity: .72;
}
body.hold-transition.sidebar-mini .sidebar-menu > li:hover > a,
body.hold-transition.sidebar-mini .sidebar-menu > li.menu-open > a {
    background: var(--ui-sidebar-2) !important;
    color: var(--ui-on-sidebar) !important;
}
body.hold-transition.sidebar-mini .sidebar-menu > li.active > a {
    background: var(--ui-primary) !important;
    color: var(--ui-on-primary) !important;
    border-left-color: var(--ui-primary) !important;
}
body.hold-transition.sidebar-mini .sidebar-menu > li > .treeview-menu {
    background: var(--ui-sidebar-2) !important;
}

.pagination > .active > a,
.pagination > .active > span,
.nav-pills > li.active > a,
.label-primary,
.badge-primary,
.bg-primary {
    background-color: var(--ui-primary) !important;
    border-color: var(--ui-primary) !important;
    color: var(--ui-on-primary) !important;
}
.text-primary,
a.text-primary {
    color: var(--ui-primary) !important;
}
.box.box-primary {
    border-top-color: var(--ui-primary) !important;
}
.box.box-success { border-top-color: var(--ui-success) !important; }
.box.box-warning { border-top-color: var(--ui-warning) !important; }
.box.box-danger { border-top-color: var(--ui-danger) !important; }
.box.box-info { border-top-color: var(--ui-info) !important; }

.content-header-custom.home-hero {
    background:
        radial-gradient(1200px 280px at 88% -40%, rgba(255,255,255,.18), transparent 55%),
        linear-gradient(135deg, var(--ui-header) 0%, var(--ui-brand) 52%, var(--ui-primary) 100%) !important;
}
</style>
