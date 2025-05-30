<?php

namespace App\Jobs;

use App\Models\Article;
use App\Services\LLM\LLMService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateArticleMetadata implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Execute the job to generate metadata for the article.
     *
     * @return void
     */
    public function handle()
    {
        info("Generating metadata for article ID {$this->article->id}...");
        $llm = app(LLMService::class);
        
        $response = $llm->generateMetadata(
            $this->article->title,
            $this->article->content
        );

        info("Generated metadata for article ID {$this->article->id}: " . json_encode($response));
        $this->article->slug = $response['slug'] ?? null;
        $this->article->summary = $response['summary'] ?? null;
        $this->article->save();
    }
}
