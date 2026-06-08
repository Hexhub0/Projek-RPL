<?php

namespace App\Http\Controllers;

use App\Services\GeminiService; // <-- Panggil service yang baru
use Illuminate\Http\Request;

class DeepSeekChatController extends Controller
{
    public function chat(Request $request, GeminiService $gemini) // <-- Nama parameter diubah
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        try {
            // Panggil method chat dari GeminiService kita
            $reply = $gemini->chat($request->message);
            
            return response()->json([
                'success' => true,
                'reply' => $reply
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}