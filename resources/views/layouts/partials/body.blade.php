<!-- Main content of the page -->
<div class="app" id="app" style="min-height: 95vh;">
    <!-- Top level navbar -->
@include('layouts.partials.navbar.top')

<!-- Page content -->
    @yield('content')
    <app></app>
</div>

<!-- Core javascript -->
<script src="{{ asset('js/app.js') }}"></script>

<!-- Optional javascript -->
@yield('javascript')

<div class="container-fluid" style="min-height: 5vh;">
    <div class="panel-footer">
        <div class="pull-left">
            <small class="text-muted">
                Copyright 2015-2017; Group YT5. All rights reserved.
            </small>
        </div>
    </div>
</div>