<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY'); // Pastikan sudah setting GEMINI_API_KEY di file .env

        try {
            // Memanggil API Resmi Google Gemini (Menggunakan Model gemini-1.5-flash)
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $userMessage]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                // Mengambil teks balasan dari struktur JSON Gemini
                $botReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak dapat memahami pesan tersebut.';

                return response()->json([
                    'success' => true,
                    'reply' => $botReply
                ]);
            }

            return response()->json([
                'success' => false,
                'error' => 'Gagal terhubung ke API Gemini dengan status: ' . $response->status()
            ], $response->status());

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}