<?php

return [
    'provider' => env('LLM_PROVIDER', 'openai'),
    'openai' => [
        'key' => env('OPENAI_API_KEY'),
        'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
        'endpoint' => 'https://api.openai.com/v1/chat/completions',
    ],
    'gemini' => [
        'api_key' => env('GEMINI_API_KEY'),
        'model' => env('GEMINI_MODEL', 'gemini-2.0-flash'),
        'endpoint' => 'https://generativelanguage.googleapis.com/v1beta/models',
    ],
];
