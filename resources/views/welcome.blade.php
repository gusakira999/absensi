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
  /* WARNA DEFAULT (LIGHT MODE - TEMA HIJAU TUA) */
  :root{
    --bg: #f8faf9;        /* Putih kehijauan sangat muda */
    --card: #ffffff;      /* Putih bersih */
    --border: #e2e8e4;    /* Hijau abu-abu muda */
    --text-hi: #0f1c15;   /* Hijau hitam pekat */
    --text-lo: #5c6b63;   /* Hijau abu-abu sedang */
    
    /* Aksen Utama: Hijau Hutan Gelap */
    --accent: #1a4d2e;    
    --accent-soft: #e6f0ea; 
    
    /* Warna pendukung disesuaikan ke tone hijau */
    --amber: #ca8a04;     /* Emas tua */
    --amber-soft: #fefce8;
    --emerald: #059669;   /* Emerald gelap */
    --emerald-soft: #ecfdf5;
  }

  /* WARNA KHUSUS DARK MODE (Otomatis mengikuti laptop) */
  @media (prefers-color-scheme: dark) {
    :root {
      --bg: #050a07;       /* Hitam kehijauan sangat gelap */
      --card: #0a140f;     /* Card hijau hitam */
      --border: #1c2e24;   /* Border hijau gelap */
      --text-hi: #e8f0eb;  /* Putih kehijauan terang */
      --text-lo: #8a9b91;  /* Abu kehijauan */
      
      /* Aksen di dark mode lebih cerah agar kontras */
      --accent: #4ade80;   
      --accent-soft: rgba(74, 222, 128, 0.1); 
      
      --amber-soft: rgba(202, 138, 4, 0.1);
      --emerald-soft: rgba(5, 150, 105, 0.1);
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
    transition: background-color 0.3s ease, color 0.3s ease;
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
    color: var(--accent); /* Logo ikut warna aksen hijau */
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
  /* GLOW EFFECT DIUBAH JADI HIJAU TUA & HITAM */
  .hero::before{
    content:"";
    position:absolute;
    top:-40px; left:50%;
    transform:translateX(-50%);
    width:560px; height:340px;
    background:
      radial-gradient(circle at 30% 20%, rgba(26, 77, 46, 0.2), transparent 60%),  /* Hijau tua */
      radial-gradient(circle at 75% 30%, rgba(0, 0, 0, 0.15), transparent 55%),    /* Hitam */
      radial-gradient(circle at 55% 70%, rgba(5, 150, 105, 0.15), transparent 55%); /* Emerald */
    z-index:-1;
    filter:blur(8px);
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
  /* GRADASI TOMBOL UTAMA: HIJAU TUA KE HITAM */
  .cta{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background: linear-gradient(135deg, #1a4d2e 0%, #000000 100%);
    color:#fff;
    font-weight:600;
    font-size:15px;
    padding:12px 22px;
    border-radius:9px;
    text-decoration:none;
    box-shadow:0 6px 16px rgba(26, 77, 46, 0.3);
  }
  .cta:hover {
      opacity: 0.9;
      transform: translateY(-1px);
      transition: all 0.2s ease;
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
  /* Warna icon disesuaikan dengan tema hijau */
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
      <a href="{{ route('login') }}" class="cta">Login Sekarang</a>
    </div>
  </div>

  <div class="cards">
    <div class="card">
      <div class="card-icon indigo">
        <!-- Icon stroke diganti jadi hijau tua -->
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#1a4d2e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
      </div>
      <h3>Absensi Cepat</h3>
      <p>Cukup satu klik untuk mencatat kehadiran di setiap kelas.</p>
    </div>
    <div class="card">
      <div class="card-icon emerald">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="M7 14l4-4 3 3 5-6"/></svg>
      </div>
      <h3>Rekap Otomatis</h3>
      <p>Lihat rekap kehadiran per mahasiswa maupun per kelas dengan mudah.</p>
    </div>
    <div class="card">
      <div class="card-icon amber">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ca8a04" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
      </div>
      <h3>Jadwal Terintegrasi</h3>
      <p>Jadwal kuliah dan absensi tergabung dalam satu tampilan.</p>
    </div>
  </div>

  <footer>Absensi Mahasiswa &middot; Universitas From Temu &middot; {{ date('Y') }}</footer>
</div>
</body>
</html>