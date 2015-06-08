requirejs.config({
    baseUrl: '/app_assets/src',
    paths: {
        'almond': '../vendor/almond/almond',
        'backbone': '../vendor/backbone/backbone',
        'bootstrap': '../vendor/bootstrap/dist/js/bootstrap',
        'jquery': '../vendor/jquery/dist/jquery',
        'json2': '../vendor/json2/json2',
        'marionette': '../vendor/marionette/lib/backbone.marionette',
        'text': '../vendor/requirejs-text/text',
        'underscore': '../vendor/underscore/underscore'
    },
    shim: {
        'bootstrap': ['jquery']
    },
    urlArgs: 'v=' + (new Date()).getTime()
});
