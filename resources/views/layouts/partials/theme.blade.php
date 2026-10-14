@php
    $__theme = session('business.theme_settings') ?? [];
    $__has_theme = !empty($__theme['header_color']) || !empty($__theme['sidebar_color']) || !empty($__theme['primary_color']);
@endphp
@if($__has_theme)
<style>
@if(!empty($__theme['header_color']))
    .main-header .navbar,
    .main-header .logo {
        background-color: {{ $__theme['header_color'] }} !important;
    }
    .main-header .navbar,
    .main-header .logo,
    .main-header .navbar .nav > li > a {
        color: #fff !important;
    }
@endif
@if(!empty($__theme['sidebar_color']))
    .main-sidebar,
    .main-sidebar .sidebar,
    .main-sidebar .user-panel {
        background-color: {{ $__theme['sidebar_color'] }} !important;
    }
    .sidebar-menu > li > a,
    .sidebar-menu > li.header {
        color: #fff !important;
    }
@endif
@if(!empty($__theme['primary_color']))
    .btn-primary,
    .bg-primary,
    .label-primary,
    .box.box-primary,
    .pagination > .active > a,
    .nav-pills > li.active > a,
    .sidebar-menu > li.active > a,
    .sidebar-menu > li > a:hover {
        background-color: {{ $__theme['primary_color'] }} !important;
        border-color: {{ $__theme['primary_color'] }} !important;
    }
    .text-primary,
    a.text-primary {
        color: {{ $__theme['primary_color'] }} !important;
    }
@endif
</style>
@endif
