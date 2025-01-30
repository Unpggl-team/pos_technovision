@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Generar Licencia</h2>
    <form action="{{ route('licenses.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nombre del usuario</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="creation_date">Fecha de creación</label>
            <input type="date" name="creation_date" id="creation_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="expiration_date">Fecha de expiración</label>
            <input type="date" name="expiration_date" id="expiration_date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Generar Licencia</button>
    </form>
</div>
@endsection
