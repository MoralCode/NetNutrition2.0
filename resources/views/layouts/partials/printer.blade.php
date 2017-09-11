<!-- Main content -->
<div class="wrap" id="app" style="min-height: 100vh;">
    <div class="no-print">
        <!-- Navigation bar -->
        @include('layouts.partials.navbar')

        <div class="container">
            @include('flash::message')
        </div>
    </div>

    <!-- Content of the page -->
    <div class="content">
        @yield('content')
    </div>
</div>

<div class="no-print">
    <!-- Footer -->
    @include('layouts.partials.footer')
</div>

<!-- Core Javascript Loads -->
<script src="/js/app.js"></script>

<!-- Page specific javascript -->
@yield('javascript')

@if(App::environment() === "production")
    <script src="/js/piwik.js"></script>
@endif
