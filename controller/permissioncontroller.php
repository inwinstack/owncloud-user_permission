<?php

namespace OCA\User_Permission\Controller;

use OCP\AppFramework\Http\Templateresponse;
use OCP\AppFramework\Controller;
use OCP\IRequest;
use OC\AllConfig;
use OCP\AppFramework\Http\DataResponse;

class PermissionController extends Controller {
    
    public function __construct($AppName, IRequest $request) {
        parent::__construct($AppName, $request);
    }

    /**
     * @NoAdminRequired
     */

    public function getEnabled(){

        $uids = \OCP\User::getUsers();
        $config = \OC::$server->getConfig();
        $userValue = $config->getUserValueForUsers('core', 'enabled', $uids);
        $max = sizeof($uids);

        for($i = 0; $i<$max; $i++){
            $name = $uids[$i];
            $userValue[$name] = (!array_key_exists($name, $userValue) || $userValue[$name] == 'true' || empty($userValue[$name])) ? true:false;
        }

        return new DataResponse($userValue);
    }

    /**
     * @NoAdminRequired
     */

    public function changeEnabled($checked, $user){
        ($checked === 'false') ? \OC_User::disableUser($user) : \OC_User::enableUser($user);
         
        return new DataResponse(array($user => $checked));
    }
}
