<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatbotApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_chatbot_api_endpoint_works(): void
    {
        $res = $this->postJson('/chatbot/send', [
            'message' => 'Siapa kepala sekolah?',
        ]);

        $res->assertStatus(200)
            ->assertJsonStructure(['message', 'suggestions', 'session_id']);
    }

    public function test_chatbot_rejects_invalid_session_id(): void
    {
        $res = $this->postJson('/chatbot/send', [
            'message'    => 'Test',
            'session_id' => '../../invalid-session-id!@#',
        ]);

        $res->assertStatus(422)
            ->assertJsonValidationErrors(['session_id']);
    }
}
