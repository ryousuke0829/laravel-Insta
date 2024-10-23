<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Updated</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow-sm p-4 bg-white">
            <h1 class="text-center text-success">Password Successfully Updated</h1>
            <hr>
            <p class="fw-bold">Hello, {{ $name }}</p>
            <p>Your password has been updated successfully. Thank you for taking the time to ensure your account stays secure.</p>
            <p>To get started, please visit our website by clicking the button below:</p>
            <a href="{{ $app_url }}" class="btn btn-primary mt-2">Go to Website</a>
            
            <hr>
            <p>If you did not request this change, please contact us immediately at:</p>
            <a href="mailto:app@gmail.com" class="btn btn-outline-danger">app@gmail.com</a>
        </div>
        
        <footer class="mt-5 text-center">
            <p>Best regards,<br>The Insta App Team</p>
            <p>&copy; 2024 Kredo Insta App. All rights reserved.</p>
        </footer>
    </div>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
