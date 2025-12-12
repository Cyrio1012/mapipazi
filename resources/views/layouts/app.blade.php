<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>APIPA - @yield('title', 'Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="/assets/img/fav.png">
  <link href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/autofill/2.7.1/css/autoFill.dataTables.min.css" rel="stylesheet">


  <style>
    :root {
      --sidebar-width: 250px;
      --sidebar-collapsed-width: 60px;
      --topbar-height: 56px;
      --transition-speed: 0.3s;
      --primary-color: #0060a0ff;
      --hover-color: #064272ff;
    }

    body {
      overflow-x: hidden;
      background-color: #f5f5f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* ======= Topbar ======= */
    .topbar {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: var(--topbar-height);
      background-color: var(--primary-color);
      color: white;
      z-index: 1050;
      display: flex;
      align-items: center;
      padding: 0 1rem;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* ======= Sidebar ======= */
    .sidebar {
      position: fixed;
      top: var(--topbar-height);
      left: 0;
      height: 100vh;
      width: var(--sidebar-width);
      background-color: white;
      border-right: 1px solid #ddd;
      transition: width var(--transition-speed);
      box-shadow: 2px 0 5px rgba(0,0,0,0.05);
    }

    .sidebar.collapsed {
      width: var(--sidebar-collapsed-width);
    }

    .sidebar-header {
      text-align: center;
      padding: 1rem;
      border-bottom: 1px solid #eee;
    }

    .sidebar-header h5 {
      margin: 0;
      font-weight: bold;
      color: var(--primary-color);
    }

    .sidebar-header small {
      color: gray;
      font-size: 0.8rem;
    }

    /* ======= Sidebar links ======= */
    .sidebar .nav-link {
      color: #333;
      padding: 0.75rem 1rem;
      transition: background-color 0.2s;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 500;
    }

    .sidebar .nav-link i {
      font-size: 1.2rem;
      width: 20px;
      text-align: center;
    }

    .sidebar .nav-link:hover {
      background-color: #f0f0f0;
    }

    .sidebar .nav-link.active {
      background-color: var(--primary-color);
      color: white;
      font-weight: bold;
    }

    .sidebar.collapsed .nav-link span {
      display: none;
    }

    /* ======= Content ======= */
    .content {
      margin-left: var(--sidebar-width);
      margin-top: var(--topbar-height);
      transition: margin-left var(--transition-speed);
      padding: 0rem;
    }

    .content.collapsed {
      margin-left: var(--sidebar-collapsed-width);
    }

    /* ======= Animation ======= */
    .fade-in {
      animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    </style>
    @stack('styles')
</head>
<body  class="@if(request()->routeIs('cartographie.index')) sidebar-collapsed @endif">

  <!-- Topbar -->
   
  <!-- <div class="topbar"> -->
    <!-- 
    <h5 class="mb-0">@yield('title', 'Dashboard')</h5> -->

<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm fixed-top">
  
  <div class="container-fluid">
    @if(request()->routeIs('cartographie.index'))
      <style>
        :root {
          --sidebar-collapsed-width: 0px !important;
        }

      </style>
      <script>
            document.addEventListener('DOMContentLoaded', function() {
                    toggleSidebar();
                }
            );
        </script>
    @endif
    <button class="btn btn-light btn-sm me-3" onclick="toggleSidebar()">☰</button>
    <!-- Logo -->
    <a class="navbar-brand" href="{{ route('dashboard') }}">
      <img src="{{ asset('assets/img/logo30ans.png') }}" alt="Logo" height="30">
    </a>

    <!-- Hamburger -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navigation -->
    <div class="collapse navbar-collapse" id="mainNavbar">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
        <!-- Ajoute ici d'autres liens si besoin -->
      </ul>

      <!-- Dropdown utilisateur -->
      @auth
      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }} ({{ strtoupper(Auth::user()->statut) }})
              
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li>
              <a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item" type="submit">Déconnexion</button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
      @endauth
    </div>
  </div>
</nav>


  <!-- </div> -->

  <!-- Sidebar -->
  <div id="sidebar" class="sidebar">
    <div class="sidebar-header">
      <h5>APIPA</h5>
    </div>

    <nav class="nav flex-column mt-3">
      <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
      <a class="nav-link {{ request()->routeIs('dashboardArchive') ? 'active' : '' }}" href="{{ route('dashboardArchive') }}"><i class="bi bi-speedometer2"></i> <span>Dashboard Archive</span></a>
      @if(auth()->user()->statut === 'agent' || auth()->user()->statut === 'admin' )
      <a class="nav-link {{ request()->routeIs('descentes.*') ? 'active' : '' }}" href="{{ route('descentes.index') }}"><i class="bi bi-arrow-down-circle"></i> <span>Descentes</span></a>
      @endif
      <a class="nav-link {{ request()->routeIs('aps.*') ? 'active' : '' }}" href="{{ route('aps.index') }}"><i class="bi bi-clipboard-check"></i> <span>Avis de payement</span></a>
      @if(auth()->user()->statut === 'agent' || auth()->user()->statut === 'admin' )
     <a class="nav-link {{ request()->routeIs('descente.rdv') ? 'active' : '' }}" href="{{ route('descente.rdv') }}"><i class="bi bi-building"></i> <span>RDV</span></a>
      @endif
      <a class="nav-link {{ request()->routeIs('cartographie.*') ? 'active' : '' }}" href="{{ route('cartographie.index') }}"><i class="bi bi-map"></i> <span>Cartographie</span></a>
      @if(auth()->user()->statut === 'agent' || auth()->user()->statut === 'admin' )
      <a class="nav-link {{ request()->routeIs('matros.*') ? 'active' : '' }}" href="{{ route('matros.index') }}"><i class="bi bi-file-earmark-text"></i> <span>Materielle roulante</span></a>
      @endif
      <a class="nav-link {{ request()->routeIs('archives.*') ? 'active' : '' }}" href="{{ route('archives.index') }}"><i class="bi bi-file-earmark-text"></i> <span>Archives</span></a>
      @if(auth()->user()->statut === 'admin')
      <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}"><i class="bi bi-people"></i> <span>Utilisateurs</span></a>
      @endif
      <hr>
    </nav>
  </div>

  <!-- Contenu principal -->
  <div id="mainContent" class="content fade-in">
    @yield('content')
  </div>

  <!-- Scripts -->
  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('mainContent').classList.toggle('collapsed');
    }
  </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.7.1/js/dataTables.autoFill.min.js"></script>
@yield('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.7.1/js/dataTables.autoFill.min.js"></script>
@yield('scripts')
  @stack('scripts')




</body>
</html>
