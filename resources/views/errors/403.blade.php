<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>403 Forbidden - Access Denied</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: #f8fafc;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            flex-direction: column;
            padding: 20px;
        }
        .error-code {
            font-size: 120px;
            font-weight: 700;
            color: #e53e3e;
            margin: 0;
            user-select: none;
        }
        .error-message {
            font-size: 24px;
            margin: 20px 0 10px;
        }
        .error-submessage {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
            max-width: 400px;
        }
        a.button {
            background-color: #3182ce;
            color: white;
            text-decoration: none;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 6px;
            box-shadow: 0 4px 10px rgb(49 130 206 / 0.3);
            transition: background-color 0.3s ease;
        }
        a.button:hover {
            background-color: #2c5282;
        }
        @media (max-width: 480px) {
            .error-code {
                font-size: 80px;
            }
            .error-message {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div>
        <h1 class="error-code">403</h1>
        <h2 class="error-message">Access Denied</h2>
        <p class="error-submessage">You do not have permission to view this page. Please contact the administrator if you believe this is an error.</p>
        <a href="{{ url('/dashboard') }}" class="button" aria-label="Go back to homepage">Go Back Home</a>
    </div>
</body>
</html>
&nbsp;
&nbsp;
