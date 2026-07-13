<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manajemen User - Absensi Mahasiswa</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
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
    --red: #dc2626;
    --red-soft: #fdecec;
    --hover-bg: #f4f5f9;
    --tab-bg: #f0f1f6;
    --row-alt: #fafbfd;
  }

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
      --red-soft: rgba(220, 38, 38, 0.15);
      --hover-bg: #1a202c;
      --tab-bg: #1a202c;
      --row-alt: #1a202c;
    }
    .search-bar { background: #1a202c !important; border-color: #2d3748 !important; color: var(--text-hi) !important; }
    .search-bar::placeholder { color: #4a5568 !important; }
  }

  *{box-sizing:border-box;}
  html,body{
    margin:0; padding:0;
    background:var(--bg); color:var(--text-hi);
    font-family:'Inter', sans-serif; min-height:100vh;
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .layout{ display:flex; min-height:100vh; }

  .sidebar{
    width:264px; flex-shrink:0; background:var(--sidebar);
    border-right:1px solid var(--border); display:flex;
    flex-direction:column; padding:20px 16px;
    transition: background-color 0.3s ease, border-color 0.3s ease;
  }
  .brand{ display:flex; align-items:center; gap:10px; padding:8px 6px 24px; }
  .brand-icon{
    width:34px; height:34px; border-radius:9px; background:var(--accent-soft);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
  }
  .brand-name{ font-family:'Space Grotesk', sans-serif; font-weight:600; font-size:15px; }

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

  .main{ flex:1; padding:40px 48px; }
  h1{ font-family:'Space Grotesk', sans-serif; font-size:28px; font-weight:700; margin:0 0 8px; }
  .page-desc{ color:var(--text-lo); font-size:15px; margin:0 0 28px; }

  .search-bar{
    width:100%; padding:13px 16px; border-radius:10px;
    border:1px solid var(--border); background:var(--card);
    font-size:14.5px; color:var(--text-hi); font-family:'Inter', sans-serif;
    margin-bottom:24px; transition: all 0.2s;
  }
  .search-bar:focus{ outline:none; border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-soft); }

  .tabs{
    display:inline-flex; gap:4px; background:var(--tab-bg);
    padding:5px; border-radius:11px; margin-bottom:28px;
    transition: background-color 0.3s ease;
  }
  .tab{
    display:flex; align-items:center; gap:8px; padding:9px 18px;
    font-size:14.5px; font-weight:600; color:var(--text-lo);
    text-decoration:none; border-radius:8px; transition: all 0.2s;
  }
  .tab .emoji{ font-size:15px; }
  .tab .count{
    font-size:12px; font-weight:700; padding:1px 7px;
    border-radius:100px; background:#e4e6ef; color:var(--text-lo);
    transition: all 0.2s;
  }
  .tab.active{
    background:var(--card); color:var(--accent);
    box-shadow:0 2px 6px rgba(23,26,35,0.08);
  }
  .tab.active .count{ background:var(--accent-soft); color:var(--accent); }
  .tab:hover:not(.active){ color:var(--text-hi); }

  .section-head{
    display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;
  }
  .section-title-wrap{ display:flex; align-items:center; gap:13px; }
  .section-icon{
    width:40px; height:40px; border-radius:10px; background:var(--emerald-soft);
    display:flex; align-items:center; justify-content:center; flex-shrink:0;
  }
  .section-title{ font-family:'Space Grotesk', sans-serif; font-size:18px; font-weight:700; line-height:1.3; }
  .section-sub{ font-size:13px; color:var(--text-lo); font-weight:400; }
  
  .btn-primary{
    display:inline-flex; align-items:center; gap:7px; background:var(--accent);
    color:#fff; font-weight:600; font-size:14.5px; padding:11px 18px;
    border-radius:9px; text-decoration:none; border:none; cursor:pointer;
    box-shadow:0 4px 12px rgba(79,70,229,0.22); transition: filter 0.2s;
  }
  .btn-primary:hover{ filter:brightness(1.1); }

  .table-card{
    background:var(--card); border:1px solid var(--border); border-radius:14px;
    overflow:hidden; box-shadow:0 4px 18px rgba(23,26,35,0.05);
    transition: background-color 0.3s ease, border-color 0.3s ease;
  }
  table{ width:100%; border-collapse:collapse; }
  thead th{
    text-align:left; font-size:12.5px; font-weight:700; color:var(--accent);
    text-transform:uppercase; letter-spacing:0.5px; padding:15px 20px;
    background:var(--accent-soft); border-bottom:2px solid var(--accent);
  }
  tbody td{
    padding:16px 20px; font-size:14.5px; color:var(--text-hi);
    border-bottom:1px solid var(--border); transition: background-color 0.2s;
  }
  tbody tr:nth-child(even) td{ background:var(--row-alt); }
  tbody tr:last-child td{ border-bottom:none; }
  tbody tr:hover td{ background:var(--accent-soft); }
  .cell-muted{ color:var(--text-lo); }

  .actions{ display:flex; gap:8px; }
  .btn-edit{
    background:var(--amber-soft); color:#b45309; border:none;
    padding:7px 14px; border-radius:7px; font-size:13.5px; font-weight:600; cursor:pointer;
  }
  .btn-delete{
    background:var(--red-soft); color:var(--red); border:none;
    padding:7px 14px; border-radius:7px; font-size:13.5px; font-weight:600; cursor:pointer;
  }

  @media (max-width: 720px){
    .layout{ flex-direction:column; }
    .sidebar{ width:100%; border-right:none; border-bottom:1px solid var(--border); }
    .main{ padding:24px 20px; }
    .section-head{ flex-direction:column; align-items:flex-start; gap:16px; }
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
        <div class="avatar">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</div>
        <span>{{ auth()->user()->name ?? 'Administrator' }}</span>
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#6b7086" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 9l4-4 4 4M8 15l4 4 4-4"/></svg>
      </div>
    </div>
  </aside>

  <main class="main">
    <h1>Manajemen User</h1>
    <p class="page-desc">Kelola data dosen dan mahasiswa</p>

    <input type="text" class="search-bar" placeholder="Cari nama, email, atau NIM..." value="{{ request('search') }}">

    <div class="tabs">
      <a href="{{ route('admin.users', ['role' => 'dosen']) }}" class="tab {{ (!request('role') || request('role') == 'dosen') ? 'active' : '' }}">
        <span class="emoji">🧑‍🏫</span> Dosen 
        <span class="count">{{ \App\Models\User::where('role', 'dosen')->count() }}</span>
      </a>
      <a href="{{ route('admin.users', ['role' => 'mahasiswa']) }}" class="tab {{ request('role') == 'mahasiswa' ? 'active' : '' }}">
        <span class="emoji">🎓</span> Mahasiswa 
        <span class="count">{{ \App\Models\User::where('role', 'mahasiswa')->count() }}</span>
      </a>
    </div>

    <div class="section-head">
      <div class="section-title-wrap">
        <div class="section-icon">
          <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
        </div>
        <div>
          <div class="section-title">Daftar {{ request('role') == 'mahasiswa' ? 'Mahasiswa' : 'Dosen' }}</div>
          <div class="section-sub">Menampilkan seluruh {{ request('role') == 'mahasiswa' ? 'mahasiswa' : 'dosen' }} yang terdaftar</div>
        </div>
      </div>
      <button class="btn-primary">+ Tambah {{ request('role') == 'mahasiswa' ? 'Mahasiswa' : 'Dosen' }}</button>
    </div>

    <div class="table-card">
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Bergabung</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @php
            $roleFilter = request('role', 'dosen');
            $users = \App\Models\User::where('role', $roleFilter)
                ->when(request('search'), fn($q) => $q->where('name', 'like', '%'.request('search').'%'))
                ->orderBy('created_at', 'desc')
                ->get();
          @endphp

          @forelse($users as $index => $user)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $user->name }}</td>
              <td class="cell-muted">{{ $user->email }}</td>
              <td class="cell-muted">{{ $user->created_at->format('d M Y') }}</td>
              <td>
                <div class="actions">
                  <button class="btn-edit">Edit</button>
                  <form method="POST" action="#" onsubmit="return confirm('Yakin ingin menghapus user ini?')" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" style="text-align:center; padding:40px; color:var(--text-lo);">
                Tidak ada data {{ request('role') == 'mahasiswa' ? 'mahasiswa' : 'dosen' }} yang ditemukan.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </main>

</div>
</body>
</html>