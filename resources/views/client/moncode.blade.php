@extends('client.main')
@section('content')
@php
$data = Session::get("currentuser");
@endphp
    <!-- Content Start -->
    <div class="content-fluid">
        <!-- Form Start -->
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4">
                <div class="col-12">
                    <div class="bg-secondary rounded h-100 p-4">
                        <h6 class="mb-4">Mes Informations</h6>
                        <form method="post">
                            @csrf
                        <div class="row mb-3">
                            <label for="floatingInput" class="col-sm-2 col-form-label">Nouveau Mot de Passe</label>
                             <div class="col-sm-10">
                            <input class="form-control" type="password" name="password" required>
                        @if ($errors->has('password'))
                            <p class="help-block text-danger">{{ $errors->first('password') }}</p>
                        @endif
                        </div>
                        </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Confirmation</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password_confirmation"
                                         required>
                                    @if ($errors->has('password_confirmation'))
                                        <p class="text-danger">{{ $errors->first('password_confirmation') }}</p>
                                    @endif
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-dark">Modifier</button>
                        </form>
                    </div>
                </div>
                <div class="col-12">
                    <a href="{{ route('clientportal') }}">
                        <button type="button" class="btn btn-link rounded-pill m-2">Annuler</button>
                    </a>
                </div>
            </div>
        </div>
        <!-- Form End -->
    </div>
    <!-- Content End -->
    </div>
@endsection
