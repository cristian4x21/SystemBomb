@extends('layouts.app')
@section('title',$vehicle->exists?'Editar unidad':'Nueva unidad')@section('crumb','Unidades / Formulario')
@section('content')<div class="page-heading"><div><span class="eyebrow">FLOTA VEHICULAR</span><h1>{{ $vehicle->exists?'Actualizar unidad':'Registrar unidad' }}</h1><p>Solo datos de demostración o institucionalmente autorizados.</p></div><a class="btn btn-neutral" href="{{ route('vehicles.index') }}">← Volver</a></div>
<form class="panel form-panel" action="{{ $vehicle->exists?route('vehicles.update',$vehicle):route('vehicles.store') }}" method="post">@csrf @if($vehicle->exists)@method('PUT')@endif<div class="form-grid">
<label>Código *<input name="code" required value="{{ old('code',$vehicle->code) }}" placeholder="UNI-01"></label>
<label>Tipo *<input name="type" required value="{{ old('type',$vehicle->type) }}" placeholder="Autobomba"></label>
<label>Placa (opcional)<input name="plate" value="{{ old('plate',$vehicle->plate) }}"></label>
<label>Estado *<select name="status">@foreach(['operativo','mantenimiento','inactivo'] as $s)<option @selected(old('status',$vehicle->status??'operativo')===$s) value="{{ $s }}">{{ ucfirst($s) }}</option>@endforeach</select></label>
<label>Kilometraje *<input type="number" min="0" name="mileage" value="{{ old('mileage',$vehicle->mileage??0) }}" required></label>
<label>Próximo mantenimiento<input type="date" name="next_maintenance_at" value="{{ old('next_maintenance_at',$vehicle->next_maintenance_at?->format('Y-m-d')) }}"></label>
<label class="full">Observaciones<textarea name="notes" rows="4">{{ old('notes',$vehicle->notes) }}</textarea></label></div><div class="form-actions"><a class="btn btn-neutral" href="{{ route('vehicles.index') }}">Cancelar</a><button class="btn btn-primary">Guardar unidad →</button></div></form>@endsection
