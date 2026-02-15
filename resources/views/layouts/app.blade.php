<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Techpace Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Techpace</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        @auth
        <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-link nav-link">Logout</button></form>
        </li>
        @else
        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
    @yield('content')
</div>
</body>
</html>