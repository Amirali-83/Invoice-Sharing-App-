<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Team Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --ink: #0d0d0d;
            --paper: #f5f2ed;
            --accent: #d4541a;
            --muted: #7a7572;
            --border: #ddd9d4;
            --error: #c0392b;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--ink);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        body::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at 20% 50%, rgba(212,84,26,0.08) 0%, transparent 60%),
                        radial-gradient(ellipse at 80% 50%, rgba(212,84,26,0.04) 0%, transparent 60%);
        }
        .bg-text {
            position: absolute;
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 22vw;
            color: rgba(255,255,255,0.02);
            user-select: none;
            letter-spacing: -0.05em;
            white-space: nowrap;
        }
        .panel {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 24px;
        }
        .brand {
            text-align: center;
            margin-bottom: 36px;
        }
        .brand-logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.2rem;
            color: white;
            letter-spacing: 0.1em;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .brand-dot { width: 8px; height: 8px; background: var(--accent); border-radius: 50%; }
        .brand p {
            color: rgba(255,255,255,0.35);
            font-size: 0.8rem;
            margin-top: 8px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .card {
            background: var(--paper);
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(0,0,0,0.4);
        }
        .card-top {
            background: var(--accent);
            padding: 24px 32px;
            color: white;
        }
        .card-top h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
        }
        .card-top p {
            font-size: 0.83rem;
            opacity: 0.8;
            margin-top: 4px;
        }
        .card-body { padding: 32px; }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 0.72rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
        }
        input {
            width: 100%;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            color: var(--ink);
            background: white;
            border: 1px solid var(--border);
            border-radius: 3px;
            padding: 12px 16px;
            transition: border-color 0.2s;
        }
        input:focus { outline: none; border-color: var(--accent); }
        input.invalid { border-color: var(--error); }
        .alert-error {
            background: #fdf1f0;
            border: 1px solid #f5c6c6;
            color: var(--error);
            padding: 11px 14px;
            border-radius: 3px;
            font-size: 0.85rem;
            margin-bottom: 20px;
        }
        .btn-login {
            width: 100%;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 14px;
            background: var(--ink);
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn-login:hover { background: #333; }
        .btn-login:disabled { opacity: 0.6; cursor: not-allowed; }
        .spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }
        .btn-login.loading .spinner { display: block; }
        .btn-login.loading .lbl { display: none; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: rgba(255,255,255,0.35);
            text-decoration: none;
            font-size: 0.82rem;
            transition: color 0.2s;
        }
        .back-link a:hover { color: rgba(255,255,255,0.7); }
    </style>
</head>
<body>
<div class="bg-text">FINANCE</div>
<div class="panel">
    <div class="brand">
        <div class="brand-logo"><span class="brand-dot"></span> FINANCE PORTAL</div>
        <p>Finance Team Access</p>
    </div>
    <div class="card">
        <div class="card-top">
            <h1>Sign In</h1>
            <p>Access the invoice dashboard</p>
        </div>
        <div class="card-body">
            <div id="alertBox"></div>
            <form id="loginForm" novalidate>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" autocomplete="username" autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" autocomplete="current-password">
                </div>
                <button type="submit" class="btn-login" id="loginBtn">
                    <span class="lbl">Sign In →</span>
                    <div class="spinner"></div>
                </button>
            </form>
        </div>
    </div>
    <div class="back-link">
        <a href="<?= BASE_URL ?>">← Back to Upload Portal</a>
    </div>
</div>

<script>
const BASE_URL = '<?= BASE_URL ?>';
document.getElementById('loginForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const btn = document.getElementById('loginBtn');
    btn.disabled = true;
    btn.classList.add('loading');
    document.getElementById('alertBox').innerHTML = '';

    const fd = new FormData(this);
    try {
        const res  = await fetch(BASE_URL + 'admin/login/post', { method: 'POST', body: fd });
        const data = await res.json();
        if (data.success) {
            window.location.href = BASE_URL + 'admin/dashboard';
        } else {
            document.getElementById('alertBox').innerHTML =
                `<div class="alert-error">${data.message}</div>`;
        }
    } catch {
        document.getElementById('alertBox').innerHTML =
            '<div class="alert-error">Network error. Please try again.</div>';
    } finally {
        btn.disabled = false;
        btn.classList.remove('loading');
    }
});
</script>
</body>
</html>
