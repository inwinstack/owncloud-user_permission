<?php

namespace OCA\User_Permission\Controller;

use OCP\AppFramework\Http\Templateresponse;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http;
use OCP\IRequest;
use OC\AllConfig;
use OCP\AppFramework\Http\DataResponse;
use OCP\User;
use OCP\IUserManager;
use OC\Files\Filesystem;

class PermissionController extends Controller {
    
    public function __construct($AppName, IRequest $request) {
        parent::__construct($AppName, $request);
    }

    /**
     * @NoAdminRequired
     */

    public function getEnabled($uid){
        $uids = explode(",", $uid);
        if($uids == "") {
            array_push($uids,$uid);
        }
        $config = \OC::$server->getConfig();
        $userValue = $config->getUserValueForUsers('core', 'enabled', $uids);
        $max = sizeof($uids);

        for($i = 0; $i<$max; $i++){
            $name = $uids[$i];
            $userValue[$name] = (!array_key_exists($name, $userValue) || $userValue[$name] == 'true' || empty($userValue[$name])) ? true:false;
        }

        return new DataResponse(array("data" => $userValue, "status" => "success"));
    }

    /**
     * @NoAdminRequired
     */

    public function changeEnabled($checked, $user){
        ($checked === 'false') ? \OC_User::disableUser($user) : \OC_User::enableUser($user);
         
        return new DataResponse(array($user => $checked));
    }

   /**
     * @NoAdminRequired
     * @NoCSRFRequired
     *
     * Import sharing group from csv file
     * @param csv file $data
     * @return DataResponse
     */
    public function importUser() {
        $files = $this->request->getUploadedFile('fileToUpload'); 

        $filestype = $files['type'] != 'text/csv' && $files['type'] != 'application/vnd.ms-excel';
        if($filestype) {      
            return new DataResponse(['status' => 'error','msg' => 'Your file type is ' . $files['type'] . ' Please select a CSV file.']);
        }

        $data = $this->importDataHanlder($files);
        
        $msg = 'Importing groups and user successfully.';
        
        return new DataResponse(['data' => $data, 'status' => 'success', 'msg' => $msg],Http::STATUS_OK);
    }  

    /**
     *  Process the csv file and return an array contains sharing group and group user 
     *  
     *  @param  $file csv file
     *  @return array
     */
    private static function importDataHanlder($files) {
        $result = [];
        $handle = fopen($files['tmp_name'],"r");
        
        while(($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            
            if($data[0] == '') { 
                continue; 
            }
            $username = $data[0];
            $password = $data[1];

            if(!\OC_User::userExists($username)) {
                $userManager = \OC::$server->getUserManager(); 
                $user = $userManager->createUser($username, $password);
                if($user){
                    $result[] = array(
                        'user' => $username,
                        'status' => 'create successfully'
                    );
                }
            }    
        }
       
       return $result;
    }
}
