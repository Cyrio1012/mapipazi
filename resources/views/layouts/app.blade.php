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
    }

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

    .sidebar .nav-link {
      color: #333;
      padding: 0.75rem 1rem;
      transition: background-color 0.2s;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .sidebar .nav-link:hover {
      background-color: #eee;
    }

    .sidebar .nav-link.active {
      background-color: var(--primary-color);
      color: white;
      font-weight: bold;
    }

    .sidebar.collapsed .nav-link span {
      display: none;
    }

    .content {
      margin-left: var(--sidebar-width);
      margin-top: var(--topbar-height);
      transition: margin-left var(--transition-speed);
      padding: 2rem;
    }

    .content.collapsed {
      margin-left: var(--sidebar-collapsed-width);
    }

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

  <!-- Top-Bar -->
  <div class="topbar">
    <button class="btn btn-light btn-sm me-3" onclick="toggleSidebar()">☰</button>
    <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
  </div>

  <!-- Sidebar -->
  <div id="sidebar" class="sidebar">
    <nav class="nav flex-column mt-3">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}" onclick="setActive(this)"><i class="bi bi-bar-chart"></i> <span>Dashboard</span></a>
      <a class="nav-link {{ request()->routeIs('descentes.index') ? 'active' : '' }}" href="{{ route('descentes.index') }}" onclick="setActive(this)"><i class="bi bi-house-door"></i> <span>Descentes</span></a>
      <a class="nav-link {{ request()->routeIs('fts.index') ? 'active' : '' }}" href="{{ route('fts.index') }}" onclick="setActive(this)"><i class="bi bi-gear"></i> <span>Confisquation</span></a>
      <a class="nav-link" href="#" onclick="setActive(this)"><i class="bi bi-box-arrow-right"></i> <span>Déconnexion</span></a>
    </nav>
  </div>

  <!-- Contenu principal -->
  <div id="mainContent" class="content fade-in">
    @yield('content')
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('collapsed');
      document.getElementById('mainContent').classList.toggle('collapsed');
    }

    function setActive(el) {
      document.querySelectorAll('.sidebar .nav-link').forEach(link => link.classList.remove('active'));
      el.classList.add('active');
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
