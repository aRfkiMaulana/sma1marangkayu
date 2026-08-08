<?php

namespace Tests\Unit;

use App\Services\ChatbotService;
use Tests\TestCase;

class ChatbotServiceTest extends TestCase
{
    public function test_chatbot_can_process_greeting(): void
    {
        $bot = new ChatbotService();
        $res = $bot->processMessage('halo', 'test_session');

        $this->assertArrayHasKey('message', $res);
        $this->assertStringContainsString('SMAN 1 Marangkayu', $res['message']);
    }

    public function test_chatbot_can_answer_buku_tahunan_info(): void
    {
        $bot = new ChatbotService();
        $res = $bot->processMessage('bagaimana cara isi buku tahunan?', 'test_session');

        $this->assertStringContainsString('Buku Tahunan', $res['message']);
    }
}
