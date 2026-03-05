# Invoice Sharing Application
### Built for XAMPP / PHP 7.4+

---

## Quick Setup (5 minutes)

### 1. Copy to XAMPP
Place the `invoice-app` folder inside:
```
C:\xampp\htdocs\invoice-app\
```

### 2. Create the Database
1. Open your browser → go to `http://localhost/phpmyadmin`
2. Click **Import** tab
3. Choose file: `invoice-app/database/schema.sql`
4. Click **Go**

### 3. Enable mod_rewrite in XAMPP
1. Open `C:\xampp\apache\conf\httpd.conf`
2. Find `#LoadModule rewrite_module` → remove the `#`
3. Find `AllowOverride None` (inside `<Directory "C:/xampp/htdocs">`) → change to `AllowOverride All`
4. Restart Apache in XAMPP Control Panel

### 4. Configure (Optional)
Edit `config/database.php`:
- Change `DB_USER` / `DB_PASS` if your MySQL uses different credentials
- Change `ADMIN_USERNAME` and `ADMIN_PASSWORD` (default: `finance` / `Finance@2024`)

### 5. Create uploads folder (if missing)
The app auto-creates it, but you can manually ensure it exists:
```
invoice-app/public/uploads/
```

---

## Access URLs
| Page | URL |
|------|-----|
| Upload Portal | http://localhost/invoice-app/ |
| Finance Login | http://localhost/invoice-app/admin/login |
| Finance Dashboard | http://localhost/invoice-app/admin/dashboard |

---

## Default Admin Credentials
| Field | Value |
|-------|-------|
| Username | `finance` |
| Password | `Finance@2024` |

> ⚠️ Change these in `config/database.php` before using in production.

---

## Project Structure
```
invoice-app/
├── config/
│   └── database.php          # DB config + admin credentials
├── controllers/
│   ├── UploadController.php  # Handles invoice uploads
│   └── AdminController.php   # Finance dashboard logic
├── models/
│   ├── Invoice.php           # Invoice DB operations
│   └── Department.php        # Departments & teams
├── views/
│   ├── uploader/
│   │   └── upload_form.php   # Uploader-facing form
│   └── admin/
│       ├── login.php         # Finance team login
│       └── dashboard.php     # Finance dashboard
├── public/
│   └── uploads/              # Uploaded invoice files (auto-created)
├── database/
│   └── schema.sql            # Database setup script
├── .htaccess                 # URL routing
└── index.php                 # Front controller / router
```

---

## Features

### Uploader Side
- Department dropdown (auto-loads teams on selection)
- Team dropdown (cascades from department)
- Uploader name field
- Invoice description textarea
- Drag & drop file upload (PDF, JPG, PNG, GIF, WEBP — max 10MB)
- Live file preview with remove option
- Success confirmation screen

### Finance Dashboard
- Stats overview (total, new, noted, PDF/image counts)
- Search across uploader name, description, department, team
- Filter by status (All / New / Noted)
- Sortable columns (name, status, date)
- Checkbox beside each invoice to toggle New ↔ Noted
- Bulk select & bulk status update
- Preview invoices inline (modal)
- Download individual invoices
- Toast notifications for all actions

---

## Security Notes
- Files stored with randomized names (UUID-based)
- MIME type + extension double-validation
- Session-based admin authentication
- SQL injection protection via prepared statements
- Directory listing disabled via .htaccess
- Direct access to sensitive files blocked

---

## Requirements
- PHP 7.4+ with mysqli extension
- MySQL 5.7+ or MariaDB 10.3+
- Apache with mod_rewrite enabled
- XAMPP 7.4+ recommended
