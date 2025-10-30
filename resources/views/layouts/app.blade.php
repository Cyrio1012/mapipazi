<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>APIPA - @yield('title', 'Dashboard')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --sidebar-width: 250px;
      --sidebar-collapsed-width: 80px;
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
      padding: 2rem;
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
</head>
<body>

  <!-- Topbar -->
  <div class="topbar">
    <button class="btn btn-light btn-sm me-3" onclick="toggleSidebar()">☰</button>
    <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
  </div>

  <!-- Sidebar -->
  <div id="sidebar" class="sidebar">
    <div class="sidebar-header">
      <h5>APIPA</h5>
      <small>Gestion des Remblais</small>
    </div>

    <nav class="nav flex-column mt-3">
      <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
      <a class="nav-link {{ request()->routeIs('proprietes.*') ? 'active' : '' }}" href="{{ route('proprietes.create', ['descente' => 1]) }}"><i class="bi bi-file-earmark-text"></i> <span>Demande PC</span></a>

      <a class="nav-link {{ request()->routeIs('descentes.*') ? 'active' : '' }}" href="{{ route('descentes.index') }}"><i class="bi bi-arrow-down-circle"></i> <span>Descentes</span></a>

      <a class="nav-link {{ request()->routeIs('fts.*') ? 'active' : '' }}" href="{{ route('fts.index') }}"><i class="bi bi-clipboard-check"></i> <span>F.T</span></a>

      {{-- <a class="nav-link {{ request()->routeIs('') ? 'active' : '' }}" href="{{ route('apipa') }}"><i class="bi bi-building"></i> <span>APIPA</span></a> --}}
      <a class="nav-link {{ request()->routeIs('cartographie.*') ? 'active' : '' }}" href="{{ route('cartographie.index') }}"><i class="bi bi-map"></i> <span>Cartographie</span></a>

      <hr>
      <a class="nav-link" href="#"><i class="bi bi-box-arrow-right"></i> <span>Déconnexion</span></a>
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
</body>
</html>
