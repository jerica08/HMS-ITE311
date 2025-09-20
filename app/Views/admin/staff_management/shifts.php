<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Shifts - HMS Admin</title>
    <link rel="stylesheet" href="/assets/css/dashboard-common.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }
        .staff-card {
            background: #fff;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 1rem;
        }
        .shifts-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .shifts-table th, .shifts-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        .shifts-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.8rem;
        }
        .badge.morning { background: #dcfce7; color: #166534; }
        .badge.afternoon { background: #fef3c7; color: #92400e; }
        .badge.night { background: #dbeafe; color: #1e40af; }
        .empty {
            text-align: center;
            color: #6b7280;
            padding: 2rem 1rem;
        }
    </style>
</head>
<body class="admin">
    <header class="header">
        <div class="header-content">
            <div class="logo">
                <h1><i class="fas fa-hospital"></i> Administrator</h1>
            </div>
            <div class="user-info">
                <div class="fas fa-user-circle"></div>
                <div>
                    <div style="font-weight: 600;">
                        <?= \App\Helpers\UserHelper::getDisplayName($currentUser ?? null) ?>
                    </div>
                    <div style="font-size: 0.9rem;opacity:0.8">
                        <?= \App\Helpers\UserHelper::getDisplayRole($currentUser ?? null) ?>
                    </div>
                </div>
                <button class="logout-btn" onclick="handleLogout()">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </div>
        </div>
    </header>

    <div class="main-container">
        <nav class="sidebar">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="<?= base_url('admin/dashboard') ?>" class="nav-link">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('admin/staff') ?>" class="nav-link active">
                        <i class="fas fa-user-tie nav-icon"></i>
                        Staff Management
                    </a>
                </li>
            </ul>
        </nav>

        <main class="content">
            <div class="page-header">
                <h1 class="page-title">Staff Shifts</h1>
                <a class="btn btn-secondary" href="<?= base_url('admin/staff') ?>"><i class="fas fa-arrow-left"></i> Back to Staff</a>
            </div>

            <div class="staff-card">
                <div style="font-weight:600; margin-bottom: 0.25rem;">
                    <?= esc(($staff['first_name'] ?? '') . ' ' . ($staff['last_name'] ?? '')) ?>
                    <span style="color:#6b7280; font-weight:400;">&middot; <?= esc($staff['role'] ?? '') ?></span>
                </div>
                <div style="color:#6b7280; font-size:0.9rem;">
                    <?= esc($staff['department'] ?? '') ?> &middot; <?= esc($staff['email'] ?? '') ?>
                </div>
            </div>

            <table class="shifts-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Type</th>
                        <th>Department/Unit</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody id="shiftsBody">
                    <tr><td colspan="6" class="empty">Loading shifts...</td></tr>
                </tbody>
            </table>
        </main>
    </div>

    <script>
        async function loadShifts() {
            const tbody = document.getElementById('shiftsBody');
            try {
                const res = await fetch('<?= base_url('admin/staff/' . ($staff['id'] ?? 0) . '/shifts/api') ?>', { headers: { 'Accept': 'application/json' } });
                const json = await res.json();
                const rows = Array.isArray(json?.data) ? json.data : [];
                if (rows.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="6" class="empty">No shifts scheduled.</td></tr>';
                    return;
                }
                tbody.innerHTML = rows.map(r => `
                    <tr>
                        <td>${r.date ?? ''}</td>
                        <td>${r.start ?? ''}</td>
                        <td>${r.end ?? ''}</td>
                        <td><span class="badge ${r.type ?? ''}">${r.type ?? ''}</span></td>
                        <td>${r.department ?? ''}</td>
                        <td>${r.notes ?? ''}</td>
                    </tr>
                `).join('');
            } catch (e) {
                tbody.innerHTML = '<tr><td colspan="6" class="empty">Failed to load shifts.</td></tr>';
            }
        }
        loadShifts();
    </script>

    <script src="<?= base_url('js/logout.js') ?>"></script>
</body>
</html>
