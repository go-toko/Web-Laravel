const mix = require('laravel-mix');
const lodash = require("lodash");
const folder = {
    src: "resources/", // source files
    dist: "public/", // build files
    dist_assets: "public/assets/" //build assets files
};
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
 var third_party_assets = {
        css_js: [
            {"name": "jquery", "assets": ["./node_modules/jquery/dist/jquery.min.js"]},
            
        ]
    };

    //copying third party assets
    lodash(third_party_assets).forEach(function (assets, type) {
        if (type == "css_js") {
            lodash(assets).forEach(function (plugins) {
                var name = plugins['name'],
                    assetlist = plugins['assets'],
                    css = [],
                    js = [];
                lodash(assetlist).forEach(function (asset) {
                    var ass = asset.split(',');
                    for (let i = 0; i < ass.length; ++i) {
                        if(ass[i].substr(ass[i].length - 3)  == ".js") {
                            js.push(ass[i]);
                        } else {
                            css.push(ass[i]);
                        }
                    };
                });
                if(js.length > 0){
                    mix.combine(js, folder.dist_assets + "/plugins/" + name + "/" + name + ".min.js");
                }
                if(css.length > 0){
                    mix.combine(css, folder.dist_assets + "/plugins/" + name + "/" + name + ".min.css");
                }
            });
        }
    });

    mix.copy('resources/img', 'public/assets/img');
    mix.copy('resources/scss', 'public/assets/scss');
    mix.copy('resources/fonts', 'public/assets/fonts');
    mix.copy('resources/css/style.css', 'public/assets/css');
    mix.copy('resources/css/style.css.map', 'public/assets/css');
    mix.copy('resources/js/script.js', 'public/assets/js');
    mix.copy('resources/js/fileupload.min.js', 'public/assets/plugins/fileupload');
    mix.copy('resources/js/pages/apex-chart-data.js', 'public/assets/plugins/apexchart/chart-data.js');
    mix.copy('resources/css/dataTables.bootstrap4.min.css', 'public/assets/css');
    mix.copy('resources/js/pages/chart-chart-data.js', 'public/assets/plugins/chartjs/chart-data.js');
    mix.copy('resources/js/pages/raphael-min.js', 'public/assets/plugins/morris');
    mix.copy('resources/js/pages/morris-chart-data.js', 'public/assets/plugins/morris/chart-data.js');
    mix.copy('resources/js/pages/flot-chart-data.js', 'public/assets/plugins/flot/chart-data.js');
    mix.copy('resources/js/pages/peity-chart-data.js', 'public/assets/plugins/peity/chart-data.js');
    mix.copy('resources/js/pages/c3-chart-data.js', 'public/assets/plugins/c3-chart/chart-data.js');
    mix.copy('resources/js/pages/icons', 'public/assets/plugins/icons');
    mix.copy('resources/js/pages/lightbox.js', 'public/assets/plugins/lightbox');
    mix.copy('resources/js/jquery.missofis-countdown.js', 'public/assets/plugins/countup');
    mix.copy('resources/js/jquery.fullcalendar.js', 'public/assets/plugins/fullcalendar');
    mix.copy('resources/js/drag-drop.min.js', 'public/assets/plugins/dragula');
    mix.copy('resources/js/pages/custom-select.js', 'public/assets/plugins/select2/js');
    mix.copy('resources/js/pages/form-wizard.js', 'public/assets/plugins/twitter-bootstrap-wizard');
    mix.copy('resources/js/pages/custom-alertify.min.js', 'public/assets/plugins/alertify');
    mix.copy('resources/js/pages/custom-rangeslider.js', 'public/assets/plugins/ion-rangeslider');
    mix.copy('resources/js/pages/custom.raty.js', 'public/assets/plugins/raty');
    mix.copy('resources/js/pages/like-on.png', 'public/assets/plugins/raty/images');
    mix.copy('resources/js/pages/like-off.png', 'public/assets/plugins/raty/images');
    mix.copy('resources/js/pages/scrollbar', 'public/assets/plugins/scrollbar');
    mix.copy('resources/js/pages/sticky.js', 'public/assets/plugins/stickynote');
    mix.copy('resources/css/sticky.css', 'public/assets/plugins/stickynote');
    mix.copy('resources/css/toatr.css', 'public/assets/plugins/toastr');
    mix.copy('resources/js/toastr.min.js', 'public/assets/plugins/toastr');
    mix.copy('resources/js/pages/toastr.js', 'public/assets/plugins/toastr');
    mix.copy('resources/js/sweetalerts.min.js', 'public/assets/plugins/sweetalert');
    mix.copy('resources/css/form-wizard.css', 'public/assets/plugins/twitter-bootstrap-wizard');
    mix.copy('node_modules/bootstrap/dist/css/bootstrap.css', 'public/assets/css');
    mix.copy('node_modules/bootstrap/dist/css/bootstrap.css.map', 'public/assets/css');
    mix.copy('node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/assets/css');
    mix.copy('node_modules/bootstrap/dist/css/bootstrap.min.css.map', 'public/assets/css');
    mix.copy('node_modules/bootstrap/dist/js/bootstrap.bundle.js', 'public/assets/js');
    mix.copy('node_modules/bootstrap/dist/js/bootstrap.bundle.js.map', 'public/assets//js');
    mix.copy('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js', 'public/assets/js');
    mix.copy('node_modules/bootstrap/dist/js/bootstrap.bundle.min.js.map', 'public/assets/js');
    mix.copy('node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js', 'public/assets/js');
    mix.copy('node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css', 'public/assets/css');
    mix.copy('node_modules/@fortawesome/fontawesome-free/css/all.min.css', 'public/assets/plugins/fontawesome/css');
    mix.copy('node_modules/@fortawesome/fontawesome-free/css/fontawesome.min.css', 'public/assets/plugins/fontawesome/css');
    mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/assets/plugins/fontawesome/webfonts');
    mix.copy('node_modules/owl.carousel/dist/assets/owl.carousel.min.css', 'public/assets/plugins/owlcarousel');
    mix.copy('node_modules/owl.carousel/dist/owl.carousel.min.js', 'public/assets/plugins/owlcarousel');
    mix.copy('node_modules/owl.carousel/dist/assets/owl.theme.default.min.css', 'public/assets/plugins/owlcarousel');
    mix.copy('node_modules/owl.carousel/dist/assets/owl.video.play.png', 'public/assets/plugins/owlcarousel');
    mix.copy('node_modules/select2/dist/css', 'public/assets/plugins/select2/css');
    mix.copy('node_modules/select2/dist/js/select2.min.js', 'public/assets/plugins/select2/js');
    mix.copy('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css', 'public/assets/plugins/datatables/datatables.min.css');
    mix.copy('node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js', 'public/assets/plugins/datatables/datatables.min.js');
    mix.copy('node_modules/jquery-slimscroll/jquery.slimscroll.js', 'public/assets/js');
    mix.copy('node_modules/jquery-slimscroll/jquery.slimscroll.min.js', 'public/assets/js');
    mix.copy('node_modules/datatables.net/js/jquery.dataTables.min.js', 'public/assets/plugins/datatables/jquery.dataTables.min.js');
    mix.copy('node_modules/feather-icons/dist/feather.min.js', 'public/assets/js/feather.min.js');
    mix.copy('node_modules/feather-icons/dist/feather.min.js.map', 'public/assets/js/feather.min.js.map');
    mix.copy('node_modules/animate.css/animate.css', 'public/assets/css');
    mix.copy('node_modules/moment/min/moment.min.js', 'public/assets/js');
    mix.copy('node_modules/moment/min/moment.min.js.map', 'public/assets/js');
    mix.copy('node_modules/dragula/dist', 'public/assets/plugins/dragula');
    mix.copy('node_modules/waypoints/lib/jquery.waypoints.min.js', 'public/assets/plugins/countup');
    mix.copy('node_modules/sweetalert2/dist/sweetalert2.all.min.js', 'public/assets/plugins/sweetalert');
    mix.copy('node_modules/sweetalert/dist/sweetalert.min.js', 'public/assets/plugins/sweetalert');
    mix.copy('node_modules/apexcharts/dist/apexcharts.min.js', 'public/assets/plugins/apexchart');
    mix.copy('node_modules/chart.js/dist/chart.min.js', 'public/assets/plugins/chartjs');
    mix.copy('node_modules/chart.js/dist/chart.js', 'public/assets/plugins/chartjs');
    mix.copy('node_modules/morris.js/morris.js', 'public/assets/plugins/morris');
    mix.copy('node_modules/morris.js/morris.min.js', 'public/assets/plugins/morris');
    mix.copy('node_modules/morris.js/morris.css', 'public/assets/plugins/morris');
    mix.copy('node_modules/jquery.flot/jquery.flot.fillbetween.js', 'public/assets/plugins/flot');
    mix.copy('node_modules/jquery.flot/jquery.flot.js', 'public/assets/plugins/flot');
    mix.copy('node_modules/jquery.flot/jquery.flot.pie.js', 'public/assets/plugins/flot');
    mix.copy('node_modules/peity/jquery.peity.min.js', 'public/assets/plugins/peity');
    mix.copy('node_modules/jquery-ui-bundle.1.12.1/jquery-ui.min.js', 'public/assets/js/jquery-ui.min.js');
    mix.copy('node_modules/fullcalendar/dist/fullcalendar.min.css', 'public/assets/plugins/fullcalendar');
    mix.copy('node_modules/fullcalendar/dist/fullcalendar.min.js', 'public/assets/plugins/fullcalendar');
    mix.copy('node_modules/c3/c3.min.js', 'public/assets/plugins/c3-chart');
    mix.copy('node_modules/c3/c3.min.css', 'public/assets/plugins/c3-chart');
    mix.copy('node_modules/d3/dist/d3.min.js', 'public/assets/plugins/c3-chart');
    mix.copy('node_modules/clipboard/dist/clipboard.min.js', 'public/assets/plugins/clipboard');
    mix.copy('node_modules/jquery-countdown/dist/jquery.countdown.js', 'public/assets/plugins/countup');
    mix.copy('node_modules/jquery-countdown/dist/jquery.countdown.min.js', 'public/assets/plugins/countup');
    mix.copy('node_modules/counterup/jquery.counterup.js', 'public/assets/plugins/countup');
    mix.copy('node_modules/counterup/jquery.counterup.min.js', 'public/assets/plugins/countup');
    mix.copy('node_modules/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js', 'public/assets/plugins/twitter-bootstrap-wizard');
    mix.copy('node_modules/twitter-bootstrap-wizard/prettify.js', 'public/assets/plugins/twitter-bootstrap-wizard');
    mix.copy('node_modules/glightbox/dist/css/glightbox.min.css', 'public/assets/plugins/lightbox');
    mix.copy('node_modules/glightbox/dist/js/glightbox.min.js', 'public/assets/plugins/lightbox');
    mix.copy('node_modules/alertifyjs/build/alertify.min.js', 'public/assets/plugins/alertify');
    mix.copy('node_modules/alertifyjs/build/css/alertify.min.css', 'public/assets/plugins/alertify');
    mix.copy('node_modules/ion-rangeslider/css', 'public/assets/plugins/ion-rangeslider');
    mix.copy('node_modules/ion-rangeslider/js', 'public/assets/plugins/ion-rangeslider');
    mix.copy('node_modules/raty-js/lib/images', 'public/assets/plugins/raty/images');
    mix.copy('node_modules/raty-js/lib/jquery.raty.js', 'public/assets/plugins/raty');
    mix.copy('node_modules/raty-js/lib/jquery.raty.css', 'public/assets/plugins/raty');
    mix.copy('node_modules/summernote/dist', 'public/assets/plugins/summernote/dist');
    mix.copy('node_modules/toastr/build/toastr.js.map', 'public/assets/plugins/toastr');
    
