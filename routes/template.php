<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;

Route::group(['prefix' => 'example-page', 'as' => 'example-page.'], function(){
    Route::get('index', [CustomAuthController::class, 'dashboard']); 
    Route::get('signin', [CustomAuthController::class, 'index'])->name('signin');
    Route::post('custom-login', [CustomAuthController::class, 'customSignin'])->name('signin.custom'); 
    Route::get('signup', [CustomAuthController::class, 'registration'])->name('signup');
    Route::post('custom-register', [CustomAuthController::class, 'customSignup'])->name('signup.custom'); 
    Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

        Route::get('/', function () {
        return view('example-page.signin');
        })->name('signin');
        Route::get('/index', function () {
        return view('example-page.index');
        })->name('index');
        Route::get('/index-one', function () {
        return view('example-page.index-one');
        })->name('index-one');
        Route::get('/index-two', function () {
        return view('example-page.index-two');
        })->name('index-two');
        Route::get('/index-three', function () {
        return view('example-page.index-three');
        })->name('index-three');
        Route::get('/index-four', function () {
        return view('example-page.index-four');
        })->name('index-four');
        Route::get('/activities', function () {
        return view('example-page.activities');
        })->name('activities');
        Route::get('/add-sales', function () {
        return view('example-page.add-sales');
        })->name('add-sales');
        Route::get('/addbrand', function () {
        return view('example-page.addbrand');
        })->name('addbrand');
        Route::get('/addcategory', function () {
        return view('example-page.addcategory');
        })->name('addcategory');
        Route::get('/addcustomer', function () {
        return view('example-page.addcustomer');
        })->name('addcustomer');
        Route::get('/addproduct', function () {
        return view('example-page.addproduct');
        })->name('addproduct');
        Route::get('/addpurchase', function () {
        return view('example-page.addpurchase');
        })->name('addpurchase');
        Route::get('/addquotation', function () {
        return view('example-page.addquotation');
        })->name('addquotation');
        Route::get('/addstore', function () {
        return view('example-page.addstore');
        })->name('addstore');
        Route::get('/addsupplier', function () {
        return view('example-page.addsupplier');
        })->name('addsupplier');
        Route::get('/addtransfer', function () {
        return view('example-page.addtransfer');
        })->name('addtransfer');
        Route::get('/adduser', function () {
        return view('example-page.adduser');
        })->name('adduser');
        Route::get('/barcode', function () {
        return view('example-page.barcode');
        })->name('barcode');
        Route::get('/blankpage', function () {
        return view('example-page.blankpage');
        })->name('blankpage');
        Route::get('/brandlist', function () {
        return view('example-page.brandlist');
        })->name('brandlist');
        Route::get('/calendar', function () {
        return view('example-page.calendar');
        })->name('calendar');
        Route::get('/categorylist', function () {
        return view('example-page.categorylist');
        })->name('categorylist');
        Route::get('/chart-apex', function () {
        return view('example-page.chart-apex');
        })->name('chart-apex');
        Route::get('/chart-c3', function () {
        return view('example-page.chart-c3');
        })->name('chart-c3');
        Route::get('/chart-flot', function () {
        return view('example-page.chart-flot');
        })->name('chart-flot');
        Route::get('/chart-js', function () {
        return view('example-page.chart-js');
        })->name('chart-js');
        Route::get('/chart-morris', function () {
        return view('example-page.chart-morris');
        })->name('chart-morris');
        Route::get('/chart-peity', function () {
        return view('example-page.chart-peity');
        })->name('chart-peity');
        Route::get('/chat', function () {
        return view('example-page.chat');
        })->name('chat');
        Route::get('/clipboard', function () {
        return view('example-page.clipboard');
        })->name('clipboard');
        Route::get('/components', function () {
        return view('example-page.components');
        })->name('components');
        Route::get('/counter', function () {
        return view('example-page.counter');
        })->name('counter');
        Route::get('/countrieslist', function () {
        return view('example-page.countrieslist');
        })->name('countrieslist');
        Route::get('/createexpense', function () {
        return view('example-page.createexpense');
        })->name('createexpense');
        Route::get('/createpermission', function () {
        return view('example-page.createpermission');
        })->name('createpermission');
        Route::get('/createpurchasereturn', function () {
        return view('example-page.createpurchasereturn');
        })->name('createpurchasereturn');
        Route::get('/createsalesreturn', function () {
        return view('example-page.createsalesreturn');
        })->name('createsalesreturn');
        Route::get('/createsalesreturns', function () {
        return view('example-page.createsalesreturns');
        })->name('createsalesreturns');
        Route::get('/currencysettings', function () {
        return view('example-page.currencysettings');
        })->name('currencysettings');
        Route::get('/customerlist', function () {
        return view('example-page.customerlist');
        })->name('customerlist');
        Route::get('/customerreport', function () {
        return view('example-page.customerreport');
        })->name('customerreport');
        Route::get('/data-tables', function () {
        return view('example-page.data-tables');
        })->name('data-tables');
        Route::get('/drag-drop', function () {
        return view('example-page.drag-drop');
        })->name('drag-drop');
        Route::get('/edit-sales', function () {
        return view('example-page.edit-sales');
        })->name('edit-sales');
        Route::get('/editbrand', function () {
        return view('example-page.editbrand');
        })->name('editbrand');
        Route::get('/editcategory', function () {
        return view('example-page.editcategory');
        })->name('editcategory');
        Route::get('/editcustomer', function () {
        return view('example-page.editcustomer');
        })->name('editcustomer');
        Route::get('/editexpense', function () {
        return view('example-page.editexpense');
        })->name('editexpense');
        Route::get('/editpermission', function () {
        return view('example-page.editpermission');
        })->name('editpermission');
        Route::get('/editpurchase', function () {
        return view('example-page.editpurchase');
        })->name('editpurchase');
        Route::get('/editpurchasereturn', function () {
        return view('example-page.editpurchasereturn');
        })->name('editpurchasereturn');
        Route::get('/editquotation', function () {
        return view('example-page.editquotation');
        })->name('editquotation');
        Route::get('/editsalesreturn', function () {
        return view('example-page.editsalesreturn');
        })->name('editsalesreturn');
        Route::get('/editsalesreturns', function () {
        return view('example-page.editsalesreturns');
        })->name('editsalesreturns');
        Route::get('/editstate', function () {
        return view('example-page.editstate');
        })->name('editstate');
        Route::get('/editstore', function () {
        return view('example-page.editstore');
        })->name('editstore');
        Route::get('/editsubcategory', function () {
        return view('example-page.editsubcategory');
        })->name('editsubcategory');
        Route::get('/editsupplier', function () {
        return view('example-page.editsupplier');
        })->name('editsupplier');
        Route::get('/edittransfer', function () {
        return view('example-page.edittransfer');
        })->name('edittransfer');
        Route::get('/edituser', function () {
        return view('example-page.edituser');
        })->name('edituser');
        Route::get('/email', function () {
        return view('example-page.email');
        })->name('email');
        Route::get('/emailsettings', function () {
        return view('example-page.emailsettings');
        })->name('emailsettings');
        Route::get('/error-404', function () {
        return view('example-page.error-404');
        })->name('error-404');
        Route::get('/error-500', function () {
        return view('example-page.error-500');
        })->name('error-500');
        Route::get('/expensecategory', function () {
        return view('example-page.expensecategory');
        })->name('expensecategory');
        Route::get('/expenselist', function () {
        return view('example-page.expenselist');
        })->name('expenselist');
        Route::get('/forgetpassword', function () {
        return view('example-page.forgetpassword');
        })->name('forgetpassword');
        Route::get('/form-basic-inputs', function () {
        return view('example-page.form-basic-inputs');
        })->name('form-basic-inputs');
        Route::get('/form-fileupload', function () {
        return view('example-page.form-fileupload');
        })->name('form-fileupload');
        Route::get('/form-horizontal', function () {
        return view('example-page.form-horizontal');
        })->name('form-horizontal');
        Route::get('/form-input-groups', function () {
        return view('example-page.form-input-groups');
        })->name('form-input-groups');
        Route::get('/form-mask', function () {
        return view('example-page.form-mask');
        })->name('form-mask');
        Route::get('/form-select2', function () {
        return view('example-page.form-select2');
        })->name('form-select2');
        Route::get('/form-validation', function () {
        return view('example-page.form-validation');
        })->name('form-validation');
        Route::get('/form-vertical', function () {
        return view('example-page.form-vertical');
        })->name('form-vertical');
        Route::get('/form-wizard', function () {
        return view('example-page.form-wizard');
        })->name('form-wizard');
        Route::get('/generalsettings', function () {
        return view('example-page.generalsettings');
        })->name('generalsettings');
        Route::get('/grouppermissions', function () {
        return view('example-page.grouppermissions');
        })->name('grouppermissions');
        Route::get('/icon-feather', function () {
        return view('example-page.icon-feather');
        })->name('icon-feather');
        Route::get('/icon-flag', function () {
        return view('example-page.icon-flag');
        })->name('icon-flag');
        Route::get('/icon-fontawesome', function () {
        return view('example-page.icon-fontawesome');
        })->name('icon-fontawesome');
        Route::get('/icon-ionic', function () {
        return view('example-page.icon-ionic');
        })->name('icon-ionic');
        Route::get('/icon-material', function () {
        return view('example-page.icon-material');
        })->name('icon-material');
        Route::get('/icon-pe7', function () {
        return view('example-page.icon-pe7');
        })->name('icon-pe7');
        Route::get('/icon-simpleline', function () {
        return view('example-page.icon-simpleline');
        })->name('icon-simpleline');
        Route::get('/icon-themify', function () {
        return view('example-page.icon-themify');
        })->name('icon-themify');
        Route::get('/icon-typicon', function () {
        return view('example-page.icon-typicon');
        })->name('icon-typicon');
        Route::get('/icon-weather', function () {
        return view('example-page.icon-weather');
        })->name('icon-weather');
        Route::get('/importproduct', function () {
        return view('example-page.importproduct');
        })->name('importproduct');
        Route::get('/importpurchase', function () {
        return view('example-page.importpurchase');
        })->name('importpurchase');
        Route::get('/importtransfer', function () {
        return view('example-page.importtransfer');
        })->name('importtransfer');
        Route::get('/inventoryreport', function () {
        return view('example-page.inventoryreport');
        })->name('inventoryreport');
        Route::get('/invoicereport', function () {
        return view('example-page.invoicereport');
        })->name('invoicereport');
        Route::get('/lightbox', function () {
        return view('example-page.lightbox');
        })->name('lightbox');
        Route::get('/newcountry', function () {
        return view('example-page.newcountry');
        })->name('newcountry');
        Route::get('/newstate', function () {
        return view('example-page.newstate');
        })->name('newstate');
        Route::get('/newuser', function () {
        return view('example-page.newuser');
        })->name('newuser');
        Route::get('/newuseredit', function () {
        return view('example-page.newuseredit');
        })->name('newuseredit');
        Route::get('/notification', function () {
        return view('example-page.notification');
        })->name('notification');
        Route::get('/paymentsettings', function () {
        return view('example-page.paymentsettings');
        })->name('paymentsettings');
        Route::get('/popover', function () {
        return view('example-page.popover');
        })->name('popover');
        Route::get('/pos', function () {
        return view('example-page.pos');
        })->name('pos');
        Route::get('/product-details', function () {
        return view('example-page.product-details');
        })->name('product-details');
        Route::get('/productlist', function () {
        return view('example-page.productlist');
        })->name('productlist');
        Route::get('/profile', function () {
        return view('example-page.profile');
        })->name('profile');
        Route::get('/purchaselist', function () {
        return view('example-page.purchaselist');
        })->name('purchaselist');
        Route::get('/purchaseorderreport', function () {
        return view('example-page.purchaseorderreport');
        })->name('purchaseorderreport');
        Route::get('/purchasereport', function () {
        return view('example-page.purchasereport');
        })->name('purchasereport');
        Route::get('/purchasereturnlist', function () {
        return view('example-page.purchasereturnlist');
        })->name('purchasereturnlist');
        Route::get('/rangeslider', function () {
        return view('example-page.rangeslider');
        })->name('rangeslider');
        Route::get('/rating', function () {
        return view('example-page.rating');
        })->name('rating');
        Route::get('/resetpassword', function () {
        return view('example-page.resetpassword');
        })->name('resetpassword');
        Route::get('/ribbon', function () {
        return view('example-page.ribbon');
        })->name('ribbon');
        Route::get('/sales-details', function () {
        return view('example-page.sales-details');
        })->name('sales-details');
        Route::get('/saleslist', function () {
        return view('example-page.saleslist');
        })->name('saleslist');
        Route::get('/salesreport', function () {
        return view('example-page.salesreport');
        })->name('salesreport');
        Route::get('/salesreturnlist', function () {
        return view('example-page.salesreturnlist');
        })->name('salesreturnlist');
        Route::get('/salesreturnlists', function () {
        return view('example-page.salesreturnlists');
        })->name('salesreturnlists');
        Route::get('/scrollbar', function () {
        return view('example-page.scrollbar');
        })->name('scrollbar');
        Route::get('/signin', function () {
        return view('example-page.signin');
        })->name('signin');
        Route::get('/signup', function () {
        return view('example-page.signup');
        })->name('signup');
        Route::get('/spinner', function () {
        return view('example-page.spinner');
        })->name('spinner');
        Route::get('/statelist', function () {
        return view('example-page.statelist');
        })->name('statelist');
        Route::get('/stickynote', function () {
        return view('example-page.stickynote');
        })->name('stickynote');
        Route::get('/storelist', function () {
        return view('example-page.storelist');
        })->name('storelist');
        Route::get('/subaddcategory', function () {
        return view('example-page.subaddcategory');
        })->name('subaddcategory');
        Route::get('/subcategorylist', function () {
        return view('example-page.subcategorylist');
        })->name('subcategorylist');
        Route::get('/supplierlist', function () {
        return view('example-page.supplierlist');
        })->name('supplierlist');
        Route::get('/supplierreport', function () {
        return view('example-page.supplierreport');
        })->name('supplierreport');
        Route::get('/sweetalerts', function () {
        return view('example-page.sweetalerts');
        })->name('sweetalerts');
        Route::get('/tables-basic', function () {
        return view('example-page.tables-basic');
        })->name('tables-basic');
        Route::get('/taxrates', function () {
        return view('example-page.taxrates');
        })->name('taxrates');
        Route::get('/text-editor', function () {
        return view('example-page.text-editor');
        })->name('text-editor');
        Route::get('/timeline', function () {
        return view('example-page.timeline');
        })->name('timeline');
        Route::get('/toastr', function () {
        return view('example-page.toastr');
        })->name('toastr');
        Route::get('/tooltip', function () {
        return view('example-page.tooltip');
        })->name('tooltip');
        Route::get('/transferlist', function () {
        return view('example-page.transferlist');
        })->name('transferlist');
        Route::get('/userlist', function () {
        return view('example-page.userlist');
        })->name('userlist');
        Route::get('/userlists', function () {
        return view('example-page.userlists');
        })->name('userlists');
        Route::get('/quotationlist', function () {
        return view('example-page.quotationlist');
        })->name('quotationlist');
        Route::get('/editcountry', function () {
        return view('example-page.editcountry');
        })->name('editcountry');
        Route::get('/editproduct', function () {
        return view('example-page.editproduct');
        })->name('editproduct');
});
