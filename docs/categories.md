# API Reference

---

## Categories

### GET /api/categories

**Description:** List all categories.

**Headers:**
- Authorization: Bearer {token}

**Success (200):**
```json
[
  { "id": 1, "name": "Tech" },
  { "id": 2, "name": "Health" }
]
```

---

### POST /api/categories

**Description:** Create a new category.

**Headers:**
- Authorization: Bearer {token}
- Content-Type: application/json

**Body:**
- `name` (string, required)

**Success (201):**
```json
{
  "id": 3,
  "name": "Education"
}
```

---

### PUT /api/categories/{id}

**Description:** Update a category.

**Headers:**
- Authorization: Bearer {token}
- Content-Type: application/json

**Body:**
- `name` (string, required)

**Success (200):**
```json
{
  "id": 3,
  "name": "Updated Name"
}
```

---

### DELETE /api/categories/{id}

**Description:** Delete a category.

**Headers:**
- Authorization: Bearer {token}

**Success (204):** No content

---
