
// resources/views/profile/edit.blade.php

@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <!-- Tarjeta de información de perfil -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($user->firma_url)
                            <img src="{{ Storage::url($user->firma_url) }}" 
                                 class="rounded-circle mb-3" 
                                 width="150" 
                                 height="150"
                                 style="object-fit: cover;"
                                 id="profileImage">
                        @else
                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 150px; height: 150px;">
                                <i class="fas fa-user fa-3x text-white"></i>
                            </div>
                        @endif
                    </div>
                    
                    <h5>{{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->cargo ?: 'Sin cargo asignado' }}</p>
                    
                    <div class="text-start">
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Cédula:</strong> {{ $user->cedula ?: 'No registrada' }}</p>
                        <p><strong>Celular:</strong> {{ $user->celular ?: 'No registrado' }}</p>
                        <p><strong>Rol:</strong> {{ $user->rol->nombre_rol }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Formulario de actualización de perfil -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Información Personal</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Nombre Completo *</label>
                                    <input type="text" name="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email *</label>
                                    <input type="email" name="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Cédula</label>
                                    <input type="text" name="cedula" 
                                           class="form-control @error('cedula') is-invalid @enderror" 
                                           value="{{ old('cedula', $user->cedula) }}">
                                    @error('cedula')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Celular</label>
                                    <input type="text" name="celular" 
                                           class="form-control @error('celular') is-invalid @enderror" 
                                           value="{{ old('celular', $user->celular) }}">
                                    @error('celular')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Cargo</label>
                            <input type="text" name="cargo" 
                                   class="form-control @error('cargo') is-invalid @enderror" 
                                   value="{{ old('cargo', $user->cargo) }}">
                            @error('cargo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Firma Digital (Imagen)</label>
                            <input type="file" name="firma" 
                                   class="form-control @error('firma') is-invalid @enderror" 
                                   accept="image/*">
                            @error('firma')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($user->firma_url)
                                <small class="form-text text-muted">
                                    Firma actual: 
                                    <a href="{{ Storage::url($user->firma_url) }}" target="_blank">Ver firma</a>
                                </small>
                            @endif
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Cambio de contraseña -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="card-title">Cambiar Contraseña</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Contraseña Actual *</label>
                            <input type="password" name="current_password" 
                                   class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nueva Contraseña *</label>
                            <input type="password" name="password" 
                                   class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Confirmar Nueva Contraseña *</label>
                            <input type="password" name="password_confirmation" 
                                   class="form-control" required>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Cambiar Contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection