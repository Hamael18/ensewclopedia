var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')

    .addEntry('app', './assets/js/app.js')
    .addEntry('popper', './assets/js/popper.min.js')
    .addEntry('bootstrap', './assets/js/bootstrap.min.js')
    .addEntry('materializeJs', './assets/js/materialize.js')
    .addEntry('bootstrap-select-js', './assets/js/bootstrap-select.js')
    .addEntry('upload', './assets/js/upload.js')
    .addEntry('dropzone', './assets/js/dropzone.js')

    .addStyleEntry('materia', './assets/css/materia.min.css')
    .addStyleEntry('materialize', './assets/css/materialize.css')
    .addStyleEntry('bootstrap-select-css', './assets/css/bootstrap-select.css')

    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .autoProvidejQuery()
;

module.exports = Encore.getWebpackConfig();
