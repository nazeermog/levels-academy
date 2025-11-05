<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Levels Academy - Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        @font-face {
            font-family: myFirstFont;
            src: url(/fonts/DroidKufi-Regular.ttf);
        }

        * {
            font-family: myFirstFont !important;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        .background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .logo-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            padding-left: 4rem;
            max-width: 50%;
        }

        .levels-subtitle {
            font-size: 1.5rem;
            color: #b0b0b0;
            margin-bottom: 1rem;
            text-align: left;
            font-weight: 300;
        }

        .levels-logo {
            font-size: 5rem;
            font-weight: 700;
            color: #12a3bb;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.5);
            margin-bottom: 0.5rem;
            text-align: left;
            line-height: 1.2;
        }

        .levels-academy {
            font-size: 1.8rem;
            color: #b0b0b0;
            letter-spacing: 0.3em;
            text-align: left;
            font-weight: 300;
            margin-bottom: 1rem;
        }

        .background-description {
            color: #b0b0b0;
            font-size: 1rem;
            text-align: left;
            line-height: 1.6;
            max-width: 500px;
            margin-bottom: 2rem;
        }

        .decorative-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .chart-line {
            position: absolute;
            height: 2px;
            background: linear-gradient(90deg, #12a3bb, #b0b0b0);
            border-radius: 1px;
            animation: drawLine 4s ease-in-out infinite;
        }

        .chart-line:nth-child(1) {
            width: 300px;
            top: 20%;
            left: 10%;
            transform: rotate(15deg);
            animation-delay: 0s;
        }

        .chart-line:nth-child(2) {
            width: 250px;
            top: 70%;
            right: 15%;
            transform: rotate(-15deg);
            animation-delay: 2s;
        }

        .chart-line:nth-child(3) {
            width: 200px;
            top: 40%;
            left: 5%;
            transform: rotate(45deg);
            animation-delay: 1s;
        }

        .chart-line:nth-child(4) {
            width: 180px;
            top: 80%;
            right: 5%;
            transform: rotate(-45deg);
            animation-delay: 3s;
        }

        @keyframes drawLine {
            0% { width: 0; opacity: 0; }
            50% { opacity: 1; }
            100% { width: 300px; opacity: 0.7; }
        }

        .floating-circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(18, 163, 187, 0.1);
            animation: float 8s ease-in-out infinite;
        }

        .floating-circle:nth-child(1) {
            width: 100px;
            height: 100px;
            top: 15%;
            left: 8%;
            animation-delay: 0s;
        }

        .floating-circle:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            right: 10%;
            animation-delay: 3s;
        }

        .floating-circle:nth-child(3) {
            width: 80px;
            height: 80px;
            top: 85%;
            left: 15%;
            animation-delay: 6s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-30px) scale(1.1); }
        }

        .login-form-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            padding: 3.5rem;
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.4), 0 0 0 1px rgba(255, 255, 255, 0.1);
            width: 90%;
            max-width: 420px;
            z-index: 10;
            border: 2px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .login-form-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        }

        .form-title {
            text-align: center;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 2.5rem;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
            background: linear-gradient(135deg, #12a3bb, #667eea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #fff;
            font-size: 0.9rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
        }

        .form-control {
            width: 100%;
            padding: 1rem 1.2rem;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            min-height: 50px;
            box-sizing: border-box;
            color: #333;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .form-control:focus {
            outline: none;
            border-color: #12a3bb;
            box-shadow: 0 0 0 4px rgba(18, 163, 187, 0.15), 0 8px 25px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }

        .btn-login {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #12a3bb 0%, #667eea 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1.5rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
            min-height: 50px;
            box-shadow: 0 6px 20px rgba(18, 163, 187, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(18, 163, 187, 0.6);
            background: linear-gradient(135deg, #0f8a9e 0%, #5a67d8 100%);
        }

        .btn-login:active {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(18, 163, 187, 0.4);
        }

        .login-logo {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 1rem;
        }

        .login-logo img {
            max-width: 240px;
            height: auto;
            display: block;
            border-radius: 8px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.25);
        }

        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }

        .forgot-password a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
        }

        .forgot-password a:hover {
            text-decoration: underline;
            color: #12a3bb;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .background-container {
                flex-direction: column;
                justify-content: space-between;
                align-items: center;
                padding: 1rem;
            }
            
            .logo-section {
                flex: 1;
                max-width: 100%;
                padding-right: 0;
                align-items: center;
                justify-content: center;
                order: 1;
                display: flex;
                flex-direction: column;
            }
            
            .levels-subtitle {
                text-align: center;
                font-size: 1.2rem;
            }
            
            .levels-logo {
                text-align: center;
                font-size: 3.5rem;
            }
            
            .levels-academy {
                text-align: center;
                font-size: 1.3rem;
            }
            
            .background-description {
                text-align: center;
                font-size: 0.9rem;
                max-width: 400px;
            }
            
            .login-form-container {
                width: 95%;
                max-width: 380px;
                padding: 2.5rem 2rem;
                order: 2;
                margin: 0 auto 1rem auto;
                flex-shrink: 0;
            }
        }

        @media (max-width: 480px) {
            .background-container {
                padding: 0.5rem;
            }
            
            .logo-section {
                margin-bottom: 0;
            }
            
            .levels-logo {
                font-size: 2.8rem;
            }
            
            .levels-subtitle {
                font-size: 1rem;
            }
            
            .levels-academy {
                font-size: 1.1rem;
            }
            
            .background-description {
                font-size: 0.8rem;
                max-width: 350px;
            }
            
            .login-form-container {
                width: 98%;
                max-width: 340px;
                padding: 2rem 1.5rem;
                margin: 0 auto 0.5rem auto;
            }
            
            .form-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 375px) {
            .background-container {
                padding: 0.5rem;
            }
            
            .logo-section {
                margin-bottom: 0;
            }
            
            .levels-logo {
                font-size: 2.2rem;
            }
            
            .levels-subtitle {
                font-size: 0.9rem;
            }
            
            .levels-academy {
                font-size: 0.9rem;
            }
            
            .background-description {
                font-size: 0.7rem;
                max-width: 300px;
            }
            
            .login-form-container {
                width: 98%;
                max-width: 320px;
                padding: 1.8rem 1.2rem;
                margin: 0 auto 0.5rem auto;
            }
            
            .form-title {
                font-size: 1.6rem;
            }
            
            .form-control, .btn-login {
                font-size: 0.9rem;
                padding: 0.8rem;
            }
        }

        @media (max-width: 320px) {
            .background-container {
                padding: 0.3rem;
            }
            
            .logo-section {
                margin-bottom: 0;
            }
            
            .levels-logo {
                font-size: 1.8rem;
            }
            
            .levels-subtitle {
                font-size: 0.8rem;
            }
            
            .levels-academy {
                font-size: 0.8rem;
            }
            
            .background-description {
                font-size: 0.6rem;
                max-width: 280px;
            }
            
            .login-form-container {
                width: 98%;
                max-width: 300px;
                padding: 1.5rem 1rem;
                margin: 0 auto 0.3rem auto;
            }
            
            .form-title {
                font-size: 1.4rem;
            }
        }
    </style>
</head>
<body>

<div class="background-container">
    <div class="decorative-elements">
        <div class="chart-line"></div>
        <div class="chart-line"></div>
        <div class="chart-line"></div>
        <div class="chart-line"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
        <div class="floating-circle"></div>
    </div>
    
    <div class="logo-section">
        <div class="levels-subtitle">We will take you to the next</div>
        <div class="levels-logo">
            L<span style="color: #b0b0b0;">E</span>V<span style="color: #b0b0b0; position: relative;">
                <span style="position: absolute; top: -10px; left: 50%; transform: translateX(-50%); color: #12a3bb; font-size: 0.3em;">▲</span>
            </span>E<span style="color: #b0b0b0;">L</span>S
        </div>
        <div class="levels-academy">ACADEMY</div>
        <div class="background-description">
            An advanced learning platform to develop your skills and achieve your academic and professional goals
        </div>
    </div>

    <!-- Login Form Container -->
    <div class="login-form-container">
    
    @include('auth::notification.error')
    @include('auth::notification.success')
    
    <form action="{{route('users.login')}}" method="POST">
        @csrf
        <div class="login-logo">
            <img src="{{ asset('images/logo/woderhafen.jpg') }}" alt="Wonderhafen logo">
        </div>
        <div class="form-group">
            <label class="form-label" for="email">
                Email
            </label>
            <input id="email"
                   name="email"
                   type="email"
                   class="form-control"
                   placeholder="Enter your email"
                   required>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="password">
                Password
            </label>
            <input id="password"
                   name="password"
                   type="password"
                   class="form-control"
                   placeholder="Enter your password"
                   required>
        </div>
        
        <button class="btn-login" type="submit">
            Login
        </button>
        
        <div class="forgot-password">
            <a href="#" style="color: #12a3bb; text-decoration: none;">
                Forgot your password?
            </a>
        </div>
    </form>
    </div>
</div>

</body>
</html>