<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Books_user;
use App\Book;
use App\User;

class ServiceController extends Controller
{
    /*------ POST METHOD ------*/
    
    //POST - Deliver One Books
    public function deliveryOneBook(Request $request) {
        $response = array('error_code' => 400, 'error_msg' => 'Error inserting info');

        if ($request->user_id && $request->book_id) {
            $book = Book::find($request->book_id);
            $user = Book::find($request->user_id);

            if (empty($book) || empty($user)){
                $response = array('code' => 404, 'error_msg' => ['Not found']);
            } else {
                    try {
                        $service = new Books_user;
                        $service->user_id = $request->user_id;
                        $service->book_id = $request->book_id;
                        $service->delivery_date = date("Y-m-d H:i:s");
                        $service->return_date = null;
                        $service->save();

                        $response = array('code' => 200, 'msg' => ['OK']);
                    } catch (\Exception $e) {
                        $response = array('code' => 500, 'error_msg' => $e->getMessage());
                    }    
            } 
        }

        return response()->json($response);
    }

    /*------ PUT METHOD ------*/
    
    //PUT - Return One Book
    public function returnOneBook(Request $request) {
        $response = array('error_code' => 400, 'error_msg' => 'Error inserting info');
        $book_id = $request->book_id;
        $user_id = $request->user_id;
        $date = date("Y-m-d H:i:s");
        $delivery_date = $request->delivery_date;
        $return_date = $request->return_date;
        $service = "yolo";

        if(!$book_id || !$user_id || !$return_date) {
            $response= array('error_msg' => "Tiene que rellenar todos los campos");
        } else {
            try{
                $service = Books_user::where('book_id','=', $book_id)
                ->where(function ($query) use ($user_id){
                    $query->where('user_id','=',$user_id);
                })->first();

                if($request->return_date >= $service->delivery_date){
                    $service->return_date = $return_date;
                    $service->save();
                    $response = array('error_code' => 200, 'error_msg' => 'OK');    
                } else {
                    $response = array('error_code' => 400, 'error_msg' => 'La fecha de devolución debe ser mayor a la del prestamo');
                }
                
            } catch (\Exception $e) {
                $response = array('error_code' => 500, 'error_msg' => $e->getMessage());
            }
        }
        
        return response()->json($response);
    }
}
