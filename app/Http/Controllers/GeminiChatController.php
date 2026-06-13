<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GeminiChatController extends Controller
{
    // Nama fungsi dikembalikan menjadi 'chat' agar sesuai dengan web.php
    public function chat(Request $request)
    {
        // Validasi input sesuai dengan chat.blade.php
        $request->validate([
            'message' => 'required|string',
        ]);

        $userMessage = trim($request->input('message'));

        $apiKey = trim(env('GEMINI_API_KEY'));
        $apiKey = str_replace(['"', "'"], '', $apiKey);

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'error' => 'Konfigurasi Error: API Key Gemini belum dipasang!'
            ], 500);
        }

        // Kunci Anti-Spam (Mencegah Error 429)
        $lockKey = 'gemini_lock_' . md5($userMessage);
        if (Cache::has($lockKey)) {
            return response()->json([
                'success' => false,
                'error' => 'Mohon tunggu sebentar, barista sedang meracik jawaban...'
            ], 429);
        }

        Cache::put($lockKey, true, 5);

        // Gunakan model stabil gemini-2.5-flash di v1beta
        $googleModel = 'gemini-2.5-flash';
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$googleModel}:generateContent?key={$apiKey}";

        // Perintah mutlak untuk mengunci topik Kopi
        $systemInstruction = "SISTEM UTAMA (WAJIB DIPATUHI):\n"
            . "Anda adalah barista dan asisten ramah dari kedai 'Beranda Coffee'. Anda HANYA boleh melayani pertanyaan seputar kopi, menu kedai Beranda Coffee, rekomendasi minuman kopi, cita rasa kopi, atau sejarah kopi.\n"
            . "JIKA customer menanyakan hal di luar topik kopi dan kedai kopi (seperti matematika, koding/pemrograman, resep masakan non-kopi, otomotif/bengkel, sejarah umum, cerita, atau tugas sekolah), Anda TANPA KECUALI wajib menjawab PERSIS dengan kalimat ini:\n"
            . "\"Maaf, saya hanya bisa membantu Anda dengan pertanyaan seputar kopi dan menu Beranda Coffee saja.\"\n"
            . "Jangan memberikan penjelasan tambahan atau basa-basi apa pun jika pertanyaan di luar topik kopi!";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json'
            ])
            ->timeout(30)
            ->post($endpoint, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $systemInstruction . "\n\nPertanyaan Customer: " . $userMessage]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.4,
                    'maxOutputTokens' => 700,
                ]
            ]);

            Cache::forget($lockKey);

            if ($response->successful()) {
                $result = $response->json();
                $aiText = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
                
                if ($aiText) {
                    // Mengembalikan format 'success' dan 'reply' sesuai chat.blade.php
                    return response()->json([
                        'success' => true,
                        'reply' => trim($aiText)
                    ]);
                }
                
                return response()->json([
                    'success' => false,
                    'error' => 'Respons kosong dari Google Studio.'
                ]);
            }

            if ($response->status() == 429) {
                return response()->json([
                    'success' => false,
                    'error' => 'Batas kuota harian API Key Anda habis. Silakan periksa di Google AI Studio.'
                ], 429);
            }

            return response()->json([
                'success' => false,
                'error' => 'Google API Error dengan status: ' . $response->status()
            ], $response->status());

        } catch (\Exception $e) {
            Cache::forget($lockKey);
            return response()->json([
                'success' => false,
                'error' => 'Gagal terhubung ke server AI, silakan coba beberapa saat lagi.'
            ], 500);
        }
    }
}