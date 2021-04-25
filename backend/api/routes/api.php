<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Question;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')
        ->middleware(['api', 'json-response'])
        ->group(function() {
            // Questions CRUD
            Route::apiResource('questions', 'QuestionController');

            // Search questions
            Route::post('/search', function(Request $request) {
                // Validate data
                $request->validate([
                    'search_term' => 'required'
                ]);

                $search = $request->get('search_term');
                $data = [];
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
               $categories_data = [];
               foreach ($categories as $k => $v) {
                   $categories_data[$v['id']] = $v['type'];
               }
               $data['categories'] = $categories_data;

               return $data;
            });

            // Get questions of a specific category
            Route::get('/categories/{id}/questions', function($id) {
                $category = Category::find($id);                
                if ($category) {
                    $data = [];
                    $questions = DB::table('questions')->where('category_id', '=', $id)->get();
                    $total = DB::table('questions')->where('category_id', '=', $id)->get()->count();
                    $current_category = DB::table('categories')->where('id', '=', $id)->get()->first();
                    $data['questions'] = $questions;
                    $data['total'] = $total;
                    $data['category'] = $current_category->id;

                    return $data;
                } else {
                    abort(404);
                }
            });

            // Get questions to play the quiz
            Route::post('/quiz', function(Request $request) {
                // Validate data
                $request->validate([
                    'quiz_category' => 'required'
                ]);

                $data = [];
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

// Default API user auth
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Handle all requests to the API that are not matched (Error 404)
Route::fallback(function() {
    $response = [];
    $response['message'] = 'Not Found';
    $response['code'] = 404;
    
    return response()->json($response, 404); 
});