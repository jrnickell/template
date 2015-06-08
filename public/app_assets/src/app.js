(function (root, factory) {
    root.Novuso = root.Novuso || {};
    if (typeof define == 'function' && define.amd) {
        define([
            'backbone',
            'marionette',
            'jquery',
            'underscore',
            'json2'
        ], function (Backbone, Marionette, $, _) {
            root.Novuso.app = factory(Backbone, Marionette, $, _);

            return root.Novuso.app;
        });
    } else {
        root.Novuso.app = factory(
            root.Backbone,
            root.Marionette,
            root.jQuery,
            root._
        );
    }
})(this, function (Backbone, Marionette, $, _) {

    "use strict";

    var app = new Marionette.Application();

    // setup app

    return app;

});
