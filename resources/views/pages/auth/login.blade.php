<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Masuk - Absensi Mahasiswa</title>
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
    --emerald: #10b981;
  }

  /* WARNA KHUSUS DARK MODE */
  @media (prefers-color-scheme: dark) {
    :root {
      --bg: #0a0e13;
      --card: #12171e;
      --border: #22282f;
      --text-hi: #f2f4f5;
      --text-lo: #9aa4ad;
      --accent-soft: rgba(79, 70, 229, 0.15);
    }
    
    /* Penyesuaian input field di dark mode */
    input[type="email"], input[type="password"] {
        background: #1a202c !important;
        border-color: #2d3748 !important;
        color: var(--text-hi) !important;
    }
    input::placeholder { color: #4a5568 !important; }
  }

  *{box-sizing:border-box;}
  html,body{
    margin:0; padding:0;
    background:var(--bg); color:var(--text-hi);
    font-family:'Inter', sans-serif; min-height:100vh;
    transition: background-color 0.3s ease, color 0.3s ease;
  }
  .page{
    min-height:100vh; display:flex; flex-direction:column; align-items:center;
    padding:56px 20px 60px; position:relative;
  }
  .page::before{
    content:""; position:absolute; top:-60px; left:50%; transform:translateX(-50%);
    width:600px; height:360px;
    background: radial-gradient(circle at 30% 20%, rgba(79,70,229,0.14), transparent 60%),
                radial-gradient(circle at 75% 30%, rgba(16,185,129,0.12), transparent 55%),
                radial-gradient(circle at 55% 70%, rgba(245,158,11,0.10), transparent 55%);
    z-index:0; filter:blur(6px); pointer-events:none;
  }

  .brand{
    display:flex; align-items:center; gap:9px;
    font-family:'Space Grotesk', sans-serif; font-weight:600; font-size:17px;
    margin-bottom:40px; position:relative; z-index:1;
  }
  .brand .dot{ width:9px; height:9px; border-radius:2px; background:var(--accent); }

  .card{
    position:relative; z-index:1;
    background:var(--card); border:1px solid var(--border); border-radius:16px;
    width:100%; max-width:420px; padding:40px 36px 32px;
    box-shadow:0 8px 30px rgba(23,26,35,0.05); text-align:center;
  }
  @media (prefers-color-scheme: dark) { .card { box-shadow: 0 8px 30px rgba(0,0,0,0.3); } }

  .card-icon{
    width:52px; height:52px; border-radius:12px; background:var(--accent-soft);
    display:flex; align-items:center; justify-content:center; margin:0 auto 20px;
  }

  h1{ font-family:'Space Grotesk', sans-serif; font-size:26px; font-weight:700; margin:0 0 6px; }
  .subtitle{ font-family:'Space Grotesk', sans-serif; font-size:15px; font-weight:500; color:var(--accent); margin:0 0 12px; }
  .wave{ font-size:20px; margin-bottom:14px; }
  .desc{ color:var(--text-lo); font-size:14.5px; line-height:1.6; margin:0 0 28px; }

  form{ text-align:left; }
  label{ display:block; font-size:13.5px; font-weight:600; color:var(--text-hi); margin-bottom:7px; }
  .field{ margin-bottom:18px; }
  .field-row{ display:flex; justify-content:space-between; align-items:center; margin-bottom:7px; }
  .field-row label{ margin-bottom:0; }
  .field-row a{ font-size:13px; color:var(--accent); text-decoration:none; font-weight:500; }
  .field-row a:hover{ text-decoration:underline; }

  input[type="email"], input[type="password"]{
    width:100%; padding:12px 14px; border-radius:9px; border:1px solid var(--border);
    background:#fafafe; font-size:14.5px; color:var(--text-hi); font-family:'Inter', sans-serif;
    transition: all 0.2s;
  }
  input:focus{ outline:none; border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-soft); }

  .remember{ display:flex; align-items:center; gap:8px; font-size:14px; color:var(--text-lo); margin:4px 0 22px; cursor:pointer; }
  .remember input{ width:16px; height:16px; accent-color:var(--accent); cursor:pointer; }

  .submit{
    width:100%; padding:13px; border:none; border-radius:9px;
    background:linear-gradient(135deg, var(--accent), #6d28d9); color:#fff;
    font-weight:600; font-size:15px; font-family:'Inter', sans-serif; cursor:pointer;
    box-shadow:0 6px 16px rgba(79,70,229,0.25); transition: filter 0.2s;
  }
  .submit:hover{ filter:brightness(1.1); }

  .divider{ display:flex; align-items:center; gap:14px; color:var(--text-lo); font-size:13px; margin:26px 0 20px; }
  .divider::before, .divider::after{ content:""; flex:1; height:1px; background:var(--border); }

  .register-link{ text-align:center; font-size:14px; color:var(--text-lo); }
  .register-link a{ color:var(--accent); font-weight:600; text-decoration:none; }
  .register-link a:hover{ text-decoration:underline; }

  /* Style untuk Alert Error/Success Laravel */
  .alert-error {
    background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; 
    padding: 12px; border-radius: 9px; font-size: 14px; margin-bottom: 20px; text-align: left;
  }
  .alert-success {
    background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; 
    padding: 12px; border-radius: 9px; font-size: 14px; margin-bottom: 20px; text-align: left;
  }
  @media (prefers-color-scheme: dark) {
    .alert-error { background: rgba(153, 27, 27, 0.1); border-color: rgba(153, 27, 27, 0.3); color: #fca5a5; }
    .alert-success { background: rgba(22, 101, 52, 0.1); border-color: rgba(22, 101, 52, 0.3); color: #86efac; }
  }
</style>
</head>
<body>
<div class="page">

  <div class="brand"><span class="dot"></span>Absensi Mahasiswa</div>

  <div class="card">
    <div class="card-icon">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4f46e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
    </div>

    <h1>Selamat Datang</h1>
    <p class="subtitle">di Absensi Mahasiswa</p>
    <div class="wave"></div>
    <p class="desc">Masuk untuk mencatat kehadiran, memeriksa jadwal kuliah, dan memantau rekap absensimu.</p>

    <!-- Menampilkan Error Validasi -->
    @if ($errors->any())
        <div class="alert-error">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Menampilkan Status Sukses (misal: link reset password terkirim) -->
    @if (session('status'))
        <div class="alert-success">{{ session('status') }}</div>
    @endif

    <!-- Form Login Laravel -->
    <form method="POST" action="{{ route('login') }}">
      @csrf
      
      <div class="field">
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus>
      </div>

      <div class="field">
        <div class="field-row">
          <label for="password">Password</label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Lupa password?</a>
          @endif
        </div>
        <input type="password" id="password" name="password" placeholder="••••••••" required>
      </div>

      <label class="remember">
        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
        Ingat saya
      </label>

      <button type="submit" class="submit">Masuk</button>
    </form>

    <div class="divider">Atau</div>

    <p class="register-link">Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
  </div>

</div>
</body>
</html>