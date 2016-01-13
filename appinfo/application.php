<?php
namespace OCA\User_Permission\AppInfo;

use \OCP\AppFramework\App;

use \OCA\User_Permission\Hooks\UserHooks;
use \OCA\User_Permission\Controller\PermissionController;


class Application extends App {

    public function __construct(array $urlParams=array()){
        parent::__construct('user_permission', $urlParams);

        $container = $this->getContainer();

        /**
         * Controllers
         */
        $container->registerService('UserHooks', function($c) {
            return new UserHooks(
                $c->query('ServerContainer')->getUserManager()
            );
        });

        $container->registerService('L10N', function($c) {
            return $c->query('ServerContainer')->getL10N($c->query('AppName'));
        });
        
        $container->registerService('PermissionController', function($c){
            return new PermissionController(
                $c->query('AppName'),
                $c->query('Request')
            );
        });
        
    }
}

