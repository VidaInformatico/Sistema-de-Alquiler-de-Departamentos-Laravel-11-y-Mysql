@include('admin.layouts.partials.head')
<body>
    <div class="container-scroller">
        @include('admin.layouts.partials.navbar')
        <div class="container-fluid page-body-wrapper">
            @include('admin.layouts.partials.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                @include('admin.layouts.partials.footer')
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/admin/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.cookie.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/admin/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/admin/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/admin/js/misc.js') }}"></script>
    <script src="{{ asset('assets/admin/js/all.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>
