# Authentication API

## POST /api/login

**Description:** Login user and get token.

**Headers:**
- Content-Type: application/json

**Body:**
- email (string, required)
- password (string, required)

**Success (200):**
```json
{
  "status": true,
  "message": "Login successful.",
  "token": "token_here",
  "user": { "id": 1, "name": "John Doe", "email": "user@example.com" }
}
```

## POST /api/logout

**Description:** Logout user, revoke token.

**Headers:**
- Authorization: Bearer {token}

**Success (200):**
```json
{
  "status": true,
  "message": "Logged out successfully."
}
```
