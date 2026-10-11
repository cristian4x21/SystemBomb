@extends('layouts.app')
@section('title','Panel principal')@section('crumb','Panel principal')
@section('content')
<div class="page-heading"><div><span class="eyebrow">CENTRO DE CONTROL</span><h1>Panel de operaciones</h1><p>Resumen de los recursos registrados en la demostración.</p></div>
<a class="btn btn-primary" href="{{ route('resources.index') }}">Ver inventario →</a></div>
<div class="stat-grid">
  <article class="stat-card"><div class="stat-icon blue">▤</div><span>Recursos activos</span><strong>{{ $resourcesCount }}</strong><small>Registros de inventario</small></article>
  <article class="stat-card"><div class="stat-icon amber">⇄</div><span>Préstamos activos</span><strong>{{ $loanCount }}</strong><small>Sin fecha de devolución</small></article>
  <article class="stat-card"><div class="stat-icon rose">!</div><span>Alertas de stock</span><strong>{{ $lowStock->count() }}</strong><small>En o debajo del mínimo</small></article>
  <article class="stat-card"><div class="stat-icon green">🚒</div><span>Vehículos</span><strong>{{ $vehicleCount }}</strong><small>Unidades registradas</small></article>
</div>
<div class="two-cols">
<section class="panel"><div class="panel-header"><div><h2>Atención requerida</h2><p>Indicadores de inventario</p></div><span class="label-pill warning">{{ $lowStock->count()+$expiring->count() }} avisos</span></div>
<div class="panel-content">
  @forelse($lowStock as $item)<div class="alert-row"><span class="alert-dot">!</span><div><strong>Stock bajo: {{ $item->name }}</strong><small>Disponibles: {{ $item->available }} · Mínimo: {{ $item->min_stock }}</small></div></div>@empty <p class="empty">Sin recursos por debajo del umbral.</p>@endforelse
  @foreach($expiring as $item)<div class="alert-row"><span class="alert-dot orange">◷</span><div><strong>Próximo vencimiento: {{ $item->name }}</strong><small>{{ $item->expires_at->format('d/m/Y') }}</small></div></div>@endforeach
</div></section>
<section class="panel"><div class="panel-header"><div><h2>Movimientos recientes</h2><p>Entregas y devoluciones</p></div><a class="text-link" href="{{ route('assignments.index') }}">Ver todos →</a></div>
<div class="panel-content">@forelse($recent as $a)<div class="movement"><div class="movement-symbol">⇄</div><div><strong>{{ $a->resource?->name }}</strong><small>{{ $a->recipient }} · {{ $a->assigned_at->format('d/m/Y H:i') }}</small></div><span class="status {{ $a->returned_at?'ok':'pending' }}">{{ $a->returned_at?'Devuelto':'Prestado' }}</span></div>@empty<p class="empty">No hay movimientos registrados.</p>@endforelse</div></section>
</div>
@endsection
