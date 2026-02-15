@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3>Login</h3>
        @if(config('app.debug'))
        <div class="alert alert-dark">
            <strong>Dev credentials (for local testing):</strong>
            <ul class="mb-0 mt-2">
                <li>
                    <a href="#" class="fill-cred" data-email="admin@local" data-password="password"><strong>Admin:</strong> admin@local / password</a>
                </li>
                <li>
                    <a href="#" class="fill-cred" data-email="sales@local" data-password="password"><strong>Sales:</strong> sales@local / password</a>
                </li>
            </ul>
            <small class="text-muted">Click an entry to autofill the login form.</small>
        </div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="{{ route('password.request') }}" class="btn btn-link">Forgot password?</a>
        </form>
    </div>
</div>
@if(config('app.debug'))
<script>
document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.fill-cred').forEach(function(el){
        el.addEventListener('click', function(e){
            e.preventDefault();
            var email = this.getAttribute('data-email');
            var password = this.getAttribute('data-password');
            var emailInput = document.getElementById('email');
            var passInput = document.getElementById('password');
            if(emailInput) emailInput.value = email;
            if(passInput) passInput.value = password;
            if(emailInput) emailInput.focus();
        });
    });
});
</script>
@endif
@endsection