<!DOCTYPE html>
<html lang="en">
  <head>
    @include('layout.partials.head')
  </head>
  @if(!Route::is(['example-page.error-404','example-page.error-500']))
<body>
 @endif 
@if(Route::is(['example-page.error-404','example-page.error-500']))
<body class="error-page">
@endif 
@if(Route::is(['example-page.forgetpassword','example-page.resetpassword','example-page.signin','example-page.signup']))
<body class="account-page">
@endif 
@include('layout.partials.loader')
  <!-- Main Wrapper -->
<div class="main-wrapper">
  @if(!Route::is(['example-page.error-404','example-page.error-500','example-page.forgetpassword','example-page.pos','example-page.resetpassword','example-page.signin','example-page.signup', 'login']))
    @include('layout.partials.header')
    @include('layout.partials.sidebar')
  @endif 
    @yield('content')
</div>		
<!-- /Main Wrapper -->
    @include('layout.partials.footer-scripts')
  </body>
</html>