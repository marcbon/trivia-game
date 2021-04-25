<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Category;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * 
     */
    public function index()
    {
        $data = [];
        
        // Build questions
        $questions = Question::paginate(10);
        $data['questions'] = $questions;
        
        // Build categories
        $categories = Category::all();
        $categories_data = [];
        foreach ($categories as $k => $v) {
            $categories_data[$v['id']] = $v['type'];
        }
        $data['categories'] = $categories_data;
        
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     */
    public function store(Request $request)
    {
        // Validate data
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'difficulty' => 'required',
            'category_id' => 'required'
        ]);
         
        // Create question
        return Question::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * 
     */
    public function show($id)
    {
        // Show question
        $question = Question::find($id);
        if ($question) {
            return $question;
        } else {
            abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate data
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'difficulty' => 'required',
            'category_id' => 'required'
        ]);
        
        // Update question
        $question = Question::find($id);
        $question->update($request->all());
        
        return $question;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * 
     */
    public function destroy($id)
    {
        // Check if question id exists
        $question = Question::find($id);
        if ($question) {
            // Delete question
            return Question::destroy($id);
        } else {
            abort(404);
        }
    }
}
