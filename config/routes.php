<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 * Cache: Routes are cached to improve performance, check the RoutingMiddleware
 * constructor in your `src/Application.php` file to change this behavior.
 *
 */
Router::defaultRouteClass(DashedRoute::class);

// Router::prefix('/auth', ['_namePrefix' => 'auth:'], function ($routes) {
//   $routes->resources('User', [
//     'map' => ['login' => ['action' => 'login', 'method' => 'GET']]
//   ]);
// });

Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */
    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    $routes->post(
        '/auth/login/*',
        ['controller' => 'User', 'action' => 'login']
    );

    $routes->post(
        '/auth/signup/*',
        ['controller' => 'User', 'action' => 'signup']
    );

    $routes->post(
        '/auth/recover',
        ['controller' => 'User', 'action' => 'forgotpassword']
    );

    $routes->post(
        '/post/submit/*',
        ['controller' => 'Post', 'action' => 'add']
    );

    $routes->post(
        '/files/submit/*',
        ['controller' => 'Fileuploads', 'action' => 'add']
    );

    $routes->post(
        '/comments/submit/*',
        ['controller' => 'Comments', 'action' => 'new']
    );

    $routes->post(
        '/favlocation/submit/*',
        ['controller' => 'FavLocation', 'action' => 'add']
    );

    $routes->post(
        '/activity/submit/*',
        ['controller' => 'Activitylog', 'action' => 'add']
    );

    $routes->post(
        '/polls/submit/*',
        ['controller' => 'UserPolls', 'action' => 'add']
    );

    $routes->post(
        '/user/access/*',
        ['controller' => 'User', 'action' => 'updateaccess']
    );

    $routes->post(
        '/user/update/*',
        ['controller' => 'User', 'action' => 'updateuserinfo']
    );

    $routes->post(
        '/user/verify/*',
        ['controller' => 'User', 'action' => 'email_verification']
    );

    $routes->post(
        '/user/changepicture/*',
        ['controller' => 'User', 'action' => 'changeProfilePicture']
    );

    $routes->post(
        '/favlocation/remove/*',
        ['controller' => 'FavLocation', 'action' => 'delete']
    );

    $routes->post(
        '/favlocation/default/*',
        ['controller' => 'FavLocation', 'action' => 'setDefault']
    );

    $routes->get(
        '/auth/logout/*',
        ['controller' => 'User', 'action' => 'logout']
    );

    $routes->post(
        '/user/getinfo/*',
        ['controller' => 'User', 'action' => 'getuserinfo']
    );

    $routes->get(
        '/user/getinfo/*',
        ['controller' => 'User', 'action' => 'getuserinfo']
    );

    $routes->get(
        '/post/get',
        ['controller' => 'Post', 'action' => 'getfeed']
    );

    $routes->post(
        '/post/get/*',
        ['controller' => 'Post', 'action' => 'getfeed']
    );

    $routes->get(
        '/countries/get/*',
        ['controller' => 'Countries', 'action' => 'get']
    );

    $routes->post(
        '/post/getpost',
        ['controller' => 'Post', 'action' => 'getpost']
    );

    $routes->get(
        '/comments/get/*',
        ['controller' => 'Comments', 'action' => 'get']
    );

    $routes->get(
        '/favlocation/get/',
        ['controller' => 'FavLocation', 'action' => 'get']
    );

    $routes->get(
        '/favlocation/exist/*',
        ['controller' => 'FavLocation', 'action' => 'checkExist']
    );

    $routes->get(
        '/user/exist/*',
        ['controller' => 'User', 'action' => 'userexists' ]
    );

    $routes->get(
        '/location/get/*',
        ['controller' => 'Localities', 'action' => 'get' ]
    );

    $routes->post(
        '/user/follow/*',
        ['controller' => 'User', 'action' => 'follow' ]
    );

    $routes->post(
        '/user/unfollow/*',
        ['controller' => 'User', 'action' => 'unfollow' ]
    );

    $routes->post(
        '/user/getfollowers/*',
        ['controller' => 'User', 'action' => 'getFollowers' ]
    );

    $routes->post(
        '/user/getfollowing/*',
        ['controller' => 'User', 'action' => 'getFollowings' ]
    );

    $routes->get(
        '/user/getfollowers/*',
        ['controller' => 'User', 'action' => 'getFollowers' ]
    );

    $routes->get(
        '/user/getfollowing/*',
        ['controller' => 'User', 'action' => 'getFollowings' ]
    );

    $routes->post(
        '/post/getbookmarks/*',
        ['controller' => 'Activitylog', 'action' => 'getbookmarks' ]
    );

    $routes->post(
        '/area/rate/*',
        ['controller' => 'AreaRatings', 'action' => 'rateArea' ]
    );

    $routes->get(
        '/area/getratings/*',
        ['controller' => 'AreaRatings', 'action' => 'getdatewiseratings' ]
    );

    $routes->get(
        '/post/getbookmarks/*',
        ['controller' => 'Activitylog', 'action' => 'getbookmarks' ]
    );

    /**
     * ...and connect the rest of 'Pages' controller's URLs.
     */
    $routes->connect('/pages/*', ['controller' => 'Pages', 'action' => 'display']);

    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks(DashedRoute::class);
});

/**
 * Load all plugin routes. See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
