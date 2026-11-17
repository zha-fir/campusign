<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - CAMPUSIG</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container min-vh-100 d-flex justify-content-center align-items-center">

    <div class="card shadow border-0 rounded-4" style="width: 100%; max-width: 420px;">

        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <h2 class="fw-bold text-primary">CAMPUSIGN</h2>
                <p class="text-muted">Silakan masuk ke akun Anda</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.authenticate') }}" method="POST">

                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Masukkan password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    Login
                </button>

            </form>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>