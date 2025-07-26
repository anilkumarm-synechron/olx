<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'User Dashboard')</title>

  <!-- Font Awesome & AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css" />
</head>
<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed sidebar-light-primary">
<div class="wrapper">

  <!-- Navbar: dark header -->
  <nav class="main-header navbar navbar-expand navbar-dark bg-dark">
    <div class="container">
      <!-- Left: OLX logo/name -->
      <a href="#" class="navbar-brand font-weight-bold">Sell or buy whatever you want!</a>
      <!-- Right: toggle & logout -->
      <ul class="navbar-nav ml-auto">
        <!-- Sidebar toggle -->
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <!-- Logout -->
        <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button class="btn btn-link nav-link" style="color:#fff;">Logout</button>
          </form>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Sidebar: collapsible and fixed -->
  <aside class="main-sidebar sidebar-light-primary elevation-4 sidebar-collapse">
    <!-- Brand logo -->
    <a href="#" class="brand-link">
      <span class="brand-text font-weight-light">OLX</span>
    </a>
    <!-- Sidebar menu -->
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>Home</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>Profile</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>Post Ad</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-info-circle"></i>
              <p>About</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content: offset for fixed sidebar -->
  <div class="content-wrapper" style="margin-left: 250px; padding: 20px; padding-top: 70px;">
    <h1>@yield('page-title', 'Dashboard')</h1>
    @yield('content')
  </div>

</div>

<!-- Control Sidebar (optional) -->
<!-- AdminLTE JS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>