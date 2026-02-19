@extends('layouts.app')

@section('content')
    <style>
        /* Scoped Styles for Modern Login Form */
        body {
            font-family: 'Outfit', sans-serif;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #f8fafc;
        }

        /* Animated Mesh Gradient Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            background: linear-gradient(125deg, #eff6ff 0%, #f5f3ff 50%, #fff1f2 100%);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(99, 102, 241, 0.08) 0%, transparent 50%);
            animation: rotate 20s linear infinite;
        }

        .animated-bg::after {
            content: '';
            position: absolute;
            bottom: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(236, 72, 153, 0.08) 0%, transparent 50%);
            animation: rotate 25s linear infinite reverse;
        }

        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3.5rem;
            width: 100%;
            max-width: 480px;
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.5) inset;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transform: translateY(0);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-2px);
            box-shadow:
                0 35px 60px -15px rgba(0, 0, 0, 0.12),
                0 0 0 1px rgba(255, 255, 255, 0.6) inset;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            padding: 0.875rem 1rem;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: rgba(255, 255, 255, 0.8);
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            transform: translateY(-1px);
        }

        .form-label {
            font-weight: 600;
            font-size: 0.875rem;
            color: #475569;
            margin-bottom: 0.5rem;
            letter-spacing: -0.01em;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.2s ease;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
            letter-spacing: 0.01em;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -8px rgba(79, 70, 229, 0.5);
            background: linear-gradient(135deg, #4338ca 0%, #3730a3 100%);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .dev-creds {
            background: rgba(248, 250, 252, 0.8);
            border-radius: 12px;
            padding: 1rem;
            font-size: 0.85rem;
            margin-bottom: 2.5rem;
            border: 1px dashed #cbd5e1;
        }
    </style>

    <div class="animated-bg"></div>

    <div class="login-wrapper">
        <div class="login-card fade-in">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2" style="color: #1e293b; font-size: 2rem;">Welcome Back</h2>
                <p class="text-muted">Please enter your details to sign in.</p>
            </div>

            @if(config('app.debug'))
                <div class="dev-creds">
                    <p class="fw-bold mb-2 text-dark">Login Credentials:</p>
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-sm btn-outline-secondary fill-cred" data-email="admin@local"
                            data-password="password">Admin</button>
                        <button class="btn btn-sm btn-outline-secondary fill-cred" data-email="sales@local"
                            data-password="password">Sales</button>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}"
                        placeholder="Enter your email" required autofocus>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="password" class="form-label mb-0">Password</label>
                        <a href="{{ route('password.request') }}" class="text-decoration-none fw-semibold small"
                            style="color: #4f46e5;">Forgot Password?</a>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" placeholder="••••••••"
                        required>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label small text-muted" for="remember">Keep me logged in</label>
                </div>

                <button type="submit" class="btn btn-primary">Sign In</button>
            </form>

            <div class="mt-5 text-center small text-muted">
                &copy; {{ date('Y') }} Techpace. All rights reserved.
            </div>
        </div>
    </div>

    @if(config('app.debug'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.fill-cred').forEach(function (el) {
                    el.addEventListener('click', function (e) {
                        e.preventDefault();
                        var email = this.getAttribute('data-email');
                        var password = this.getAttribute('data-password');
                        document.getElementById('email').value = email;
                        document.getElementById('password').value = password;
                    });
                });
            });
        </script>
    @endif
@endsection