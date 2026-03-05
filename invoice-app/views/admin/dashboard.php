<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Dashboard — Invoice Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --ink: #002147;
            --bg: #f0ede8;
            --white: #ffffff;
            --accent: #d4541a;
            --accent-light: #f9ede4;
            --muted: #7a7572;
            --border: #ddd9d4;
            --success: #2a7a4b;
            --success-bg: #eaf5ef;
            --new-color: #1a5fd4;
            --new-bg: #e4edf9;
            --sidebar: #002147;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--sidebar);
            color: white;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
        }
        .sidebar-brand {
            padding: 28px 24px 24px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-logo {
            font-family: 'Syne', sans-serif;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 0.08em;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .logo-dot { width: 7px; height: 7px; background: var(--accent); border-radius: 50%; }
        .sidebar-sub {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.3);
            margin-top: 4px;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }
        .sidebar-nav { flex: 1; padding: 20px 0; }
        .nav-label {
            padding: 0 24px 8px;
            font-size: 0.65rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.2);
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 24px;
            color: rgba(255,255,255,0.5);
            text-decoration: none;
            font-size: 0.88rem;
            cursor: pointer;
            transition: color 0.2s, background 0.2s;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
        }
        .nav-item:hover { color: white; background: rgba(255,255,255,0.05); }
        .nav-item.active { color: white; background: rgba(212,84,26,0.15); border-left: 2px solid var(--accent); }
        .nav-icon { font-size: 1rem; width: 20px; text-align: center; }
        .sidebar-footer {
            padding: 20px 24px;
            border-top: 1px solid rgba(255,255,255,0.06);
        }
        .sidebar-footer a {
            display: flex; align-items: center; gap: 8px;
            color: rgba(255,255,255,0.35);
            text-decoration: none;
            font-size: 0.82rem;
            transition: color 0.2s;
        }
        .sidebar-footer a:hover { color: rgba(255,255,255,0.7); }

        /* ── Main ── */
        .main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            padding: 0 32px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 50;
        }
        .topbar h1 {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
        }
        .topbar-actions { display: flex; align-items: center; gap: 12px; }
        .bulk-action-bar {
            display: none;
            align-items: center;
            gap: 10px;
            padding: 0 12px;
            background: var(--ink);
            color: white;
            border-radius: 3px;
            height: 36px;
            font-size: 0.82rem;
        }
        .bulk-action-bar.show { display: flex; }
        .bulk-action-bar strong { color: var(--accent); }

        /* ── Content ── */
        .content { padding: 28px 32px; flex: 1; }

        /* ── Stats cards ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }
        .stat-card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 20px 22px;
        }
        .stat-label {
            font-size: 0.7rem;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 8px;
        }
        .stat-value {
            font-family: 'DM Sans', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            line-height: 1;
            min-height: 2.5rem;
            display: flex;
            align-items: center;
            font-variant-numeric: tabular-nums;
        }
        .stat-value.accent { color: var(--accent); }
        .stat-value.blue { color: var(--new-color); }
        .stat-value.green { color: var(--success); }

        /* ── Filters ── */
        .filters-bar {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 4px;
            padding: 16px 20px;
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }
        .filters-bar input[type="text"] {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.88rem;
            padding: 8px 12px;
            border: 1px solid var(--border);
            border-radius: 3px;
            width: 220px;
            transition: border-color 0.2s;
            color: var(--ink);
        }
        .filters-bar input[type="text"]:focus { outline: none; border-color: var(--accent); }
        .filter-btn {
            font-family: 'DM Sans', sans-serif;
            font-size: 0.82rem;
            padding: 8px 14px;
            border-radius: 3px;
            border: 1px solid var(--border);
            cursor: pointer;
            background: white;
            color: var(--muted);
            transition: all 0.15s;
        }
        .filter-btn:hover { border-color: var(--accent); color: var(--accent); }
        .filter-btn.active { background: var(--ink); color: white; border-color: var(--ink); }
        .filters-bar .spacer { flex: 1; }

        /* ── Table ── */
        .table-wrap {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 4px;
            overflow: hidden;
        }
        .table-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .table-title {
            font-family: 'Syne', sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
        }
        .table-count {
            font-size: 0.78rem;
            color: var(--muted);
            background: var(--bg);
            padding: 3px 10px;
            border-radius: 20px;
        }
        table { width: 100%; border-collapse: collapse; }
        thead tr { background: var(--bg); border-bottom: 2px solid var(--border); }
        th {
            font-size: 0.68rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--muted);
            padding: 10px 16px;
            text-align: left;
            white-space: nowrap;
        }
        th.sortable { cursor: pointer; user-select: none; }
        th.sortable:hover { color: var(--ink); }
        th .sort-icon { margin-left: 4px; opacity: 0.4; }
        th.sorted .sort-icon { opacity: 1; color: var(--accent); }
        td { padding: 14px 16px; border-bottom: 1px solid var(--border); font-size: 0.88rem; vertical-align: middle; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #faf8f5; }
        tr.selected td { background: var(--accent-light); }

        .check-cell { width: 44px; }
        .check-cell input[type="checkbox"] {
            width: 16px; height: 16px; cursor: pointer;
            accent-color: var(--accent);
        }
        .uploader-name { font-weight: 500; }
        .dept-badge {
            display: inline-block;
            font-size: 0.72rem;
            padding: 2px 8px;
            background: var(--bg);
            border-radius: 2px;
            color: var(--muted);
        }
        .file-type-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            padding: 3px 8px;
            border-radius: 2px;
            text-transform: uppercase;
        }
        .file-type-badge.pdf { background: #fdecea; color: #c0392b; }
        .file-type-badge.img { background: var(--new-bg); color: var(--new-color); }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 2px;
        }
        .status-badge.new { background: var(--new-bg); color: var(--new-color); }
        .status-badge.noted { background: var(--success-bg); color: var(--success); }
        .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
        .action-btns { display: flex; gap: 6px; align-items: center; }
        .btn-icon {
            width: 30px; height: 30px;
            border: 1px solid var(--border);
            background: white;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 0.85rem;
            text-decoration: none;
            color: var(--muted);
            transition: all 0.15s;
        }
        .btn-icon:hover { border-color: var(--accent); color: var(--accent); background: var(--accent-light); }
        .desc-text {
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            color: var(--muted);
        }
        .date-text { color: var(--muted); font-size: 0.82rem; white-space: nowrap; }
        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }
        .empty-icon { font-size: 3rem; margin-bottom: 16px; opacity: 0.4; }
        .empty-state h3 {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--muted);
        }
        .empty-state p { color: var(--muted); font-size: 0.88rem; }

        /* ── Btn ── */
        .btn {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.78rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 8px 16px;
            border-radius: 3px;
            border: none;
            cursor: pointer;
            transition: all 0.15s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-primary { background: var(--accent); color: white; }
        .btn-primary:hover { background: #b8441a; }
        .btn-dark { background: var(--ink); color: white; }
        .btn-dark:hover { background: #333; }
        .btn-outline { background: white; color: var(--ink); border: 1px solid var(--border); }
        .btn-outline:hover { border-color: var(--ink); }

        /* ── Preview modal ── */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.7);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }
        .modal-overlay.open { opacity: 1; pointer-events: all; }
        .modal {
            background: white;
            border-radius: 6px;
            width: 100%;
            max-width: 760px;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transform: scale(0.95);
            transition: transform 0.2s;
            box-shadow: 0 32px 80px rgba(0,0,0,0.3);
        }
        .modal-overlay.open .modal { transform: scale(1); }
        .modal-header {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }
        .modal-info { flex: 1; min-width: 0; }
        .modal-info h3 { font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .modal-meta { font-size: 0.78rem; color: var(--muted); margin-top: 3px; }
        .modal-close {
            background: none; border: none; cursor: pointer;
            font-size: 1.4rem; color: var(--muted); line-height: 1;
            transition: color 0.2s; flex-shrink: 0;
        }
        .modal-close:hover { color: var(--ink); }
        .modal-body { flex: 1; overflow: auto; background: var(--bg); display: flex; align-items: center; justify-content: center; min-height: 300px; }
        .modal-body iframe { width: 100%; height: 500px; border: none; }
        .modal-body img { max-width: 100%; max-height: 500px; object-fit: contain; }
        .modal-footer { padding: 14px 20px; border-top: 1px solid var(--border); display: flex; justify-content: flex-end; gap: 10px; }

        /* ── Toast ── */
        #toast {
            position: fixed;
            bottom: 24px; right: 24px;
            background: var(--ink);
            color: white;
            padding: 12px 20px;
            border-radius: 4px;
            font-size: 0.88rem;
            font-weight: 500;
            z-index: 2000;
            transform: translateY(80px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 8px 24px rgba(0,0,0,0.2);
        }
        #toast.show { transform: translateY(0); opacity: 1; }
        #toast.success { border-left: 3px solid var(--success); }
        #toast.error { border-left: 3px solid var(--error); }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .sidebar { display: none; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 600px) {
            .content { padding: 16px; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 10px; }
            .topbar { padding: 0 16px; }
        }
    </style>
</head>
<body>

<!-- ── Sidebar ── -->
<nav class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo"><span class="logo-dot"></span> FINANCE PORTAL</div>
        <div class="sidebar-sub">Finance Team Dashboard</div>
    </div>
    <div class="sidebar-nav">
        <div class="nav-label">Navigation</div>
        <a class="nav-item active" href="<?= BASE_URL ?>admin/dashboard">
            <span class="nav-icon"><i class="fas fa-list-ul"></i></span> All Invoices
        </a>
        <a class="nav-item" href="<?= BASE_URL ?>admin/dashboard?status=new">
            <span class="nav-icon"><i class="fas fa-circle-dot"></i></span> New Invoices
        </a>
        <a class="nav-item" href="<?= BASE_URL ?>admin/dashboard?status=noted">
            <span class="nav-icon"><i class="fas fa-circle-check"></i></span> Noted Invoices
        </a>
    </div>
    <div class="sidebar-footer">
        <a href="<?= BASE_URL ?>admin/logout">
            <span>⇠</span> Sign Out
        </a>
    </div>
</nav>

<!-- ── Main ── -->
<div class="main">
    <!-- Topbar -->
    <div class="topbar">
        <h1>Invoice Dashboard</h1>
        <div class="topbar-actions">
            <div class="bulk-action-bar" id="bulkBar">
                <strong id="selectedCount">0</strong> selected
                <button class="btn btn-primary" onclick="bulkMark('noted')">✓ Mark as Noted</button>
                <button class="btn btn-outline" onclick="bulkMark('new')">↺ Mark as New</button>
            </div>
            <a href="<?= BASE_URL ?>" class="btn btn-outline" style="text-decoration:none">+ New Upload</a>
        </div>
    </div>

    <!-- Content -->
    <div class="content">

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Invoices</div>
                <div class="stat-value"><?= $stats['total'] ?? 0 ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">New</div>
                <div class="stat-value blue"><?= $stats['new_count'] ?? 0 ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Noted</div>
                <div class="stat-value green"><?= $stats['noted_count'] ?? 0 ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">PDFs / Images</div>
                <div class="stat-value accent"><?= $stats['pdf_count'] ?? 0 ?> / <?= $stats['image_count'] ?? 0 ?></div>
            </div>
        </div>

        <!-- Filters -->
        <form method="GET" action="<?= BASE_URL ?>admin/dashboard" class="filters-bar">
            <div style="position:relative;display:flex;align-items:center;">
                <i class="fas fa-search" style="position:absolute;left:10px;color:#aaa;font-size:0.78rem;pointer-events:none"></i>
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Search invoices..." style="padding-left:30px">
            </div>
            <input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>">
            <input type="hidden" name="order" value="<?= htmlspecialchars($order) ?>">
            <button type="submit" class="filter-btn">Search</button>
            <?php if ($search): ?>
                <a href="<?= BASE_URL ?>admin/dashboard<?= $status ? '?status='.$status : '' ?>" class="filter-btn">✕ Clear</a>
            <?php endif; ?>
            <div class="spacer"></div>
            <a href="<?= BASE_URL ?>admin/dashboard<?= $search ? '?search='.urlencode($search) : '' ?>" class="filter-btn <?= !$status ? 'active' : '' ?>">All</a>
            <a href="<?= BASE_URL ?>admin/dashboard?status=new<?= $search ? '&search='.urlencode($search) : '' ?>" class="filter-btn <?= $status === 'new' ? 'active' : '' ?>">New</a>
            <a href="<?= BASE_URL ?>admin/dashboard?status=noted<?= $search ? '&search='.urlencode($search) : '' ?>" class="filter-btn <?= $status === 'noted' ? 'active' : '' ?>">Noted</a>
        </form>

        <!-- Table -->
        <div class="table-wrap">
            <div class="table-header">
                <span class="table-title">
                    <?= $status === 'new' ? 'New Invoices' : ($status === 'noted' ? 'Noted Invoices' : 'All Invoices') ?>
                </span>
                <span class="table-count"><?= count($invoices) ?> invoice<?= count($invoices) !== 1 ? 's' : '' ?></span>
            </div>

            <?php if (empty($invoices)): ?>
                <div class="empty-state">
                    <div class="empty-icon"><i class="fas fa-inbox" style="font-size:3rem;opacity:0.3;color:var(--muted)"></i></div>
                    <h3>No invoices found</h3>
                    <p><?= $search ? 'Try a different search term.' : 'No invoices have been submitted yet.' ?></p>
                </div>
            <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th class="check-cell"><input type="checkbox" id="checkAll" title="Select all"></th>
                        <th class="sortable <?= $sort === 'uploader_name' ? 'sorted' : '' ?>" onclick="sortBy('uploader_name')">
                            Submitted By <span class="sort-icon"><?= $sort === 'uploader_name' ? ($order === 'ASC' ? '↑' : '↓') : '↕' ?></span>
                        </th>
                        <th>Department / Team</th>
                        <th>Description</th>
                        <th>File</th>
                        <th class="sortable <?= $sort === 'status' ? 'sorted' : '' ?>" onclick="sortBy('status')">
                            Status <span class="sort-icon"><?= $sort === 'status' ? ($order === 'ASC' ? '↑' : '↓') : '↕' ?></span>
                        </th>
                        <th class="sortable <?= $sort === 'uploaded_at' ? 'sorted' : '' ?>" onclick="sortBy('uploaded_at')">
                            Date <span class="sort-icon"><?= $sort === 'uploaded_at' ? ($order === 'ASC' ? '↑' : '↓') : '↕' ?></span>
                        </th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $inv): ?>
                    <tr id="row-<?= $inv['id'] ?>" data-id="<?= $inv['id'] ?>" data-status="<?= $inv['status'] ?>">
                        <td class="check-cell">
                            <input type="checkbox" class="row-check" value="<?= $inv['id'] ?>" onchange="updateBulkBar()">
                        </td>
                        <td><span class="uploader-name"><?= htmlspecialchars($inv['uploader_name']) ?></span></td>
                        <td>
                            <div><?= htmlspecialchars($inv['department_name']) ?></div>
                            <span class="dept-badge"><?= htmlspecialchars($inv['team_name']) ?></span>
                        </td>
                        <td>
                            <div class="desc-text" title="<?= htmlspecialchars($inv['description']) ?>">
                                <?= htmlspecialchars($inv['description']) ?>
                            </div>
                        </td>
                        <td>
                            <?php $isImg = strpos($inv['file_type'], 'image/') === 0; ?>
                            <span class="file-type-badge <?= $isImg ? 'img' : 'pdf' ?>">
                                <?= $isImg ? '🖼 IMG' : '📄 PDF' ?>
                            </span>
                        </td>
                        <td>
                            <span class="status-badge <?= $inv['status'] ?>" id="badge-<?= $inv['id'] ?>">
                                <span class="status-dot"></span>
                                <?= strtoupper($inv['status']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="date-text">
                                <?= date('d M Y', strtotime($inv['uploaded_at'])) ?><br>
                                <span style="opacity:0.6"><?= date('H:i', strtotime($inv['uploaded_at'])) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="action-btns">
                                <!-- Status toggle checkbox -->
                                <label title="Mark as <?= $inv['status'] === 'new' ? 'Noted' : 'New' ?>" style="cursor:pointer">
                                    <input type="checkbox"
                                        class="status-check"
                                        data-id="<?= $inv['id'] ?>"
                                        <?= $inv['status'] === 'noted' ? 'checked' : '' ?>
                                        onchange="toggleStatus(this)"
                                        style="width:16px;height:16px;cursor:pointer;accent-color:var(--success)">
                                </label>
                                <!-- Preview -->
                                <button class="btn-icon" title="Preview" onclick="previewInvoice(<?= $inv['id'] ?>, '<?= htmlspecialchars(addslashes($inv['original_filename'])) ?>', '<?= $inv['file_type'] ?>', '<?= htmlspecialchars(addslashes($inv['uploader_name'])) ?>', '<?= $inv['department_name'] ?>')"><i class="fas fa-eye"></i></button>
                                <!-- Download -->
                                <a class="btn-icon" href="<?= BASE_URL ?>admin/download?id=<?= $inv['id'] ?>" title="Download" download><i class="fas fa-download"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>

    </div><!-- /content -->
</div><!-- /main -->

<!-- ── Preview Modal ── -->
<div class="modal-overlay" id="previewModal">
    <div class="modal">
        <div class="modal-header">
            <div class="modal-info">
                <h3 id="modalTitle">Invoice Preview</h3>
                <div class="modal-meta" id="modalMeta"></div>
            </div>
            <button class="modal-close" onclick="closeModal()">✕</button>
        </div>
        <div class="modal-body" id="modalBody">
            <p>Loading...</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-outline" onclick="closeModal()">Close</button>
            <a class="btn btn-dark" id="modalDownload" href="#" download>⬇ Download</a>
        </div>
    </div>
</div>

<!-- ── Toast ── -->
<div id="toast"></div>

<script>
const BASE_URL = '<?= BASE_URL ?>';
const currentSort  = '<?= $sort ?>';
const currentOrder = '<?= $order ?>';
const currentStatus = '<?= $status ?>';
const currentSearch = '<?= urlencode($search) ?>';

// ── Sort ──
function sortBy(col) {
    const newOrder = (currentSort === col && currentOrder === 'DESC') ? 'ASC' : 'DESC';
    let url = BASE_URL + 'admin/dashboard?sort=' + col + '&order=' + newOrder;
    if (currentStatus) url += '&status=' + currentStatus;
    if (currentSearch) url += '&search=' + currentSearch;
    window.location.href = url;
}

// ── Select all ──
document.getElementById('checkAll').addEventListener('change', function() {
    document.querySelectorAll('.row-check').forEach(cb => {
        cb.checked = this.checked;
        cb.closest('tr').classList.toggle('selected', this.checked);
    });
    updateBulkBar();
});

function updateBulkBar() {
    const checked = document.querySelectorAll('.row-check:checked');
    const bar = document.getElementById('bulkBar');
    document.getElementById('selectedCount').textContent = checked.length;
    bar.classList.toggle('show', checked.length > 0);
}

// ── Status toggle (single) ──
async function toggleStatus(checkbox) {
    const id = checkbox.dataset.id;
    const status = checkbox.checked ? 'noted' : 'new';
    const fd = new FormData();
    fd.append('ids[]', id);
    fd.append('status', status);

    try {
        const res  = await fetch(BASE_URL + 'admin/status', { method: 'POST', body: fd });
        const data = await res.json();
        if (data.success) {
            const badge = document.getElementById('badge-' + id);
            badge.className = 'status-badge ' + status;
            badge.innerHTML = '<span class="status-dot"></span>' + status.toUpperCase();
            showToast(status === 'noted' ? '✓ Marked as Noted' : '↺ Marked as New', 'success');
        } else {
            checkbox.checked = !checkbox.checked;
            showToast('Failed to update status.', 'error');
        }
    } catch {
        checkbox.checked = !checkbox.checked;
        showToast('Network error.', 'error');
    }
}

// ── Bulk status ──
async function bulkMark(status) {
    const checked = [...document.querySelectorAll('.row-check:checked')];
    if (!checked.length) return;

    const fd = new FormData();
    checked.forEach(cb => fd.append('ids[]', cb.value));
    fd.append('status', status);

    try {
        const res  = await fetch(BASE_URL + 'admin/status', { method: 'POST', body: fd });
        const data = await res.json();
        if (data.success) {
            checked.forEach(cb => {
                const id = cb.value;
                const badge = document.getElementById('badge-' + id);
                badge.className = 'status-badge ' + status;
                badge.innerHTML = '<span class="status-dot"></span>' + status.toUpperCase();
                // Sync the status checkbox
                const row = document.getElementById('row-' + id);
                if (row) row.querySelector('.status-check').checked = status === 'noted';
                cb.checked = false;
                cb.closest('tr').classList.remove('selected');
            });
            document.getElementById('checkAll').checked = false;
            updateBulkBar();
            showToast(`✓ ${data.affected} invoice(s) marked as ${status}`, 'success');
        }
    } catch {
        showToast('Network error.', 'error');
    }
}

// ── Preview modal ──
function previewInvoice(id, filename, fileType, uploader, dept) {
    document.getElementById('modalTitle').textContent = filename;
    document.getElementById('modalMeta').textContent  = uploader + ' · ' + dept;
    document.getElementById('modalDownload').href = BASE_URL + 'admin/download?id=' + id;

    const body = document.getElementById('modalBody');
    const url  = BASE_URL + 'admin/preview?id=' + id;

    if (fileType === 'application/pdf') {
        body.innerHTML = `<iframe src="${url}" title="Invoice Preview"></iframe>`;
    } else {
        body.innerHTML = `<img src="${url}" alt="Invoice Preview" style="padding:20px">`;
    }

    document.getElementById('previewModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('previewModal').classList.remove('open');
    document.getElementById('modalBody').innerHTML = '';
    document.body.style.overflow = '';
}

document.getElementById('previewModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeModal(); });

// ── Toast ──
let toastTimer;
function showToast(msg, type = 'success') {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.className = 'show ' + type;
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => { t.className = ''; }, 2800);
}
</script>

</body>
</html>
