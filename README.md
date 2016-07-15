# redeconvergir-laravel

Based on [redeconvergir.net](https://github.com/paulovieira/rede-convergir-3).

Dependencies:
* Laravel 5.2
* Php 5.6+ (php-7 suggested)
* Mysql
* caching system (redis suggested)

Development works best with [Laravel Homestead](https://laravel.com/docs/master/homestead)

## Log

* 5.7.2016 - mostly frontend (v)
    * Intergration of bower and node components including Neat, Bourbon, Sass support, etc.
    * Laravel Elixir with gulp settings for frontend dependencies
* 7.7.2016 - mostly backend dependencies (v)
    * php dependencies
    * useful plugins
    * better localization support
    * some basic settings
* 15.7.2016 - administration preparation (g)
    * administration now reachable on /panel/, u:admin@change.me, p:12345;
    * based on [Laravel Panel](http://laravelpanel.com/docs/master/get-started), which also incorporates CRUD generator
    * currently solving problems with with having controllers in Controllers/Admin/ namespace (in subfolder) while models are in app/Models/ so that things don't get messy
    * notes on the process of creating CRUD for a model coming soon

