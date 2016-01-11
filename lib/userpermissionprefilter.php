<?php

namespace OCA\User_Permission;

use OCP\IPreFilter;
use OC_User;

class UserPermissionPreFilter implements IPreFilter{

    public function run() {
        $user = OC_User::getUser();

        if(!$user) return false;

        if(!OC_User::isEnabled($user) && OC_User::userExists($user)){
            $url = \OC::$server->getURLGenerator()->linkToRoute("messageoutput.message.index", array("app" => "user_permission", "temp" => "userdisable"));
            header("Location:$url");
        }

    }
}
