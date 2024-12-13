<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test Coding - Hash Micro</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="icon" href="{{ asset('hash-micro.png') }}" type="image/png">

    <!-- Custom CSS -->
    <style>
        /* Body and overall layout */
        body {
            font-family: 'Source Sans Pro', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .login-page {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #fff;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .login-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-logo img {
            max-width: 100px;
        }

        .login-form {
            display: flex;
            flex-direction: column;
        }

        .login-form input {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .login-form button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-form button:hover {
            background-color: #0056b3;
        }

        .text-center {
            text-align: center;
        }

    </style>
</head>
<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('hash-micro.png') }}" alt="Hash Micro Logo">
        </div>

        @yield('content')

    </div>
</body>
</html>
