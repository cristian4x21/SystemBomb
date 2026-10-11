@extends('layouts.app')
@section('title',$resource->exists?'Editar recurso':'Nuevo recurso')@section('crumb','Inventario / Formulario')
@section('content')<div class="page-heading"><div><span class="eyebrow">GESTIÓN DE INVENTARIO</span><h1>{{ $resource->exists?'Editar recurso':'Registrar recurso' }}</h1><p>Completa los campos del inventario de prueba.</p></div><a class="btn btn-neutral" href="{{ route('resources.index') }}">← Volver</a></div>
<form class="panel form-panel" action="{{ $resource->exists?route('resources.update',$resource):route('resources.store') }}" method="post">@csrf @if($resource->exists)@method('PUT')@endif
<div class="form-grid">
<label>Código único *<input required maxlength="30" name="code" value="{{ old('code',$resource->code) }}" placeholder="EPP-001"></label>
<label>Nombre del recurso *<input required maxlength="150" name="name" value="{{ old('name',$resource->name) }}" placeholder="Casco de protección"></label>
<label>Categoría *<select name="category" required>@foreach(['EPP','Herramientas','Mangueras','Insumos médicos','Otros'] as $c)<option @selected(old('category',$resource->category)===$c)>{{ $c }}</option>@endforeach</select></label>
<label>Ubicación *<input required name="location" value="{{ old('location',$resource->location) }}" placeholder="Almacén A"></label>
<label>Estado *<select name="status" required>@foreach(['disponible','mantenimiento','baja'] as $status)<option value="{{ $status }}" @selected(old('status',$resource->status??'disponible')===$status)>{{ ucfirst($status) }}</option>@endforeach</select></label>
<label>Unidades registradas *<input type="number" min="0" name="quantity" value="{{ old('quantity',$resource->quantity??0) }}" required></label>
<label>Stock mínimo *<input type="number" min="0" name="min_stock" value="{{ old('min_stock',$resource->min_stock??0) }}" required></label>
<label>Fecha de vencimiento (si aplica)<input type="date" name="expires_at" value="{{ old('expires_at',$resource->expires_at?->format('Y-m-d')) }}"></label>
<label class="full">Observaciones<textarea name="notes" rows="4" maxlength="1000" placeholder="Información general, sin datos operativos sensibles">{{ old('notes',$resource->notes) }}</textarea></label>
</div><div class="form-actions"><a class="btn btn-neutral" href="{{ route('resources.index') }}">Cancelar</a><button class="btn btn-primary" type="submit">Guardar recurso →</button></div></form>@endsection
