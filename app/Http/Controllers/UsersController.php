<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{

    /*------ GET METHOD ------*/
    
    //Get - All Users
    public function getUsers() {
        $users = User::all();
        return $users;
    }

    //Get - One User
    public function getOneUser(Request $request) {
        $user = User::find($request->id);
        return $user;  
    }

    /*------ POST METHOD ------*/

    //Create User
    public function createUser(Request $request) {
        $response = array('error_code' => 400, 'error_msg' => 'Error inserting info');
        
        if(!$request->name || !$request->password || !$request->email) {
            $response= array('error_msg' => "Tiene que rellenar todos los campos");
        } else {
            try {
                $user = new User;
                $user->name = $request->name;
                $user->password = hash('sha256',$request->password);
                $user->email = $request->email;
                if ($request->api_token){
                    $user->api_token = hash('sha256', $request->api_token);
                }
                $user->save();
                $response = array('error_code' => 200, 'error_msg' => 'OK');

            }  catch(\Exception $e){
                $response = array('error_code' => 500, 'error_msg' => $e->getMessage());
            }
        }

        return $response;
    }

    /*------ PUT METHOD ------*/

    //Modify User
    public function modifyUser(Request $request) {
        $response = array('error_code' => 400, 'error_msg' => 'Error inserting info');
        $user = User::find($request->id);

        if($user !== null){
            foreach($request->all() as $key => $value) {

                if(!empty(trim($value))) {
                    if ($value !== null ){
                        try {
                            $user->$key = $request->$key; 
                            $user->save();
                            $response = array('error_code' => 200, 'error_msg' => 'OK');
                        } catch (\Exception $e) {
                            $response = array('error_code' => 500, 'error_msg' => $e->getMessage());
                        }
                    }
                } else {
                    print('Value '. $key . ' is empty!');
                };
            }    
        }

        return $response;
    }

    /*------ DELETE METHOD ------*/

    //Delete User
    public function deleteUser(Request $request) {
        $user = User::find($request->id);
        $user->delete();
        
        return response()->json([
            "message" => "deleted user"
        ], 200);
    }
 
}

