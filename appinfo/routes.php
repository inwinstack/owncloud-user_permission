<?php
/**
 * ownCloud - user_permission
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Dino Peng <dino.p@inwinstack.com>
 * @copyright Dino Peng 2015
 */

/**
 * Create your routes in here. The name is the lowercase name of the controller
 * without the controller part, the stuff after the hash is the method.
 * e.g. page#index -> OCA\MyApp\Controller\PageController->index()
 *
 * The controller class has to be registered in the application.php file since
 * it's instantiated in there
 */

namespace OCA\User_Permission\AppInfo;

$application = new Application();

$application->registerRoutes($this, ['routes' => [
    ['name' => 'Permission#changeEnabled', 'url' => '/changeEnabled', 'verb' => 'POST'],
    ['name' => 'Permission#getEnabled', 'url' => '/getEnabled', 'verb' => 'POST'],
    ['name' => 'Permission#importUser', 'url' => '/importUser', 'verb' => 'POST'],
]]);

return [
    'routes' => [
        [
            'name'         => 'permission_api#preflighted_cors', // Valid for all API end points
            'url'          => '/api/{path}',
            'verb'         => 'OPTIONS',
            'requirements' => ['path' => '.+']
        ],
       ['name' => 'permission_api#getSession', 'url' => '/api/getSession', 'verb' => 'POST'],
    ]
];
