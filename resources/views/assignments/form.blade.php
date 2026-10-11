@extends('layouts.app')
@section('title','Nueva asignación')@section('crumb','Asignaciones / Nueva')
@section('content')<div class="page-heading"><div><span class="eyebrow">CONTROL DE EQUIPAMIENTO</span><h1>Registrar asignación</h1><p>El sistema verifica estado y disponibilidad antes de prestar.</p></div><a class="btn btn-neutral" href="{{ route('assignments.index') }}">← Volver</a></div>
<form class="panel form-panel" method="post" action="{{ route('assignments.store') }}">@csrf<div class="form-grid">
<label class="full">Recurso *<select name="resource_id" required><option value="">Selecciona un recurso</option>@foreach($resources as $r)<option value="{{ $r->id }}" @selected(old('resource_id')==$r->id)>{{ $r->name }} · {{ $r->code }} ({{ $r->available }} disponibles)</option>@endforeach</select></label>
<label>Nombre o código del receptor *<input required name="recipient" maxlength="150" value="{{ old('recipient') }}" placeholder="Receptor autorizado (dato de prueba)"></label>
<label>Cantidad *<input type="number" name="quantity" min="1" value="{{ old('quantity',1) }}" required></label>
<label class="full">Observaciones<textarea name="notes" rows="4" maxlength="1000">{{ old('notes') }}</textarea></label></div><div class="form-actions"><a class="btn btn-neutral" href="{{ route('assignments.index') }}">Cancelar</a><button class="btn btn-primary">Confirmar asignación →</button></div></form>@endsection
