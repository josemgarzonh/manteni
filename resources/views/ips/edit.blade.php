@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Editar IPS: {{ $ip->nombre_prestador }}</h2>
    <div class="pd-20">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('ips.update', $ip->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nombre del Prestador</label>
                        <input class="form-control" type="text" name="nombre_prestador" value="{{ $ip->nombre_prestador }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>NIT</label>
                        <input class="form-control" type="text" name="nit" value="{{ $ip->nit }}" required>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Dirección</label>
                        <input class="form-control" type="text" name="direccion" value="{{ $ip->direccion }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input class="form-control" type="text" name="telefono" value="{{ $ip->telefono }}">
                    </div>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" value="{{ $ip->email }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Razón Social</label>
                        <input class="form-control" type="text" name="razon_social" value="{{ $ip->razon_social }}">
                    </div>
                </div>
            </div>
            {{-- Puedes añadir aquí los otros campos del modelo Ips si es necesario --}}

            <div class="text-right">
                <a href="{{ route('ips.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar IPS</button>
            </div>
        </form>
    </div>
</div>
@endsection