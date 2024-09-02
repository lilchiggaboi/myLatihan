<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-weight: bold;
            color: #495057;
        }
        .btn-primary {
            background-color: #A0C4FF;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #6B8CB8;
        }
        .form-control {
            border-radius: 50px;
            padding: 10px 15px;
        }
        .input-group-text {
            border-radius: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="wrapper d-flex align-items-center justify-content-center h-100">
            <div class="card login-form p-4">
                <h4 class="card-title text-center mt-3">Login Form</h4>
                <div class="card-body">
                <?php if (!empty(session('resp_msg'))) : ?>
                    <div class="alert alert-danger m-2" role="alert">
                        <?= session('resp_msg') ?>
                    </div>
                <?php endif; ?>
                <form action="<?= url('') . '/login' ?>" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div></div> <!-- Placeholder untuk menjaga jarak ke kanan -->
                        <a href="{{route ('password.request') }}" class="text-right">Forget Password</a>
                    </div>
                    <div class="sign-up mt-4">
                        Don't have an account? <a href="<?= url('register') ?>">Create One</a>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
