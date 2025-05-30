<?php

return [
    'provider' => env('LLM_PROVIDER', 'openai'),
    'openai' => [
        'key' => env('OPENAI_API_KEY'),
    ],
    'anthropic' => [
        'key' => env('ANTHROPIC_API_KEY'),
    ],
];
