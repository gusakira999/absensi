<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Absensi Mahasiswa</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  /* WARNA DEFAULT (LIGHT MODE) */
  :root{
    --bg: #f6f7fb;
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
  }

  /* WARNA KHUSUS DARK MODE (Otomatis mengikuti laptop) */
  @media (prefers-color-scheme: dark) {
    :root {
      --bg: #0a0e13;       /* Background Hitam Pekat */
      --card: #12171e;     /* Card Abu Gelap */
      --border: #22282f;   /* Border Halus */
      --text-hi: #f2f4f5;  /* Teks Putih Terang */
      --text-lo: #9aa4ad;  /* Teks Abu Sedang */
      --accent-soft: rgba(79, 70, 229, 0.15); /* Aksen transparan */
      --amber-soft: rgba(245, 158, 11, 0.15);
      --emerald-soft: rgba(16, 185, 129, 0.15);
    }
    
    /* Penyesuaian khusus elemen di Dark Mode */
    .cta-secondary {
        border-color: var(--border);
        color: var(--text-hi) !important;
    }
    .btn-outline {
        border-color: var(--border);
        color: var(--text-hi) !important;
    }
  }

  *{box-sizing:border-box;}
  html,body{
    margin:0;
    padding:0;
    background:var(--bg);
    color:var(--text-hi);
    font-family:'Inter', sans-serif;
    min-height:100vh;
    transition: background-color 0.3s ease, color 0.3s ease; /* Transisi halus saat ganti mode */
  }
  .page{
    max-width:1040px;
    margin:0 auto;
    padding:32px 24px 60px;
  }
  nav{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:72px;
  }
  .logo{
    font-family:'Space Grotesk', sans-serif;
    font-weight:600;
    font-size:17px;
  }
  .nav-actions{
    display:flex;
    gap:10px;
    align-items:center;
    font-size:14.5px;
  }
  .nav-actions a{
    color:var(--text-lo);
    text-decoration:none;
    padding:8px 16px;
    border-radius:7px;
  }
  .nav-actions a:hover{ color:var(--text-hi); }
  .btn-outline{
    border:1px solid var(--border);
    color:var(--text-hi) !important;
    font-weight:500;
  }

  .hero{
    text-align:center;
    max-width:560px;
    margin:0 auto 56px;
    position:relative;
    padding:48px 24px 8px;
  }
  .hero::before{
    content:"";
    position:absolute;
    top:-40px; left:50%;
    transform:translateX(-50%);
    width:560px; height:340px;
    background:
      radial-gradient(circle at 30% 20%, rgba(79,70,229,0.14), transparent 60%),
      radial-gradient(circle at 75% 30%, rgba(16,185,129,0.12), transparent 55%),
      radial-gradient(circle at 55% 70%, rgba(245,158,11,0.10), transparent 55%);
    z-index:-1;
    filter:blur(6px);
  }
  .eyebrow{
    display:inline-block;
    font-size:13px;
    font-weight:600;
    color:var(--accent);
    background:var(--accent-soft);
    padding:5px 12px;
    border-radius:100px;
    margin-bottom:20px;
  }
  h1{
    font-family:'Space Grotesk', sans-serif;
    font-size:38px;
    font-weight:700;
    line-height:1.2;
    margin:0 0 16px;
  }
  .desc{
    color:var(--text-lo);
    font-size:16px;
    line-height:1.65;
    margin:0 0 32px;
  }
  .cta-row{
    display:flex;
    gap:12px;
    justify-content:center;
  }
  .cta{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:linear-gradient(135deg, var(--accent), #6d28d9);
    color:#fff;
    font-weight:600;
    font-size:15px;
    padding:12px 22px;
    border-radius:9px;
    text-decoration:none;
    box-shadow:0 6px 16px rgba(79,70,229,0.25);
  }
  .cta-secondary{
    display:inline-flex;
    align-items:center;
    background:transparent;
    color:var(--text-hi);
    font-weight:500;
    font-size:15px;
    padding:12px 22px;
    border-radius:9px;
    text-decoration:none;
    border:1px solid var(--border);
  }

  .cards{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:16px;
  }
  .card{
    background:var(--card);
    border:1px solid var(--border);
    border-radius:12px;
    padding:26px 22px;
  }
  .card-icon{
    width:36px;height:36px;
    border-radius:8px;
    display:flex;align-items:center;justify-content:center;
    margin-bottom:16px;
  }
  .card-icon.indigo{ background:var(--accent-soft); }
  .card-icon.emerald{ background:var(--emerald-soft); }
  .card-icon.amber{ background:var(--amber-soft); }
  .card h3{
    font-family:'Space Grotesk', sans-serif;
    font-size:16px;
    margin:0 0 6px;
  }
  .card p{
    font-size:14px;
    color:var(--text-lo);
    line-height:1.6;
    margin:0;
  }

  footer{
    text-align:center;
    color:var(--text-lo);
    font-size:13px;
    margin-top:64px;
  }

  @media (max-width: 700px){
    .cards{ grid-template-columns:1fr; }
    h1{ font-size:28px; }
    .cta-row{ flex-direction:column; }
  }

  a:focus-visible, .cta:focus-visible{
    outline:2px solid var(--accent);
    outline-offset:2px;
  }
</style>
</head>
<body>
<div class="page">

  <nav>
    <div class="logo">Absensi Mahasiswa</div>
    <div class="nav-actions">
      <!-- BAGIAN NAVBAR YANG SUDAH DIPERBAIKI -->
      @if (Route::has('login'))
          @auth
              <a href="{{ url('/dashboard') }}">Dashboard</a>
          @else
              <a href="{{ route('login') }}">Masuk</a>
              @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="btn-outline">Daftar</a>
              @endif
          @endauth
      @endif
    </div>
  </nav>

  <div class="hero">
    <span class="eyebrow">Sistem Kehadiran Kampus</span>
    <h1>Selamat datang di Absensi Mahasiswa</h1>
    <p class="desc">
      Catat kehadiran kuliah dengan mudah dan cepat. Semua data tersimpan rapi,
      bisa diakses kapan saja oleh mahasiswa dan dosen.
    </p>
    <div class="cta-row">
      <!-- TOMBOL CTA YANG SUDAH DIPERBAIKI -->
      <a href="{{ route('login') }}" class="cta">Login Sekarang</a>
      <a href="#" class="cta-secondary">Lihat Panduan</a>
    </div>
  </div>

  <div class="cards">
    <div class="card">
      <div class="card-icon indigo">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
      </div>
      <h3>Absensi Cepat</h3>
      <p>Cukup satu klik untuk mencatat kehadiran di setiap kelas.</p>
    </div>
    <div class="card">
      <div class="card-icon emerald">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 14l4-4 3 3 5-6"/></svg>
      </div>
      <h3>Rekap Otomatis</h3>
      <p>Lihat rekap kehadiran per mahasiswa maupun per kelas dengan mudah.</p>
    </div>
    <div class="card">
      <div class="card-icon amber">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#f59e0b" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
      </div>
      <h3>Jadwal Terintegrasi</h3>
      <p>Jadwal kuliah dan absensi tergabung dalam satu tampilan.</p>
    </div>
  </div>

  <footer>Absensi Mahasiswa &middot; Universitas Anda &middot; {{ date('Y') }}</footer>
</div>
</body>
</html>