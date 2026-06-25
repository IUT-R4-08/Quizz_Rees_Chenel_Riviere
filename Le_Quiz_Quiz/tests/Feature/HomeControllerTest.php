<?php

namespace Tests\Feature;

use App\Models\Theme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_anyone_can_access_the_home_page_and_see_themes()
    {
        Theme::factory()->count(3)->create();

        $response = $this->get('/'); 

        $response->assertStatus(200);

        $response->assertViewHas('themes', function ($themes) {
            return $themes->count() === 3;
        });
    }

    /** @test */
    public function test_home_page_works_fine_when_there_are_no_themes()
    {

        $response = $this->get('/');

        $response->assertStatus(200);
        
        $response->assertViewHas('themes', function ($themes) {
            return $themes->isEmpty();
        });
    }
}