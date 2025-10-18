<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>APIPA - @yield('title', 'Descente')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { overflow-x: hidden; }
    .sidebar {
      height: 100vh;
      background-color: #198754;
      color: white;
    }
    .sidebar a {
      color: white;
      text-decoration: none;
    }
    .sidebar a.active {
      font-weight: bold;
      background-color: #145c3d;
    }
    .sidebar a:hover {
      background-color: #157347;
    }
    #loader {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        z-index: 9999;
        }

  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3 col-lg-2 p-3 sidebar">
        <h4 class="mb-4">📋 Menu</h4>
        <nav class="nav flex-column">
          <a href="{{ route('descentes.index') }}" class="nav-link {{ request()->routeIs('descentes.index') ? 'active' : '' }}">📄 Liste des descentes</a>
          <a href="{{ route('fts.index') }}" class="nav-link {{ request()->routeIs('descentes.create') ? 'active' : '' }}">📝 FT Enregistrer</a>
          <a href="{{ route('fts.index') }}" class="nav-link {{ request()->routeIs('descentes.create') ? 'active' : '' }}">📝 AP Enregistrer</a>
        </nav>
      </div>

      <!-- Main content -->
      <main class="col-md-9 col-lg-10 p-4">
        @yield('content')
      </main>
    </div>
  </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <script>
        // Hide loader when page is fully loaded
        window.addEventListener('load', function() {
            const loader = document.getElementById('loader');   
            if(loader) {
                loader.style.display = 'none';
            }
        });
    </script>
  @stack('scripts')
</body>
</html>


















        
   