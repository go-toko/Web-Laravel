<!DOCTYPE html>
<html lang="en">

<head>
    @include('layout.partials.head')
</head>
<style>
    .error-page .main-wrapper .error-box {
        max-width: 90%;
    }
</style>

<body class="error-page">
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>
    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <div class="wizard-box">
            <!-- Wizard -->
            @yield('content')
            <!-- /Wizard -->
        </div>
    </div>
    <!-- /Main Wrapper -->

    @include('layout.partials.footer-scripts')

</body>

</html>
