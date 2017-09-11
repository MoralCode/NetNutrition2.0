<!-- Main content -->
<div class="wrap no-print" id="app">
    <!-- Navigation bar -->
    @include('layouts.partials.navbar')

    <div class="loading-wrapper" id="loading-handle">
        <div class="loading-text">{!! $quote->quote !!}</div>
        <div class="loading-content"></div>
    </div>
</div>

<!-- Footer -->
@include('layouts.partials.footer')

<!-- Core Javascript Loads -->
<script src="/js/app.js"></script>