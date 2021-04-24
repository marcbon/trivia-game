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
     */
    public function index()
    {
        // Get all questions with pagination and more
        
        $data = array();
        
        // Build questions
        $questions = Question::paginate(10);
        $data['questions'] = $questions;
        
        // Build categories
        $categories = Category::all();
        $categories_data = array();
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
         
        // Create a question
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
        // Show a question
        return Question::find($id);
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
        // Update a question
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
        // Delete a question
        return Question::destroy($id);
    }
}
