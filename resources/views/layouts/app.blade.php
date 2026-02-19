<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Techpace Solutions</title>

  <!-- Fonts: Outfit -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Outfit', sans-serif;
      background-color: #f8fafc;
      /* Very subtle, high-key gradient for depth without darkness */
      background-image:
        radial-gradient(circle at 10% 20%, rgba(219, 234, 254, 0.4) 0%, transparent 20%),
        radial-gradient(circle at 90% 10%, rgba(224, 231, 255, 0.4) 0%, transparent 20%);
      min-height: 100vh;
      color: #334155;
    }

    .glass {
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.5);
    }

    .navbar-brand {
      font-weight: 700;
      letter-spacing: -0.025em;
      color: #1e293b !important;
    }

    .card {
      border: none;
      border-radius: 16px;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
      background: rgba(255, 255, 255, 0.95);
    }

    .form-control {
      border: 2px solid #e2e8f0;
      border-radius: 8px;
      padding: 0.75rem 1rem;
      transition: all 0.2s;
      background: #f8fafc;
    }

    .form-control:focus {
      background: #fff;
      border-color: #6366f1;
      box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .form-label {
      font-weight: 500;
      color: #475569;
      margin-bottom: 0.5rem;
    }

    .btn-primary {
      background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
      border: none;
      border-radius: 8px;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
      transition: transform 0.1s, box-shadow 0.1s;
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    h3 {
      font-weight: 700;
      color: #1e293b;
      margin-bottom: 1.5rem;
      letter-spacing: -0.025em;
    }

    /* Fade In on Load */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .fade-in {
      animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
  </style>
</head>

<body class="bg-light">
  <nav class="navbar navbar-expand-lg navbar-light glass sticky-top">
    <div class="container-fluid">
      <a class="navbar-brand fade-in" href="{{ request()->fullUrl() }}">Techpace</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          @auth
            <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="nav-item">
              <form method="POST" action="{{ route('logout') }}">@csrf<button
                  class="btn btn-link nav-link">Logout</button></form>
            </li>
          @endauth
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-5 fade-in">
    @yield('content')
  </div>
</body>

</html>