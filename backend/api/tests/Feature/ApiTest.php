<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DB;

class ApiTest extends TestCase
{
    use WithFaker;
    
    protected $model = Question::class;
    
    public function test_can_create_question()
    {
        $data = [
            'question' => 'This is a test question',
            'answer' => 'This is a test answer',
            'difficulty' => '1',
            'category_id' => '1',
        ];
                
        $this->post('/api/v1/questions', $data)
                ->assertStatus(201);
    }
    
    public function test_can_update_question()
    {
        $id = 1;
        $data = [
            'question' => 'What movie earned Tom Hanks his third straight Oscar nomination, in 1996??',
            'answer' => 'Apollo 13.',
            'difficulty' => '5',
            'category_id' => '5',
        ];
                
        $this->put('/api/v1/questions/' . $id, $data)
                ->assertStatus(200);
    }
    
    public function test_can_delete_question()
    {
        $question = DB::table('questions')->get()->first();
        $this->delete('/api/v1/questions/' . $question->id)
                ->assertStatus(200);
    }
    
    public function test_can_search_question()
    {
        $data = [
            'search_term' => 'what'
        ];
        
        $this->post('/api/v1/search', $data)
                ->assertStatus(200);
    }
    
    public function test_can_show_question()
    {
        $question = DB::table('questions')->get()->first();
        $this->get('/api/v1/questions/' . $question->id)
                ->assertStatus(200);
    }
    
    public function test_can_show_questions()
    {
        $this->get('/api/v1/questions')
                ->assertStatus(200);
    }
    
    public function test_can_show_questions_by_category()
    {
        $id = 1;
        $this->get('/api/v1/categories/' . $id . '/questions')
                ->assertStatus(200);
    }
    
    public function test_can_show_categories()
    {
        $this->get('/api/v1/categories')
                ->assertStatus(200);
    }
    
    public function test_can_play_quiz()
    {
        $data = [
            'quiz_category' => '1'
        ];
        
        $this->post('/api/v1/quiz', $data)
                ->assertStatus(200);
    }
}
