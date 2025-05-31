# Project Setup Guide

## Requirements
- PHP 8.1+
- Composer
- MySQL or any supported database
- Laravel 12

## Steps

1. **Clone repo**
   ```bash
   git clone https://github.com/swapnil-mondkar/content-management-system.git
   cd content-management-system
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
    - Copy `.env.example` to `.env`
    - Update `.env` with your database and mail config
    - Add API keys for LLM services:
      ```env
      OPENAI_API_KEY=your_openai_key
      OPENAI_MODEL=your_openai_model

      GEMINI_MODEL=your_gemini_model
      GEMINI_API_KEY=your_gemini_key
      LLM_PROVIDER=openai # or gemini
      ```

4. **Generate app key**
   ```bash
   php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Run seeders**
   ```bash
   php artisan db:seed
   ```

7. **Run development server**
   ```bash
   php artisan serve
   ```

8. **Run queue worker (for background LLM jobs)**
   ```bash
   php artisan queue:work
   ```

9. **Access API**
    - Base URL: http://localhost:8000/api

10. **Postman URI**
    - https://www.postman.com/joint-operations-astronomer-90943320/user-management-system/collection/fu13sgx/content-management-system-kitchen-sprus

## Notes
- Use Postman or any API client to test endpoints.
- Ensure you include `Authorization: Bearer {token}` header for protected routes.
- Sanctum is used for API token authentication.
- Asynchronous LLM jobs will auto-generate article slugs and summaries.
- Supported LLM providers: OpenAI and Gemini (configurable via `.env`).
