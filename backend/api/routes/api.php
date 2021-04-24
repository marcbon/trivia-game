<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Question;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function() {
    // Questions CRUD
    // 1. [GET] /api/questions
    // 2. [POST] /api/questions
    // 3. [GET] /api/questions/{id}
    // 4. [PUT] /api/questions/{id}
    // 5. [DELETE] /api/questions/{id}
    Route::apiResource('questions', 'QuestionController');

    // Search questions
    Route::post('/search', function(Request $request) {
       $search = $request->get('search_term');
       $data = array();
       $questions = DB::table('questions')->whereRaw('LOWER(question) LIKE ? ', '%' . strtolower($search) . '%')->get();
       $total = DB::table('questions')->whereRaw('LOWER(question) LIKE ? ', '%' . strtolower($search) . '%')->get()->count();
       $data['questions'] = $questions;
       $data['total'] = $total;

       return $data;
    });

    // Get all categories
    Route::get('/categories', function() {
       // Build categories
       $categories = Category::all();
       $categories_data = array();
       foreach ($categories as $k => $v) {
           $categories_data[$v['id']] = $v['type'];
       }
       $data['categories'] = $categories_data;
       
       return $data;
    });

    // Get questions of a specific category
    Route::get('/categories/{id}/questions', function($id) {
       $data = array();
       $questions = DB::table('questions')->where('category_id', '=', $id)->get();
       $total = DB::table('questions')->where('category_id', '=', $id)->get()->count();
       $current_category = DB::table('categories')->where('id', '=', $id)->get()->first();
       $data['questions'] = $questions;
       $data['total'] = $total;
       $data['category'] = $current_category->id;

       return $data;
    });
    
    // Get questions to play the quiz
    Route::post('/quiz', function(Request $request) {
        $data = array();
        $previous_questions = $request->get('previous_questions');
        $category_id = $request->get('quiz_category');
        if (isset($previous_questions) && $previous_questions) {
            $question = DB::table('questions')->where('category_id', '=', $category_id)->whereNotIn('id', $previous_questions)->inRandomOrder()->first();
        } else {
            $question = DB::table('questions')->where('category_id', '=', $category_id)->inRandomOrder()->first();
        }
        $data['current_question'] = $question;
        
        return $data;
    });
 });

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
