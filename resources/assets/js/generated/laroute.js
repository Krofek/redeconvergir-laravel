(function () {

    var laroute = (function () {

        var routes = {

            absolute: false,
            rootUrl: 'http://rede.local',
            routes : [{"host":null,"methods":["GET","HEAD"],"uri":"api\/user","name":null,"action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/map\/filters-data","name":"api::initiative-filters-data","action":"Api\MapController@filtersData"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/map\/markers","name":"api::map-markers","action":"Api\MapController@markers"},{"host":null,"methods":["GET","HEAD"],"uri":"api\/map\/initiatives","name":"api::initiatives","action":"Api\MapController@initiatives"},{"host":null,"methods":["GET","HEAD"],"uri":"\/","name":null,"action":"IndexController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"micelij","name":null,"action":"InitiativeMapController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"bootswatch","name":null,"action":"Closure"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/{provider}","name":null,"action":"Auth\AuthController@redirectToProvider"},{"host":null,"methods":["GET","HEAD"],"uri":"auth\/{provider}\/callback","name":null,"action":"Auth\AuthController@handleProviderCallback"},{"host":null,"methods":["GET","HEAD"],"uri":"login","name":"login","action":"Auth\LoginController@showLoginForm"},{"host":null,"methods":["POST"],"uri":"login","name":null,"action":"Auth\LoginController@login"},{"host":null,"methods":["POST"],"uri":"logout","name":"logout","action":"Auth\LoginController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"register","name":"register","action":"Auth\RegisterController@showRegistrationForm"},{"host":null,"methods":["POST"],"uri":"register","name":null,"action":"Auth\RegisterController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset","name":null,"action":"Auth\ForgotPasswordController@showLinkRequestForm"},{"host":null,"methods":["POST"],"uri":"password\/email","name":null,"action":"Auth\ForgotPasswordController@sendResetLinkEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"password\/reset\/{token}","name":null,"action":"Auth\ResetPasswordController@showResetForm"},{"host":null,"methods":["POST"],"uri":"password\/reset","name":null,"action":"Auth\ResetPasswordController@reset"},{"host":null,"methods":["GET","HEAD"],"uri":"home","name":null,"action":"HomeController@index"},{"host":null,"methods":["GET","HEAD"],"uri":"_debugbar\/open","name":"debugbar.openhandler","action":"Barryvdh\Debugbar\Controllers\OpenHandlerController@handle"},{"host":null,"methods":["GET","HEAD"],"uri":"_debugbar\/clockwork\/{id}","name":"debugbar.clockwork","action":"Barryvdh\Debugbar\Controllers\OpenHandlerController@clockwork"},{"host":null,"methods":["GET","HEAD"],"uri":"_debugbar\/assets\/stylesheets","name":"debugbar.assets.css","action":"Barryvdh\Debugbar\Controllers\AssetController@css"},{"host":null,"methods":["GET","HEAD"],"uri":"_debugbar\/assets\/javascript","name":"debugbar.assets.js","action":"Barryvdh\Debugbar\Controllers\AssetController@js"},{"host":null,"methods":["GET","HEAD"],"uri":"elfinder","name":null,"action":"Barryvdh\Elfinder\ElfinderController@showIndex"},{"host":null,"methods":["GET","HEAD","POST","PUT","PATCH","DELETE"],"uri":"elfinder\/connector","name":"elfinder.connector","action":"Barryvdh\Elfinder\ElfinderController@showConnector"},{"host":null,"methods":["GET","HEAD"],"uri":"elfinder\/popup\/{input_id}","name":"elfinder.popup","action":"Barryvdh\Elfinder\ElfinderController@showPopup"},{"host":null,"methods":["GET","HEAD"],"uri":"elfinder\/filepicker\/{input_id}","name":"elfinder.filepicker","action":"Barryvdh\Elfinder\ElfinderController@showFilePicker"},{"host":null,"methods":["GET","HEAD"],"uri":"elfinder\/tinymce","name":"elfinder.tinymce","action":"Barryvdh\Elfinder\ElfinderController@showTinyMCE"},{"host":null,"methods":["GET","HEAD"],"uri":"elfinder\/tinymce4","name":"elfinder.tinymce4","action":"Barryvdh\Elfinder\ElfinderController@showTinyMCE4"},{"host":null,"methods":["GET","HEAD"],"uri":"elfinder\/ckeditor","name":"elfinder.ckeditor","action":"Barryvdh\Elfinder\ElfinderController@showCKeditor4"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/login","name":"login","action":"Backpack\Base\app\Http\Controllers\Auth\LoginController@showLoginForm"},{"host":null,"methods":["POST"],"uri":"admin\/login","name":null,"action":"Backpack\Base\app\Http\Controllers\Auth\LoginController@login"},{"host":null,"methods":["POST"],"uri":"admin\/logout","name":"logout","action":"Backpack\Base\app\Http\Controllers\Auth\LoginController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/register","name":"register","action":"Backpack\Base\app\Http\Controllers\Auth\RegisterController@showRegistrationForm"},{"host":null,"methods":["POST"],"uri":"admin\/register","name":null,"action":"Backpack\Base\app\Http\Controllers\Auth\RegisterController@register"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/password\/reset","name":null,"action":"Backpack\Base\app\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm"},{"host":null,"methods":["POST"],"uri":"admin\/password\/email","name":null,"action":"Backpack\Base\app\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/password\/reset\/{token}","name":null,"action":"Backpack\Base\app\Http\Controllers\Auth\ResetPasswordController@showResetForm"},{"host":null,"methods":["POST"],"uri":"admin\/password\/reset","name":null,"action":"Backpack\Base\app\Http\Controllers\Auth\ResetPasswordController@reset"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/logout","name":null,"action":"Backpack\Base\app\Http\Controllers\Auth\LoginController@logout"},{"host":null,"methods":["GET","HEAD"],"uri":"admin\/dashboard","name":null,"action":"Backpack\Base\app\Http\Controllers\AdminController@dashboard"},{"host":null,"methods":["GET","HEAD"],"uri":"admin","name":null,"action":"Backpack\Base\app\Http\Controllers\AdminController@redirect"}],
            prefix: '',

            route : function (name, parameters, route) {
                route = route || this.getByName(name);

                if ( ! route ) {
                    return undefined;
                }

                return this.toRoute(route, parameters);
            },

            url: function (url, parameters) {
                parameters = parameters || [];

                var uri = url + '/' + parameters.join('/');

                return this.getCorrectUrl(uri);
            },

            toRoute : function (route, parameters) {
                var uri = this.replaceNamedParameters(route.uri, parameters);
                var qs  = this.getRouteQueryString(parameters);

                return this.getCorrectUrl(uri + qs);
            },

            replaceNamedParameters : function (uri, parameters) {
                uri = uri.replace(/\{(.*?)\??\}/g, function(match, key) {
                    if (parameters.hasOwnProperty(key)) {
                        var value = parameters[key];
                        delete parameters[key];
                        return value;
                    } else {
                        return match;
                    }
                });

                // Strip out any optional parameters that were not given
                uri = uri.replace(/\/\{.*?\?\}/g, '');

                return uri;
            },

            getRouteQueryString : function (parameters) {
                var qs = [];
                for (var key in parameters) {
                    if (parameters.hasOwnProperty(key)) {
                        qs.push(key + '=' + parameters[key]);
                    }
                }

                if (qs.length < 1) {
                    return '';
                }

                return '?' + qs.join('&');
            },

            getByName : function (name) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].name === name) {
                        return this.routes[key];
                    }
                }
            },

            getByAction : function(action) {
                for (var key in this.routes) {
                    if (this.routes.hasOwnProperty(key) && this.routes[key].action === action) {
                        return this.routes[key];
                    }
                }
            },

            getCorrectUrl: function (uri) {
                var url = this.prefix + '/' + uri.replace(/^\/?/, '');

                if(!this.absolute)
                    return url;

                return this.rootUrl.replace('/\/?$/', '') + url;
            }
        };

        var getLinkAttributes = function(attributes) {
            if ( ! attributes) {
                return '';
            }

            var attrs = [];
            for (var key in attributes) {
                if (attributes.hasOwnProperty(key)) {
                    attrs.push(key + '="' + attributes[key] + '"');
                }
            }

            return attrs.join(' ');
        };

        var getHtmlLink = function (url, title, attributes) {
            title      = title || url;
            attributes = getLinkAttributes(attributes);

            return '<a href="' + url + '" ' + attributes + '>' + title + '</a>';
        };

        return {
            // Generate a url for a given controller action.
            // laroute.action('HomeController@getIndex', [params = {}])
            action : function (name, parameters) {
                parameters = parameters || {};

                return routes.route(name, parameters, routes.getByAction(name));
            },

            // Generate a url for a given named route.
            // laroute.route('routeName', [params = {}])
            route : function (route, parameters) {
                parameters = parameters || {};

                return routes.route(route, parameters);
            },

            // Generate a fully qualified URL to the given path.
            // laroute.route('url', [params = {}])
            url : function (route, parameters) {
                parameters = parameters || {};

                return routes.url(route, parameters);
            },

            // Generate a html link to the given url.
            // laroute.link_to('foo/bar', [title = url], [attributes = {}])
            link_to : function (url, title, attributes) {
                url = this.url(url);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given route.
            // laroute.link_to_route('route.name', [title=url], [parameters = {}], [attributes = {}])
            link_to_route : function (route, title, parameters, attributes) {
                var url = this.route(route, parameters);

                return getHtmlLink(url, title, attributes);
            },

            // Generate a html link to the given controller action.
            // laroute.link_to_action('HomeController@getIndex', [title=url], [parameters = {}], [attributes = {}])
            link_to_action : function(action, title, parameters, attributes) {
                var url = this.action(action, parameters);

                return getHtmlLink(url, title, attributes);
            }

        };

    }).call(this);

    /**
     * Expose the class either via AMD, CommonJS or the global object
     */
    if (typeof define === 'function' && define.amd) {
        define(function () {
            return laroute;
        });
    }
    else if (typeof module === 'object' && module.exports){
        module.exports = laroute;
    }
    else {
        window.laroute = laroute;
    }

}).call(this);

