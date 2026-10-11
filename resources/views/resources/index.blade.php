@extends('layouts.app')
@section('title','Inventario')@section('crumb','Inventario')
@section('content')<div class="page-heading"><div><span class="eyebrow">LOGÍSTICA</span><h1>Inventario de recursos</h1><p>Consulta, actualiza y organiza los equipos y consumibles.</p></div>
@if(auth()->user()->canManage())<a class="btn btn-primary" href="{{ route('resources.create') }}">+ Nuevo recurso</a>@endif</div>
<section class="panel"><div class="table-tools"><form class="search-box" method="get" action="{{ route('resources.index') }}"><input aria-label="Buscar recursos" name="q" value="{{ $q }}" placeholder="Buscar por nombre, categoría o código"><button class="btn btn-neutral">Buscar</button></form><span class="muted">{{ $resources->total() }} registros</span></div>
<div class="table-scroll"><table><thead><tr><th>CÓDIGO</th><th>RECURSO</th><th>CATEGORÍA</th><th>UBICACIÓN</th><th>DISPONIBLE</th><th>ESTADO</th><th></th></tr></thead><tbody>
@forelse($resources as $r)<tr><td><code>{{ $r->code }}</code></td><td><b>{{ $r->name }}</b><small class="subtext">Mínimo: {{ $r->min_stock }}</small></td><td>{{ $r->category }}</td><td>{{ $r->location }}</td><td><b>{{ $r->available }}</b> / {{ $r->quantity }}</td><td><span class="status {{ $r->status==='disponible'?'ok':($r->status==='mantenimiento'?'pending':'off') }}">{{ ucfirst($r->status) }}</span></td><td class="right">
@if(auth()->user()->canManage())<a class="text-link" href="{{ route('resources.edit',$r) }}">Editar</a>@endif
@if(auth()->user()->role==='admin' && $r->status!=='baja')<form class="inline-form" method="post" action="{{ route('resources.destroy',$r) }}" data-confirm="¿Dar de baja este recurso?">@csrf @method('DELETE')<button class="link-danger" type="submit">Baja</button></form>@endif
</td></tr>@empty<tr><td colspan="7" class="empty">Sin resultados.</td></tr>@endforelse</tbody></table></div>
<div class="pagination">{{ $resources->links() }}</div></section>@endsection
