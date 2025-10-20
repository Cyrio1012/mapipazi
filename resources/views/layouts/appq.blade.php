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
 
</head>
<body>
  <div id="loader" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: white; z-index: 9999; display: flex; justify-content: center; align-items: center;">
      <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
      </div>
  </div>
  <div class="container-fluid">
<div class="row flex-nowrap">
<!-- Sidebar -->
<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
<div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
<a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
<span class="fs-5 d-none d-sm-inline">Menu</span>
</a>
<ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
<li class="nav-item">
<a href="#" class="nav-link align-middle px-0 text-white">
<i class="bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
</a>
</li>
<li>
<a href="#submenu1" data-bs-toggle="collapse" class="nav-link px-0 align-middle text-white">
<i class="bi-speedometer2"></i> <span class="ms-1 d-none d-sm-inline">Dashboard</span>
</a>
<ul class="collapse nav flex-column ms-1" id="submenu1" data-bs-parent="#menu">
<li><a href="#" class="nav-link px-0 text-white">Item 1</a></li>
<li><a href="#" class="nav-link px-0 text-white">Item 2</a></li>
</ul>
</li>
<li>
<a href="#" class="nav-link px-0 align-middle text-white">
<i class="bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span>
</a>
</li>
</ul>
</div>
</div>

<!-- Main Content -->
<div class="col py-3">
Content area
</div>
</div>
</div>
  <!-- <div class="container-fluid">
    <div class="row">
      <div class="col-md-3 col-lg-2 p-3 sidebar">
        <h4 class="mb-4">📋 Menu</h4>
        <nav class="nav flex-column">
          <a href="{{ route('descentes.index') }}" class="nav-link {{ request()->routeIs('descentes.index') ? 'active' : '' }}">📄 Liste des descentes</a>
          <a href="{{ route('fts.index') }}" class="nav-link {{ request()->routeIs('descentes.create') ? 'active' : '' }}">📝 FT Enregistrer</a>
          <a href="{{ route('fts.index') }}" class="nav-link {{ request()->routeIs('descentes.create') ? 'active' : '' }}">📝 AP Enregistrer</a>
        </nav>
      </div>

      <main class="col-md-9 col-lg-10 p-4">
        @yield('content')
      </main>
    </div>
  </div> -->
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


















        
   