<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="description" content="SystemBomb - Inventario académico de recursos de emergencias">
  <title>@yield('title','Panel') · SystemBomb</title>
  <link rel="stylesheet" href="{{ asset('css/systembomb.css') }}">
  <script defer src="{{ asset('js/systembomb.js') }}"></script>
</head>
<body>
<div class="shell">
  <aside class="sidebar" id="sidebar" aria-label="Menú principal">
    <a class="brand" href="{{ route('dashboard') }}"><span class="brand-symbol">✦</span><span><strong>SYSTEM<span class="accent">BOMB</span></strong><small>GESTIÓN DE RECURSOS</small></span></a>
    <div class="station"><span class="station-icon">🚒</span><div><strong>B-233 · DEMO</strong><small>Propuesta académica · Arequipa</small></div></div>
    <div class="nav-caption">PRINCIPAL</div>
    <nav class="nav">
      <a class="nav-link {{ request()->routeIs('dashboard')?'active':'' }}" href="{{ route('dashboard') }}">▦ <span>Panel principal</span></a>
      <a class="nav-link {{ request()->routeIs('resources.*')?'active':'' }}" href="{{ route('resources.index') }}">▤ <span>Inventario</span></a>
      <a class="nav-link {{ request()->routeIs('assignments.*')?'active':'' }}" href="{{ route('assignments.index') }}">⇄ <span>Asignaciones</span></a>
      <a class="nav-link {{ request()->routeIs('vehicles.*')?'active':'' }}" href="{{ route('vehicles.index') }}">🚒 <span>Unidades</span></a>
      @if(auth()->user()->role==='admin')<a class="nav-link {{ request()->routeIs('audits.*')?'active':'' }}" href="{{ route('audits.index') }}">◷ <span>Auditoría</span></a>@endif
    </nav>
    <div class="sidebar-footer"><small>PROTOTIPO ACADÉMICO · 2026</small><p>No conectado a información operativa real</p></div>
  </aside>
  <div class="workspace">
    <header class="topbar">
      <button class="mobile-toggle" id="menu-toggle" type="button" aria-label="Abrir menú" aria-expanded="false">☰</button>
      <div class="crumb">SystemBomb <span> / </span> @yield('crumb','Panel')</div>
      <div class="top-actions"><span class="user-pill">{{ auth()->user()->name }} <em>{{ auth()->user()->role }}</em></span>
        <form action="{{ route('logout') }}" method="post">@csrf <button class="exit-btn" type="submit">Salir ↗</button></form></div>
    </header>
    <main class="main" id="main-content">
      @if(session('success'))<div class="notice success" role="status">✓ {{ session('success') }}</div>@endif
      @if($errors->any())<div class="notice danger" role="alert"><strong>Revisa los datos:</strong><ul>@foreach($errors->all() as $message)<li>{{ $message }}</li>@endforeach</ul></div>@endif
      @yield('content')
      <footer class="footnote">SystemBomb · Demostración educativa · Datos ficticios · Universidad Continental</footer>
    </main>
  </div>
</div>
</body></html>
