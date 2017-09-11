<!-- Main content of the page -->
<div class="app" id="app">
    <!-- Top level navbar -->
@include('layouts.partials.navbar.top')

<!-- Page content -->
    @yield('content')
</div>

<!-- Core javascript -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- Optional javascript -->
@yield('javascript')

<div class="container-fluid">
    <div class="panel-footer">
        <div class="pull-left">
            <small class="text-muted">
                Copyright ©
            </small>
        </div>
    </div>
</div>