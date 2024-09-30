@extends('admin.layouts.app')

@section('title', 'Editar Perfil')

@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Editar Perfil</h5>
            <hr>
            <div class="">
                <div class="mb-4 p-4 bg-white rounded shadow-sm">
                    <div class="container">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="mb-4 p-4 bg-white rounded shadow-sm">
                    <div class="container">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="mb-4 p-4 bg-white rounded shadow-sm">
                    <div class="container">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
