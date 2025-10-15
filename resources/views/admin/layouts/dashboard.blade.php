<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Admin Dashboard')</title>
  <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>
  <div class="dashboard-wrapper d-flex">
    <!-- Sidebar -->
    <aside class="sidebar">
      @include('admin.partials.sidebar')
    </aside>

    <!-- Main wrapper -->
    <div class="main-wrapper flex-grow-1">
      <!-- Header -->
      @include('admin.partials.header')

      <!-- Main content -->
      <section class="section" id="main-content">
        @hasSection('content')
        @yield('content')
        @else
        @include('admin.partials.main')
        @endif
      </section>
    </div>
  </div>

  <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('js/main.js') }}"></script>
  @stack('scripts')
</body>

</html>