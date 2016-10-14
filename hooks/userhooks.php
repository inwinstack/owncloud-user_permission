<?php
namespace OCA\User_Permission\Hooks;

use OC_User;
use OC_Template;

class UserHooks {

    private $userManager;
   

    public function __construct($userManager) {
        $this->userManager = $userManager;
    }


    public function EnableUser($user) {
        $uid = $user->getUID();
        $config = \OC::$server->getConfig();
        $config->setUserValue($uid, 'core', 'enabled', 'true');
    }


    
    public function register() {
        $callback = array($this, 'EnableUser');
        $this->userManager->listen('\OC\User', 'postCreateUser', $callback);
        $DeleteAllContainer = function($user) {
            $url = "http://140.129.25.141/dockertest/api/v1/removeUserContainers";
            $uid = $user->getUID();

            $c = curl_init();
            $data = json_encode(array("username" => $uid));
            curl_setopt($c, CURLOPT_POST, true);
            curl_setopt($c, CURLOPT_POSTFIELDS, $data);
            curl_setopt($c, CURLOPT_URL, $url);
            curl_setopt($c, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            curl_setopt($c, CURLOPT_RETURNTRANSFER,1);

            curl_exec($c);

            $info = curl_getinfo($c);
            curl_close($c);
        };
        $this->userManager->listen('\OC\User', 'postDelete', $DeleteAllContainer);
    }

}
