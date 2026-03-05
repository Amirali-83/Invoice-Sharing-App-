<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Invoice — Finance Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink: #002147;
            --paper: #f5f2ed;
            --accent: #d4541a;
            --accent-light: #f4e4d9;
            --muted: #7a7572;
            --border: #ddd9d4;
            --white: #ffffff;
            --success: #2a7a4b;
            --error: #c0392b;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--paper);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Header ── */
        header {
            background: var(--ink);
            color: var(--white);
            padding: 0 40px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1.1rem;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logo-dot {
            width: 8px; height: 8px;
            background: var(--accent);
            border-radius: 50%;
            display: inline-block;
        }
        .admin-link {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: color 0.2s;
        }
        .admin-link:hover { color: var(--accent); }

        /* ── Hero ── */
        .hero {
            background: var(--ink);
            color: var(--white);
            padding: 60px 40px 80px;
            position: relative;
            overflow: hidden;
        }
        .hero::after {
            content: 'INVOICE';
            position: absolute;
            right: -20px;
            bottom: -40px;
            font-family: 'Syne', sans-serif;
            font-size: 10rem;
            font-weight: 800;
            color: rgba(255,255,255,0.04);
            pointer-events: none;
            letter-spacing: -0.05em;
        }
        .hero h1 {
            font-family: 'Syne', sans-serif;
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 16px;
        }
        .hero h1 span { color: var(--accent); }
        .hero p {
            color: rgba(255,255,255,0.55);
            max-width: 480px;
            font-size: 1rem;
            line-height: 1.7;
        }

        /* ── Main layout ── */
        .main {
            flex: 1;
            max-width: 780px;
            width: 100%;
            margin: 40px auto 60px;
            padding: 0 24px;
        }

        /* ── Form card ── */
        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }
        .card-header {
            padding: 28px 36px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .step-badge {
            width: 32px; height: 32px;
            background: var(--accent);
            color: var(--white);
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            border-radius: 2px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .card-header h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: 0.03em;
        }

        form { padding: 36px; }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group.full { grid-column: 1 / -1; }

        label {
            font-size: 0.75rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
        }
        label .req { color: var(--accent); margin-left: 2px; }

        input[type="text"],
        textarea,
        select {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            color: var(--ink);
            background: var(--paper);
            border: 1px solid var(--border);
            border-radius: 3px;
            padding: 12px 16px;
            width: 100%;
            transition: border-color 0.2s, background 0.2s;
            appearance: none;
            -webkit-appearance: none;
        }
        input[type="text"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: var(--accent);
            background: var(--white);
        }
        textarea { resize: vertical; min-height: 100px; }
        select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23999' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 36px;
            cursor: pointer;
        }
        select:disabled { opacity: 0.5; cursor: not-allowed; }

        /* ── Drop zone ── */
        .drop-zone {
            border: 2px dashed var(--border);
            border-radius: 4px;
            padding: 40px 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
            background: var(--paper);
        }
        .drop-zone:hover, .drop-zone.active {
            border-color: var(--accent);
            background: var(--accent-light);
        }
        .drop-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }
        .drop-icon { font-size: 2.5rem; margin-bottom: 12px; display: block; }
        .drop-text { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 1rem; margin-bottom: 6px; }
        .drop-sub { font-size: 0.82rem; color: var(--muted); }
        .drop-sub strong { color: var(--accent); }

        .file-preview {
            display: none;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            background: var(--accent-light);
            border: 1px solid rgba(212,84,26,0.2);
            border-radius: 3px;
            margin-top: 12px;
        }
        .file-preview.show { display: flex; }
        .file-icon { font-size: 1.8rem; }
        .file-info { flex: 1; min-width: 0; }
        .file-name { font-weight: 500; font-size: 0.9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .file-size { font-size: 0.78rem; color: var(--muted); margin-top: 2px; }
        .file-remove {
            background: none; border: none; cursor: pointer;
            color: var(--muted); font-size: 1.2rem; padding: 4px; line-height: 1;
            transition: color 0.2s;
        }
        .file-remove:hover { color: var(--error); }

        /* ── Submit ── */
        .form-footer {
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 16px;
        }
        .btn-submit {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 14px 36px;
            background: var(--accent);
            color: var(--white);
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .btn-submit:hover { background: #b8441a; }
        .btn-submit:active { transform: scale(0.98); }
        .btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
        .btn-submit .spinner {
            width: 16px; height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }
        .btn-submit.loading .spinner { display: block; }
        .btn-submit.loading .btn-label { display: none; }

        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Error/Success messages ── */
        .alert {
            padding: 14px 18px;
            border-radius: 3px;
            font-size: 0.88rem;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .alert-error { background: #fdf1f0; border: 1px solid #f5c6c6; color: var(--error); }
        .alert-success { background: #edf7f2; border: 1px solid #b8dec9; color: var(--success); }
        .alert ul { padding-left: 18px; margin-top: 6px; }

        /* ── Success state ── */
        .success-screen {
            display: none;
            padding: 60px 36px;
            text-align: center;
        }
        .success-screen.show { display: block; }
        .success-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            animation: pop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        @keyframes pop { from { transform: scale(0); } to { transform: scale(1); } }
        .success-screen h2 {
            font-family: 'Syne', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            margin-bottom: 10px;
        }
        .success-screen p { color: var(--muted); margin-bottom: 28px; }
        .btn-reset {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 12px 28px;
            background: var(--ink);
            color: var(--white);
            border: none;
            border-radius: 3px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-reset:hover { background: #333; }

        .field-error { font-size: 0.78rem; color: var(--error); display: none; }
        .field-error.show { display: block; }
        input.invalid, select.invalid, textarea.invalid { border-color: var(--error); }

        @media (max-width: 600px) {
            .form-grid { grid-template-columns: 1fr; }
            header { padding: 0 20px; }
            .hero { padding: 40px 20px 60px; }
            .main { margin-top: -20px; padding: 0 16px; }
            form { padding: 24px 20px; }
            .card-header { padding: 20px 20px; }
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <span class="logo-dot"></span>
        FINANCE PORTAL
    </div>
    <a href="<?= BASE_URL ?>admin/login" class="admin-link">Finance Team →</a>
</header>

<div class="hero">
    <h1>Submit an<br><span>Invoice</span></h1>
    <p>Upload your invoice document securely. The finance team will review and process your submission.</p>
</div>

<div class="main">
    <div class="card">
        <div class="card-header">
            <div class="step-badge">1</div>
            <h2>Invoice Submission Form</h2>
        </div>

        <div id="successScreen" class="success-screen">
            <div class="success-icon">✅</div>
            <h2>Invoice Submitted!</h2>
            <p>Your invoice has been sent to the Finance team.<br>They will review it shortly.</p>
            <button class="btn-reset" onclick="resetForm()">Submit Another</button>
        </div>

        <form id="uploadForm" novalidate>
            <div id="alertBox"></div>

            <div class="form-grid">
                <!-- Uploader Name -->
                <div class="form-group full">
                    <label for="uploader_name">Your Full Name <span class="req">*</span></label>
                    <input type="text" id="uploader_name" name="uploader_name" placeholder="e.g. Sarah Johnson" maxlength="150">
                    <span class="field-error" id="err_name">Please enter your name.</span>
                </div>

                <!-- Department -->
                <div class="form-group">
                    <label for="department_id">Department <span class="req">*</span></label>
                    <select id="department_id" name="department_id">
                        <option value="">— Select Department —</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span class="field-error" id="err_dept">Please select a department.</span>
                </div>

                <!-- Team -->
                <div class="form-group">
                    <label for="team_id">Team <span class="req">*</span></label>
                    <select id="team_id" name="team_id" disabled>
                        <option value="">— Select Department First —</option>
                    </select>
                    <span class="field-error" id="err_team">Please select a team.</span>
                </div>

                <!-- Description -->
                <div class="form-group full">
                    <label for="description">Invoice Description <span class="req">*</span></label>
                    <textarea id="description" name="description" placeholder="Brief description of this invoice — what it's for, vendor name, period, etc." rows="4"></textarea>
                    <span class="field-error" id="err_desc">Please enter a description.</span>
                </div>

                <!-- File Upload -->
                <div class="form-group full">
                    <label>Invoice File <span class="req">*</span></label>
                    <div class="drop-zone" id="dropZone">
                        <input type="file" id="invoice_file" name="invoice_file" accept=".jpg,.jpeg,.png,.gif,.webp,.pdf">
                        <span class="drop-icon" style="font-size:2rem;opacity:0.4">⬆</span>
                        <div class="drop-text">Drop file here or click to browse</div>
                        <div class="drop-sub">Accepted: <strong>PDF, JPG, PNG, GIF, WEBP</strong> — Max 10MB</div>
                    </div>
                    <div class="file-preview" id="filePreview">
                        <span class="file-icon" id="fileIcon">📄</span>
                        <div class="file-info">
                            <div class="file-name" id="fileName">filename.pdf</div>
                            <div class="file-size" id="fileSize">0 KB</div>
                        </div>
                        <button type="button" class="file-remove" id="fileRemove" title="Remove file">✕</button>
                    </div>
                    <span class="field-error" id="err_file">Please attach a file.</span>
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn-submit" id="submitBtn">
                    <span class="btn-label">Submit Invoice →</span>
                    <div class="spinner"></div>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const BASE_URL = '<?= BASE_URL ?>';

// ── Team loading ──
document.getElementById('department_id').addEventListener('change', function () {
    const deptId = this.value;
    const teamSel = document.getElementById('team_id');
    teamSel.innerHTML = '<option value="">Loading...</option>';
    teamSel.disabled = true;

    if (!deptId) {
        teamSel.innerHTML = '<option value="">— Select Department First —</option>';
        return;
    }

    fetch(BASE_URL + 'upload/teams?department_id=' + deptId)
        .then(r => r.json())
        .then(teams => {
            teamSel.innerHTML = '<option value="">— Select Team —</option>';
            teams.forEach(t => {
                const opt = document.createElement('option');
                opt.value = t.id;
                opt.textContent = t.name;
                teamSel.appendChild(opt);
            });
            teamSel.disabled = false;
        })
        .catch(() => {
            teamSel.innerHTML = '<option value="">Error loading teams</option>';
        });
});

// ── File input UI ──
const fileInput   = document.getElementById('invoice_file');
const dropZone    = document.getElementById('dropZone');
const filePreview = document.getElementById('filePreview');
const fileName    = document.getElementById('fileName');
const fileSize    = document.getElementById('fileSize');
const fileIcon    = document.getElementById('fileIcon');
const fileRemove  = document.getElementById('fileRemove');

function formatBytes(bytes) {
    if (bytes < 1024) return bytes + ' B';
    if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
    return (bytes / 1048576).toFixed(2) + ' MB';
}

function showFile(file) {
    fileName.textContent  = file.name;
    fileSize.textContent  = formatBytes(file.size);
    fileIcon.textContent  = file.type === 'application/pdf' ? '📄' : '🖼️';
    filePreview.classList.add('show');
    dropZone.style.display = 'none';
    document.getElementById('err_file').classList.remove('show');
}

fileInput.addEventListener('change', () => {
    if (fileInput.files[0]) showFile(fileInput.files[0]);
});

fileRemove.addEventListener('click', () => {
    fileInput.value = '';
    filePreview.classList.remove('show');
    dropZone.style.display = '';
});

// Drag events
['dragenter','dragover'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.add('active'); }));
['dragleave','drop'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.remove('active'); }));
dropZone.addEventListener('drop', ev => {
    const files = ev.dataTransfer.files;
    if (files[0]) {
        const dt = new DataTransfer();
        dt.items.add(files[0]);
        fileInput.files = dt.files;
        showFile(files[0]);
    }
});

// ── Form submission ──
document.getElementById('uploadForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    clearErrors();

    let valid = true;
    const name   = document.getElementById('uploader_name').value.trim();
    const dept   = document.getElementById('department_id').value;
    const team   = document.getElementById('team_id').value;
    const desc   = document.getElementById('description').value.trim();
    const file   = fileInput.files[0];

    if (!name)  { showError('err_name', 'uploader_name'); valid = false; }
    if (!dept)  { showError('err_dept', 'department_id'); valid = false; }
    if (!team)  { showError('err_team', 'team_id'); valid = false; }
    if (!desc)  { showError('err_desc', 'description'); valid = false; }
    if (!file)  { document.getElementById('err_file').classList.add('show'); valid = false; }

    if (!valid) return;

    const btn = document.getElementById('submitBtn');
    btn.disabled = true;
    btn.classList.add('loading');

    const fd = new FormData(this);
    try {
        const res  = await fetch(BASE_URL + 'upload/store', { method: 'POST', body: fd });
        const data = await res.json();

        if (data.success) {
            document.getElementById('uploadForm').style.display = 'none';
            document.getElementById('successScreen').classList.add('show');
        } else {
            showAlert('error', data.errors || ['An error occurred. Please try again.']);
        }
    } catch (err) {
        showAlert('error', ['Network error. Please try again.']);
    } finally {
        btn.disabled = false;
        btn.classList.remove('loading');
    }
});

function showError(errId, fieldId) {
    document.getElementById(errId).classList.add('show');
    document.getElementById(fieldId).classList.add('invalid');
}

function clearErrors() {
    document.querySelectorAll('.field-error').forEach(el => el.classList.remove('show'));
    document.querySelectorAll('.invalid').forEach(el => el.classList.remove('invalid'));
    document.getElementById('alertBox').innerHTML = '';
}

function showAlert(type, messages) {
    const box = document.getElementById('alertBox');
    const list = Array.isArray(messages) && messages.length > 1
        ? '<ul>' + messages.map(m => `<li>${m}</li>`).join('') + '</ul>'
        : `<p>${Array.isArray(messages) ? messages[0] : messages}</p>`;
    box.innerHTML = `<div class="alert alert-${type}">${list}</div>`;
    box.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

function resetForm() {
    document.getElementById('uploadForm').reset();
    document.getElementById('uploadForm').style.display = '';
    document.getElementById('successScreen').classList.remove('show');
    filePreview.classList.remove('show');
    dropZone.style.display = '';
    document.getElementById('team_id').innerHTML = '<option value="">— Select Department First —</option>';
    document.getElementById('team_id').disabled = true;
}
</script>

</body>
</html>
