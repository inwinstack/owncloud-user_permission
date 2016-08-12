<?php
/**
 * ownCloud - testmiddleware
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Dino Peng <dino.p@inwinstack.com>
 * @copyright Dino Peng 2016
 */
namespace OCA\User_Permission\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\ApiController;
use OCP\IRequest;

class PermissionApiController extends ApiController {
    public function __construct($appName,IRequest $request) {
        parent::__construct($appName, $request);
    }
    
    /**
     * @CORS
     * @NoAdminRequired
     * @NoCSRFRequired
     */
    public function getSession($username, $password){
        $session = \OC_User::login($username, $password);
        $response = array();
        if($session) {
            $response['status'] = 'success';
            $response['message'] = 'Logged in successfully.';
            $response['name'] = $username;
        }
        else {
            $response['status'] = 'error';
            $response['message'] = 'Login failed. Incorrect credentials';
        }

        return new DataResponse($response);
    }
}
