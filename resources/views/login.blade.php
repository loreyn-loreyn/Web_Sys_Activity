@php
    $firstResumeUserId = \App\Models\Resume::first()?->user_id ?? 1;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to bottom, 
                rgb(74, 203, 226) 0%, 
                rgb(67, 151, 129) 33%, 
                white 33%, 
                white 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .login-container {
            background: #fff;
            width: 350px;
            padding: 40px 30px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
            width: 100%;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: bold;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            padding-right: 45px; /* space for eye icon */
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
        }

        .input-group input:focus {
            border: 1px rgb(74, 203, 226);
            box-shadow: 0 0 5px rgb(67, 151, 129);
        }

        .toggle-password {
            position: absolute;
            top: 65%;
            right: 12px;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #888;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color:rgb(67, 151, 129);
        }

        button {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: none;
            background: linear-gradient(135deg, rgb(74, 203, 226), rgb(67, 151, 129));
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .error-box {
            background: rgba(255, 0, 0, 0.1); /* light transparent red */
            color: rgb(231, 3, 3);
            border: 1px solid rgb(231, 3, 3);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
            text-align: center;
        }
        

    </style>
</head>
<body>

    <div class="login-container">
        <h2>Login</h2>

        {{-- Laravel error messages --}}
        @if (session('error'))
            <div class="error-box">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <div class="input-group">
                <label>Email</label>
                <input type="text" name="email" placeholder="Enter email">
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" id="password" placeholder="Enter password">
                <span class="toggle-password" onclick="togglePassword()">>ᴗ<</span>
            </div>

            <button type="submit">Login</button>

            <div style="width: 100%; margin-top: 20px; text-align: center;">
                <a href="{{ route('resume.preview', ['user_id' => $firstResumeUserId]) }}"
                style="display: inline-block;
                        width: 100%;
                        padding: 12px 0;
                        border-radius: 8px;
                        font-weight: bold;
                        font-size: 16px;
                        color: #fff;
                        text-decoration: none;
                        text-align: center;
                        background: linear-gradient(135deg, rgb(74, 203, 226), rgb(67, 151, 129));
                        transition: transform 0.2s ease, box-shadow 0.2s ease;"
                onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 5px 15px rgba(0,0,0,0.2)';"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    Preview Resume
                </a>
            </div>

        </form>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const icon = document.querySelector(".toggle-password");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.textContent = "◕⩊◕"; // change icon when visible
            } else {
                passwordInput.type = "password";
                icon.textContent = ">ᴗ<";
            }
        }
    </script>
</body>
</html>
