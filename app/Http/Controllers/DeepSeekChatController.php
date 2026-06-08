<?php

namespace App\Http\Controllers;

use App\Services\DeepSeekService;
use Illuminate\Http\Request;

class DeepSeekChatController extends Controller
{
    public function chat(Request $request, DeepSeekService $deepSeek)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        try {
            $reply = $deepSeek->chat($request->message);
            
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