<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta';
    }

    public function chat($message)
    {
        if (!$this->apiKey) {
            throw new \Exception('GEMINI_API_KEY tidak ditemukan di file .env');
        }

        try {
            $response = Http::timeout(30)
                ->withOptions(['verify' => false])
                ->post($this->baseUrl . "/models/gemini-2.0-flash:generateContent?key=" . $this->apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => "Anda adalah asisten ramah untuk kedai kopi 'Beranda Coffee'. Jawab dalam bahasa Indonesia: " . $message]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 500,
                    ]
                ]);

            Log::info('Gemini API Response Status: ' . $response->status());

            if ($response->status() === 401) {
                throw new \Exception('API Key tidak valid. Periksa GEMINI_API_KEY di .env');
            }

            if ($response->status() === 429) {
                throw new \Exception('Terlalu banyak permintaan. Coba lagi nanti.');
            }

            if ($response->status() === 403) {
                throw new \Exception('API Key tidak memiliki akses ke model ini. Periksa kuota Anda di Google AI Studio.');
            }

            if (!$response->successful()) {
                throw new \Exception('API Error: ' . $response->body());
            }

            $data = $response->json();
            
            if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                throw new \Exception('Respons API tidak valid: ' . json_encode($data));
            }

            return $data['candidates'][0]['content']['parts'][0]['text'];

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            Log::error('Gemini Connection Error: ' . $e->getMessage());
            throw new \Exception('Tidak dapat terhubung ke server Google Gemini. Periksa koneksi internet Anda.');
        } catch (\Exception $e) {
            Log::error('Gemini Error: ' . $e->getMessage());
            throw $e;
        }
    }
}