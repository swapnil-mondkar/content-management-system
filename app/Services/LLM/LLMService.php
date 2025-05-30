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
        info("Generating metadata for provider: $provider");
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
        info("Calling OpenAI API with prompt: $prompt");
        $response = Http::withToken($apiKey)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
            ]);

        $text = $response->json('choices.0.message.content');
        info("OpenAI response: $response");
        return json_decode($text, true) ?? ['slug' => null, 'summary' => null];
    }
}
