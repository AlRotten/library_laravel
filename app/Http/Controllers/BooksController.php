<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BooksController extends Controller
{
    /*------ GET METHOD ------*/
    
    //Get - All Books
    public function getBooks() {
        $books = Book::all();
        return $books;
    }

    //Get - Book by Author/Genre
    public function getBooksByString(Request $request) {
        $response = array('error_code' => 400, 'error_msg' => 'Error inserting info');
        
        $genre = $request->genre;
        $author = $request->author;

        if($genre != null && $author != null) {
            $books = Book::where('genre','=', $genre)
            ->where(function ($query) use ($author){
                $query->where('author','=',$author);
            })->get();
        } elseif ($genre == null){
            $books = Book::where('author','=',$author)->get();
        } elseif ($author == null) {
            $books = Book::where('genre','=',$genre)->get();
        }

        if(count($books) == 0) {
            $response = array('error_code' => 404, 'error_msg' => ['La busqueda mediante: '.$author.' y genero: '.$genre.' no ha dado resultado']);
            return response()->json($response);

        } else {
            return $books;
        }

    }

    //Get - One book
    public function getOneBook(Request $request) {
        $book = Book::find($request->id);
        return $book;
    }

    /*------ POST METHOD ------*/

    //Create Book
    public function createBook(Request $request) {
        $response = array('error_code' => 400, 'error_msg' => 'Error inserting info');
        
        if(!$request->title || !$request->author || !$request->genre || !$request->synopsis) {
            $response= array('error_msg' => "Tiene que rellenar todos los campos");
        } else {
            try {
                $book = new Book;
                $book->title = $request->title;
                $book->author = $request->author;
                $book->genre = $request->genre;
                $book->synopsis = $request->synopsis;
                $book->save();
                $response = array('error_code' => 200, 'error_msg' => 'OK');

            }  catch(\Exception $e){
                $response = array('error_code' => 500, 'error_msg' => $e->getMessage());
            }
        }

        return $response;
    }

    /*------ PUT METHOD ------*/

    //Modify Book
    public function modifyBook(Request $request) {
        $response = array('error_code' => 400, 'error_msg' => 'Error inserting info');
            
        $book = Book::find($request->id);
        foreach($request->all() as $key => $value) {

            if(!empty(trim($value))) {
                if ($value !== null ){
                    try{
                        if ($key != 'api_token'){
                            $book->$key = $request->$key; 
                            $book->save(); 
                            $response = array('error_code' => 200, 'error_msg' => 'OK');
                        }
                    } catch (\Exception $e){
                        $response = array('error_code' => 500, 'error_msg' => $e->getMessage());
                    }
                }
                
            } else {
                print('Value '. $key . ' is empty!');
            };
        }

        return $response;
    }

    /*------ DELETE METHOD ------*/

    //Delete Book
    public function deleteBook(Request $request) {
        $book = Book::find($request->id);
        $book->delete();

        return response()->json([
            "message" => "deleted book"
        ], 200);
    }
}
