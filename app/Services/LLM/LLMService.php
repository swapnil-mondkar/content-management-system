<?php

namespace App\Services\LLM;

use Illuminate\Support\Facades\Http;

class LLMService
{
    /**
     * Generate metadata for an article using the configured LLM provider.
     *
     * @param string $title
     * @param string $content
     * @return array
     */
    public function generateMetadata(string $title, string $content): array
    {
        $provider = config('llm.provider');

        $prompt = <<<PROMPT
You are a content assistant. Given the article title and content, generate:

1. A short SEO-friendly slug (3-6 words, lowercase, hyphen-separated).
2. A brief summary (2-3 sentences).

Respond in this JSON format:
{
  "slug": "...",
  "summary": "..."
}

Title: $title

Content: $content
PROMPT;


        return match ($provider) {
            'openai' => $this->callOpenAI($prompt),
            'gemini' => $this->callGemini($prompt),
            default => ['slug' => null, 'summary' => null],
        };
    }

    /**
     * Call the OpenAI API to generate metadata.
     *
     * @param string $prompt
     * @return array
     */
    protected function callOpenAI(string $prompt): array
    {
        $apiKey = config('llm.openai.key');
        $url = config('llm.openai.endpoint');
        $model = config('llm.openai.model');

        $response = Http::withToken($apiKey)
            ->post($url, [
                'model' => $model,
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
            ]);

        $text = $response->json('choices.0.message.content');

        return json_decode($text, true) ?? ['slug' => null, 'summary' => null];
    }

    protected function callGemini(string $prompt): array
    {
        $apiKey = config('llm.gemini.api_key');
        $endpoint = config('llm.gemini.endpoint');
        $model = config('llm.gemini.model');

        $url = "{$endpoint}/{$model}:generateContent?key={$apiKey}";
        $response = Http::post($url, [
            'contents' => [[
                'parts' => [['text' => $prompt]]
            ]]
        ]);

        $text = $response->json('candidates.0.content.parts.0.text') ?? '';

        $parsed = json_decode($text, true);

        if (is_array($parsed) && isset($parsed['slug'], $parsed['summary'])) {
            return $parsed;
        }

        preg_match('/"slug"\s*:\s*"([^"]+)"/i', $text, $slugMatch);
        preg_match('/"summary"\s*:\s*"([^"]+)"/i', $text, $summaryMatch);

        return [
            'slug' => $slugMatch[1] ?? null,
            'summary' => $summaryMatch[1] ?? null,
        ];
    }
}
