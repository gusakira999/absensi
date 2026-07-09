
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - Absensi Mahasiswa</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  /* WARNA DEFAULT (LIGHT MODE) */
  :root{
    --bg: #f6f7fb;
    --sidebar: #ffffff;
    --card: #ffffff;
    --border: #e7e9f0;
    --text-hi: #171a23;
    --text-lo: #6b7086;
    --accent: #4f46e5;
    --accent-soft: #ecebfd;
    --amber: #f59e0b;
    --amber-soft: #fef3e2;
    --emerald: #10b981;
    --emerald-soft: #e6f8f1;
    --hover-bg: #f4f5f9;
  }

  /* WARNA KHUSUS DARK MODE */
  @media (prefers-color-scheme: dark) {
    :root {
      --bg: #0a0e13;
      --sidebar: #12171e;
      --card: #12171e;
      --border: #22282f;
      --text-hi: #f2f4f5;
      --text-lo: #9aa4ad;
      --accent-soft: rgba(79, 70, 229, 0.15);
      --amber-soft: rgba(245, 158, 11, 0.15);
      --emerald-soft: rgba(16, 185, 129, 0.15);
      --hover-bg: #1a202c;
    }
  }

  *{box-sizing:border-box;}
  html,body{
    margin:0; padding:0;
    background:var(--bg); color:var(--text-hi);
    font-family:'Inter', sans-serif; min-height:100vh;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .layout{ display:flex; min-height:100vh; }

  /* SIDEBAR */
  .sidebar{
    width:264px; flex-shrink:0; background:var(--sidebar);
    border-right:1px solid var(--border); display:flex;
    flex-direction:column; padding:20px 16px;
    transition: background-color 0.3s ease, border-color 0.3s ease;
  }
  .brand{
    display:flex; align-items:center; gap:10px;
    padding:8px 6px 24px;
  }
  .brand-icon{
    width:34px; height:34px; border-radius:9px; background:var(--accent-soft);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
  }
  .brand-name{
    font-family:'Space Grotesk', sans-serif; font-weight:600; font-size:15px;
  }

  .nav-label{
    font-size:12px; font-weight:600; letter-spacing:0.4px;
    text-transform:uppercase; color:var(--text-lo); padding:8px 10px 8px;
  }
  .nav{ flex:1; }
  .nav-item{
    display:flex; align-items:center; gap:11px; padding:10px 12px;
    border-radius:9px; font-size:14.5px; font-weight:500;
    color:var(--text-lo); text-decoration:none; margin-bottom:2px;
    transition: all 0.2s;
  }
  .nav-item svg{ flex-shrink:0; }
  .nav-item:hover{ background:var(--hover-bg); color:var(--text-hi); }
  .nav-item.active{ background:var(--accent-soft); color:var(--accent); }

  .sidebar-bottom{
    border-top:1px solid var(--border); padding-top:12px; margin-top:12px;
  }
  .profile-chip{
    display:flex; align-items:center; gap:10px; padding:9px 10px;
    border-radius:9px; border:1px solid var(--border); margin-top:10px;
    cursor:pointer; transition: background-color 0.2s;
  }
  .profile-chip:hover{ background:var(--hover-bg); }
  .avatar{
    width:28px; height:28px; border-radius:50%; background:var(--accent);
    color:#fff; display:flex; align-items:center; justify-content:center;
    font-size:13px; font-weight:600; font-family:'Space Grotesk', sans-serif;
    flex-shrink:0;
  }
  .profile-chip span{ font-size:14px; font-weight:500; flex:1; }

  /* MAIN */
  .main{ flex:1; padding:40px 48px; }
  h1{ font-family:'Space Grotesk', sans-serif; font-size:28px; font-weight:700; margin:0 0 8px; }
  .page-desc{ color:var(--text-lo); font-size:15px; margin:0 0 32px; }

  .stat-grid{
    display:grid; grid-template-columns:repeat(4, 1fr); gap:16px; margin-bottom:36px;
  }
  .stat-card{
    background:var(--card); border:1px solid var(--border); border-radius:14px;
    padding:20px; transition: background-color 0.3s ease, border-color 0.3s ease;
  }
  .stat-icon{
    width:38px; height:38px; border-radius:9px;
    display:flex; align-items:center; justify-content:center; margin-bottom:14px;
  }
  .stat-icon.indigo{ background:var(--accent-soft); }
  .stat-icon.emerald{ background:var(--emerald-soft); }
  .stat-icon.amber{ background:var(--amber-soft); }
  .stat-value{
    font-family:'Space Grotesk', sans-serif; font-size:24px; font-weight:700; margin-bottom:2px;
  }
  .stat-label{ font-size:13.5px; color:var(--text-lo); }

  .panel{
    background:var(--card); border:1px solid var(--border); border-radius:14px;
    padding:28px; color:var(--text-lo); font-size:14.5px;
    transition: background-color 0.3s ease, border-color 0.3s ease;
  }

  @media (max-width: 960px){ .stat-grid{ grid-template-columns:repeat(2, 1fr); } }
  @media (max-width: 720px){
    .layout{ flex-direction:column; }
    .sidebar{ width:100%; border-right:none; border-bottom:1px solid var(--border); }
    .main{ padding:24px 20px; }
  }
</style>
</head>
<body>
<div class="layout">

  <aside class="sidebar">
    <div class="brand">
      <div class="brand-icon">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
      </div>
      <div class="brand-name">Absensi Mahasiswa</div>
    </div>

    <div class="nav-label">Admin</div>
    <nav class="nav">
      <!-- Gunakan request()->routeIs() untuk menandai menu aktif secara otomatis -->
      <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
        Dashboard
      </a>
      <a href="{{ route('admin.users') }}" class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        Manajemen User
      </a>
      <a href="{{ route('admin.courses') }}" class="nav-item {{ request()->routeIs('admin.courses') ? 'active' : '' }}">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
        Manajemen Mata Kuliah
      </a>
      <a href="{{ route('admin.schedules') }}" class="nav-item {{ request()->routeIs('admin.schedules') ? 'active' : '' }}">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        Kelola Jadwal
      </a>
      <a href="{{ route('admin.reports') }}" class="nav-item {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 14l4-4 3 3 5-6"/></svg>
        Monitoring Kehadiran
      </a>
    </nav>

    <div class="sidebar-bottom">
      <form method="POST" action="{{ route('logout') }}" style="margin:0;">
        @csrf
        <button type="submit" class="nav-item" style="width:100%; border:none; background:none; cursor:pointer; font-family:inherit; font-size:inherit;">
          <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          Keluar
        </button>
      </form>
      
      <div class="profile-chip">
        <!-- Avatar Inisial dari Nama User -->
        <div class="avatar">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</div>
        <span>{{ auth()->user()->name ?? 'Administrator' }}</span>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6b7086" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 9l4-4 4 4M8 15l4 4 4-4"/></svg>
      </div>
    </div>
  </aside>

  <main class="main">
    <h1>Admin Dashboard</h1>
    <p class="page-desc">Ringkasan kondisi kehadiran mahasiswa hari ini.</p>

    <div class="stat-grid">
      <div class="stat-card">
        <div class="stat-icon indigo">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <!-- Ganti angka statis ini dengan variabel dari controller nanti -->
        <div class="stat-value">1.284</div>
        <div class="stat-label">Total Mahasiswa</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon emerald">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
        </div>
        <div class="stat-value">42</div>
        <div class="stat-label">Mata Kuliah Aktif</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon amber">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
        </div>
        <div class="stat-value">18</div>
        <div class="stat-label">Kelas Hari Ini</div>
      </div>
      <div class="stat-card">
        <div class="stat-icon indigo">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
        </div>
        <div class="stat-value">92%</div>
        <div class="stat-label">Tingkat Kehadiran</div>
      </div>
    </div>

    <div class="panel">
      Placeholder untuk panel admin: manajemen mata kuliah, jadwal, dan laporan kehadiran akan tampil di sini.
    </div>
  </main>

</div>
</body>
</html>