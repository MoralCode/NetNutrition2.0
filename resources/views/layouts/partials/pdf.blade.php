<!-- Main content -->
<div class="wrap no-print" id="app">
    <!-- Content of the page -->
    <div class="content">
        @yield('content')
    </div>
</div>

<!-- Core Javascript Loads -->
<script src="/js/app.js"></script>

@if(App::environment() === "production")
    <script src="/js/piwik.js"></script>
@endif