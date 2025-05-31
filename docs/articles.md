# API Reference

---

## Articles

### GET /api/articles

**Description:** List all articles with filters.

**Headers:**
- Authorization: Bearer {token}

**Query Parameters (optional):**
- `status`, `category_id`, `from_date`, `to_date`

**Success (200):**
```json
[
  {
    "id": 1,
    "title": "First Article",
    "slug": "first-article",
    "summary": "This is a summary.",
    "status": "published",
    "categories": [...]
  }
]
```

---

### POST /api/articles

**Description:** Create a new article.

**Headers:**
- Authorization: Bearer {token}
- Content-Type: application/json

**Body:**
- `title`, `content`, `category_ids[]`, `status`, `published_at`

**Success (201):**
```json
{
  "id": 2,
  "title": "New Article",
  "slug": "generated-slug-123",
  "summary": "Generated summary..."
}
```

---

### PUT /api/articles/{id}

**Description:** Update an article.

**Headers:**
- Authorization: Bearer {token}
- Content-Type: application/json

**Body:**
- `title`, `content`, `category_ids[]`, `status`

**Success (200):**
```json
{
  "id": 2,
  "title": "Updated Title"
}
```

---

### DELETE /api/articles/{id}

**Description:** Delete an article.

**Headers:**
- Authorization: Bearer {token}

**Success (204):** No content
