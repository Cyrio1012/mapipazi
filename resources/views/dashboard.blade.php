@extends('layouts.app')
@section('title', 'Tableau Bord')
@section('content')
<div class="overlay" :class="{ show: sidebarOpen }" onclick="toggleSidebar()"></div>
    
    <x-sidebar />
    
    <div class="main-content" :class="{ shifted: sidebarOpen }">
        <x-topbar />
        
        <div class="content-area">
            <h2>Bienvenue sur le tableau de bord</h2>
            <p>Ceci est la page principale du tableau de bord.</p>
        </div>
    </div>
@endsection

@section('scripts')

@endsection