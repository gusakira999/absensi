<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar - Absensi Mahasiswa</title>
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
    --emerald: #10b981;
    --emerald-soft: #e6f8f1;
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
      --emerald-soft: rgba(16, 185, 129, 0.15);
    }
    
    /* Penyesuaian input field di dark mode */
    input[type="text"], input[type="email"], input[type="password"] {
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
    width:100%; max-width:440px; padding:40px 36px 32px;
    box-shadow:0 8px 30px rgba(23,26,35,0.05); text-align:center;
  }
  @media (prefers-color-scheme: dark) { .card { box-shadow: 0 8px 30px rgba(0,0,0,0.3); } }

  .card-icon{
    width:52px; height:52px; border-radius:12px; background:var(--emerald-soft);
    display:flex; align-items:center; justify-content:center; margin:0 auto 20px;
  }

  h1{ font-family:'Space Grotesk', sans-serif; font-size:24px; font-weight:700; margin:0 0 8px; }
  .desc{ color:var(--text-lo); font-size:14.5px; line-height:1.6; margin:0 0 28px; }

  form{ text-align:left; }
  label{ display:block; font-size:13.5px; font-weight:600; color:var(--text-hi); margin-bottom:7px; }
  .field{ margin-bottom:18px; }

  .input-wrap{ position:relative; }

  input[type="text"], input[type="email"], input[type="password"]{
    width:100%; padding:12px 14px; border-radius:9px; border:1px solid var(--border);
    background:#fafafe; font-size:14.5px; color:var(--text-hi); font-family:'Inter', sans-serif;
    transition: all 0.2s;
  }
  .input-wrap input{ padding-right:44px; }
  input:focus{ outline:none; border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-soft); }

  .toggle-eye{
    position:absolute; right:6px; top:50%; transform:translateY(-50%);
    width:32px; height:32px; border:none; background:var(--accent-soft);
    border-radius:7px; display:flex; align-items:center; justify-content:center;
    cursor:pointer; color:var(--accent); padding:0;
  }
  .toggle-eye svg{ width:16px; height:16px; }

  .submit{
    width:100%; padding:13px; border:none; border-radius:9px;
    background:linear-gradient(135deg, var(--accent), #6d28d9); color:#fff;
    font-weight:600; font-size:15px; font-family:'Inter', sans-serif; cursor:pointer;
    box-shadow:0 6px 16px rgba(79,70,229,0.25); margin-top:6px; transition: filter 0.2s;
  }
  .submit:hover{ filter:brightness(1.1); }

  .login-link{ text-align:center; font-size:14px; color:var(--text-lo); margin-top:22px; }
  .login-link a{ color:var(--accent); font-weight:600; text-decoration:none; }
  .login-link a:hover{ text-decoration:underline; }

  /* Style untuk Alert Error Laravel */
  .alert-error {
    background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; 
    padding: 12px; border-radius: 9px; font-size: 14px; margin-bottom: 20px; text-align: left;
  }
  @media (prefers-color-scheme: dark) {
    .alert-error { background: rgba(153, 27, 27, 0.1); border-color: rgba(153, 27, 27, 0.3); color: #fca5a5; }
  }

  a:focus-visible, .submit:focus-visible, .toggle-eye:focus-visible{
    outline:2px solid var(--accent); outline-offset:2px;
  }
</style>
</head>
<body>
<div class="page">

  <div class="brand"><span class="dot"></span>Absensi Mahasiswa</div>

  <div class="card">
    <div class="card-icon">
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    </div>

    <h1>Buat Akun Baru</h1>
    <p class="desc">Lengkapi data di bawah ini untuk membuat akun Absensi Mahasiswa</p>

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

    <!-- Form Register Laravel -->
    <form method="POST" action="{{ route('register') }}">
      @csrf
      
      <div class="field">
        <label for="name">Nama Lengkap</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nama lengkap kamu" required autofocus>
      </div>

      <div class="field">
        <label for="email">Alamat Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required>
      </div>

      <div class="field">
        <label for="password">Password</label>
        <div class="input-wrap">
          <input type="password" id="password" name="password" placeholder="Password" required>
          <button type="button" class="toggle-eye" data-target="password" aria-label="Tampilkan password">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <div class="field">
        <label for="confirm">Konfirmasi Password</label>
        <div class="input-wrap">
          <input type="password" id="confirm" name="password_confirmation" placeholder="Konfirmasi password" required>
          <button type="button" class="toggle-eye" data-target="confirm" aria-label="Tampilkan password">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>

      <button type="submit" class="submit">Buat Akun</button>
    </form>

    <p class="login-link">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
  </div>

</div>

<script>
  document.querySelectorAll('.toggle-eye').forEach(function(btn){
    btn.addEventListener('click', function(){
      var input = document.getElementById(btn.dataset.target);
      if(input.type === 'password'){
        input.type = 'text';
      } else {
        input.type = 'password';
      }
    });
  });
</script>
</body>
</html