<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1 class="text-center">Welcome to {{ config('app.name') }}</h1>
    <hr>
    <span class="fw-bold">Hello {{ $name }}</span>
    <p>Thank you for registration</p>
    <br>
    <p>To start, please access the website. <a href="{{ $app_url }}" class="btn btn-primary">here</a></p>
    <br>
    <p>If you did not sign up to this account, you can ignore this email.</p>
    <p>Best regards,</p>
    <p>The Team</p>
    <hr>
    <p>
    &copy;
    2024 Kredo Insta App. All rights reserved.
    </p>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
