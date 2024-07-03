<!DOCTYPE html>
<html lang="en">
  <head>
    @include('layout.partials.head')
  </head>
  @if(!Route::is(['error-404','error-500']))
<body>
 @endif 
@if(Route::is(['error-404','error-500']))
<body class="error-page">
@endif 
@if(Route::is(['forgetpassword','resetpassword','signin','signup', 'get-login-cashier', 'owner.sales.pos.index']))
<body class="account-page">
@endif 
@include('layout.partials.loader')
  <!-- Main Wrapper -->
<div class="main-wrapper">
  @if(!Route::is(['error-404','error-500','forgetpassword','pos','resetpassword','signin','signup', 'login', 'get-login-cashier', 'owner.sales.pos.index']))
    @include('layout.partials.header')
    @include('layout.partials.sidebar')
  @endif 
    @yield('content')
</div>		
<!-- /Main Wrapper -->
    @include('layout.partials.footer-scripts')
  </body>
</html>