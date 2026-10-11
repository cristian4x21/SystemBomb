<!doctype html><html lang="es"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Acceso · SystemBomb</title><link rel="stylesheet" href="{{ asset('css/systembomb.css') }}">
</head><body class="login-page"><div class="login-layout">
<section class="login-info"><div class="login-brand"><span class="brand-symbol">✦</span><b>SYSTEM<span class="accent">BOMB</span></b></div>
<div class="login-intro"><span class="eyebrow light">PLATAFORMA DE APOYO LOGÍSTICO</span><h1>Equipos organizados.<br><em>Decisiones mejor informadas.</em></h1><p>Prototipo académico para gestionar inventarios, asignaciones y mantenimiento de recursos.</p></div>
<div class="login-disclaimer">✚ Propuesta educativa · Compañía B-233 como caso de estudio · Sin datos operativos reales</div></section>
<section class="login-box"><div class="login-card"><div class="tag">ACCESO SEGURO</div><h2>Bienvenido de nuevo</h2><p>Ingresa tus credenciales para continuar.</p>
@if($errors->any())<div class="notice danger" role="alert">{{ $errors->first() }}</div>@endif
<form method="post" action="{{ route('login.submit') }}">@csrf
<label>Correo electrónico<input name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="usuario@ejemplo.com"></label>
<label>Contraseña<input type="password" name="password" required autocomplete="current-password" placeholder="••••••••"></label>
<button class="btn btn-primary wide" type="submit">Iniciar sesión →</button>
</form><div class="demo-help">Cuenta de prueba: <strong>admin@systembomb.test</strong><br>Contraseña de prueba: <strong>Demo2026!</strong><br><small>Solo disponible después de ejecutar el seeder. Cambiar en producción.</small></div></div></section>
</div></body></html>
