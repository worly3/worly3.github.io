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
                            <label for="floatingInput" class="col-sm-2 col-form-label">Votre Prénom</label>
                             <div class="col-sm-10">
                            <input class="form-control" type="text" name="prenom" value="{{ $data->prenom }}" required>
                        @if ($errors->has('prenom'))
                            <p class="help-block text-danger">{{ $errors->first('prenom') }}</p>
                        @endif
                        </div>
                        </div>
                            <div class="row mb-3">
                                <label for="inputPassword3" class="col-sm-2 col-form-label">Nom</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="username"
                                        value="{{ $data->name }}" required>
                                    @if ($errors->has('username'))
                                        <p class="text-danger">{{ $errors->first('username') }}</p>
                                    @endif
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="floatingInput" class="col-sm-2 col-form-label">Votre Email</label>
                                <div class="col-sm-10">
                                <input type="email" class="form-control" name="email" 
                                     value="{{ $data->email }}" required readonly>
                                @if ($errors->has('email'))
                                    <p class="help-block text-danger">{{ $errors->first('email') }}</p>
                                @endif
                                </div> 
                            </div>   
                           <div class="row mb-3">
                             <label for="floatingInput" class="col-sm-2 col-form-label">Téléphone</label>
                              <div class="col-sm-10">
                                <input class="form-control" type="tel" value="{{ $data->tel }}"  name="tel" required>
                                @if ($errors->has('tel'))
                                 <p class="help-block text-danger">{{ $errors->first('tel') }}</p>
                                 @endif
                              </div>
                           </div>
                        <div class="row mb-3">
                            <label  for="floatingInput" class="col-sm-2 col-form-label">Adresse</label>
                            <div class="col-sm-10">
                            <input class="form-control" type="text" value="{{ $data->map }}" name="adresse" required>
                        @if ($errors->has('adresse'))
                            <p class="help-block text-danger">{{ $errors->first('adresse') }}</p>
                        @endif
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
