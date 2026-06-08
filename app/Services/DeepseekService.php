<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DeepSeekService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = env('DEEPSEEK_API_KEY');
        $this->baseUrl = 'https://api.deepseek.com/v1';
    }

    public function chat($message)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post($this->baseUrl . '/chat/completions', [
            'model' => 'deepseek-chat',
            'messages' => [
                ['role' => 'system', 'content' => 'Anda adalah asisten yang ramah untuk website kedai kopi bernama Beranda Coffee.'],
                ['role' => 'user', 'content' => $message]
            ],
            'temperature' => 0.7,
            'max_tokens' => 1000,
        ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['message']['content'];
        }

        throw new \Exception('DeepSeek API Error: ' . $response->body());
    }
}