<?php

namespace App\Http\Controllers;

use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatbotController extends Controller
{
    private ChatbotService $chatbot;

    public function __construct(ChatbotService $chatbot)
    {
        $this->chatbot = $chatbot;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message'    => 'required|string|max:1000',
            'session_id' => 'nullable|string|regex:/^[a-zA-Z0-9_-]{1,64}$/',
        ]);

        $sessionId = $request->input('session_id', Str::random(40));
        $message   = $request->input('message');

        if (strtolower(trim($message)) === '/reset') {
            $this->chatbot->resetContext($sessionId);
            return response()->json(['message' => 'Sesi chat telah direset.']);
        }

        $response = $this->chatbot->processMessage($message, $sessionId);
        $response['session_id'] = $sessionId;

        return response()->json($response);
    }
}
