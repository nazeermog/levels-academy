<!DOCTYPE html>
@php
    // Org-aware branding. On an org subdomain (e.g. yasmine.levels-academy.com) the
    // OrganizationResolver shares $currentOrganization; we then show that org's logo,
    // name and a light brand theme. On the main domain we keep the Levels look.
    $org       = $currentOrganization ?? null;
    $brandName = $org && $org->name ? $org->name : 'Levels Academy';
    $orgLogo   = $org ? asset('images/logo/' . $org->subdomain . '.png') : null;
    $tagline   = $org ? 'Bloom into your best self' : 'We will take you to the next';
@endphp
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $brandName }} - Login</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* --- Theme tokens: light brand theme on an org subdomain, dark otherwise --- */
        :root {
        @if ($org)
            --bg: linear-gradient(135deg, #eef8f2 0%, #d3f0e0 100%);
            --accent: #1f7a50; --accent-dark: #16593a; --accent2: #d996b0;
            --panel-bg: rgba(255, 255, 255, 0.88);
            --panel-border: rgba(31, 122, 80, 0.18);
            --text: #1b2a24; --muted: #5a6b62; --label: #2f4038;
            --input-bg: #ffffff; --input-border: rgba(31, 122, 80, 0.30);
            --title-a: #1f7a50; --title-b: #57c99a;
            --btn-a: #1f7a50; --btn-b: #3fae7d;
            --deco: rgba(87, 201, 154, 0.16);
            --shadow: rgba(31, 122, 80, 0.18);
        @else
            --bg: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 50%, #1a1a1a 100%);
            --accent: #12a3bb; --accent-dark: #0f8a9e; --accent2: #667eea;
            --panel-bg: rgba(255, 255, 255, 0.15);
            --panel-border: rgba(255, 255, 255, 0.2);
            --text: #ffffff; --muted: #b0b0b0; --label: #ffffff;
            --input-bg: rgba(255, 255, 255, 0.95); --input-border: rgba(255, 255, 255, 0.3);
            --title-a: #12a3bb; --title-b: #667eea;
            --btn-a: #12a3bb; --btn-b: #667eea;
            --deco: rgba(18, 163, 187, 0.10);
            --shadow: rgba(0, 0, 0, 0.4);
        @endif
        }

        @font-face { font-family: myFirstFont; src: url(/fonts/DroidKufi-Regular.ttf); }
        * { font-family: myFirstFont !important; }

        body {
            margin: 0; padding: 0;
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            min-height: 100vh; overflow-x: hidden; position: relative;
        }

        .background-container {
            position: fixed; inset: 0; z-index: 1;
            display: flex; flex-direction: row; align-items: center; justify-content: center;
            padding: 2rem; gap: 2rem;
        }

        .logo-section {
            flex: 1; display: flex; flex-direction: column;
            align-items: flex-start; justify-content: center;
            padding-left: 4rem; max-width: 50%;
        }

        .brand-logo { max-width: 320px; width: 80%; height: auto; margin-bottom: 1rem; }

        .levels-subtitle { font-size: 1.4rem; color: var(--muted); margin-bottom: 1rem; font-weight: 300; }
        .levels-logo { font-size: 5rem; font-weight: 700; color: var(--accent); margin-bottom: 0.5rem; line-height: 1.2; }
        .levels-academy { font-size: 1.8rem; color: var(--muted); letter-spacing: 0.3em; font-weight: 300; margin-bottom: 1rem; }
        .brand-name { font-size: 2.6rem; font-weight: 700; color: var(--accent); margin-bottom: .25rem; }
        .background-description { color: var(--muted); font-size: 1rem; line-height: 1.6; max-width: 500px; }

        .decorative-elements { position: absolute; inset: 0; overflow: hidden; z-index: 0; }
        .floating-circle { position: absolute; border-radius: 50%; background: var(--deco); animation: float 8s ease-in-out infinite; }
        .floating-circle:nth-child(1) { width: 120px; height: 120px; top: 15%; left: 8%; }
        .floating-circle:nth-child(2) { width: 170px; height: 170px; top: 60%; right: 10%; animation-delay: 3s; }
        .floating-circle:nth-child(3) { width: 90px; height: 90px; top: 82%; left: 15%; animation-delay: 6s; }
        @keyframes float { 0%,100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-30px) scale(1.1); } }

        .login-form-container {
            flex: 1; display: flex; flex-direction: column;
            background: var(--panel-bg); backdrop-filter: blur(15px);
            padding: 3rem; border-radius: 24px;
            box-shadow: 0 25px 50px var(--shadow), 0 0 0 1px var(--panel-border);
            width: 90%; max-width: 420px; z-index: 10;
            border: 1px solid var(--panel-border); position: relative;
        }

        .login-logo { width: 100%; display: flex; justify-content: center; margin-bottom: 1.25rem; }
        .login-logo img { max-width: 180px; height: auto; }

        /* --- Clean, self-contained flash messages (no Bootstrap on this page) --- */
        .flash { display: flex; gap: .6rem; align-items: flex-start; padding: .8rem .95rem; border-radius: 12px; margin-bottom: .85rem; font-size: .88rem; line-height: 1.45; }
        .flash svg { flex: 0 0 auto; margin-top: 1px; }
        .flash strong { display: block; margin-bottom: .15rem; }
        .flash ul { margin: 0; padding-left: 1.05rem; }
        .flash li { margin: .1rem 0; }
        .flash--error { background: #fdecec; border: 1px solid #f2b6b3; color: #9c332f; }
        .flash--error svg { color: #d9534f; }
        .flash--success { background: #eaf7f1; border: 1px solid #b7e3d1; color: #2b6b52; }
        .flash--success svg { color: #2e9e5b; }

        .form-group { margin-bottom: 1.35rem; }
        .form-label { display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--label); font-size: 0.9rem; }
        .form-control {
            width: 100%; padding: .9rem 1.1rem; border: 2px solid var(--input-border);
            border-radius: 12px; font-size: 1rem; transition: all 0.25s ease;
            background: var(--input-bg); min-height: 50px; box-sizing: border-box; color: #333;
        }
        .form-control:focus {
            outline: none; border-color: var(--accent);
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--accent) 18%, transparent);
        }

        .btn-login {
            width: 100%; padding: 1rem;
            background: linear-gradient(135deg, var(--btn-a) 0%, var(--btn-b) 100%);
            color: white; border: none; border-radius: 12px;
            font-size: 1.1rem; font-weight: 700; cursor: pointer;
            transition: all 0.25s ease; margin-top: 1rem; min-height: 50px;
            box-shadow: 0 6px 20px color-mix(in srgb, var(--accent) 40%, transparent);
        }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 12px 30px color-mix(in srgb, var(--accent) 55%, transparent); }
        .btn-login:active { transform: translateY(0); }

        .forgot-password { text-align: center; margin-top: 1rem; }
        .forgot-password a { color: var(--accent); text-decoration: none; font-size: 0.9rem; }
        .forgot-password a:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            .background-container { flex-direction: column; justify-content: center; padding: 1.25rem; gap: 1rem; }
            .logo-section { max-width: 100%; padding-left: 0; align-items: center; text-align: center; order: 1; }
            .brand-logo { max-width: 200px; }
            .levels-logo { font-size: 3.4rem; }
            .brand-name { font-size: 2rem; }
            .background-description { text-align: center; }
            .login-form-container { width: 95%; max-width: 400px; padding: 2.25rem 1.75rem; order: 2; }
        }
        @media (max-width: 480px) {
            .login-form-container { width: 100%; max-width: 360px; padding: 1.9rem 1.4rem; }
            .levels-logo { font-size: 2.8rem; }
        }
    </style>
</head>

<body>
    <div class="background-container">
        <div class="decorative-elements">
            <div class="floating-circle"></div>
            <div class="floating-circle"></div>
            <div class="floating-circle"></div>
        </div>

        <div class="logo-section">
            @if ($org)
                @if ($orgLogo)
                    <img src="{{ $orgLogo }}" alt="{{ $brandName }} logo" class="brand-logo"
                         onerror="this.style.display='none'">
                @endif
                <div class="brand-name">{{ $brandName }}</div>
                <div class="background-description">{{ $tagline }}</div>
            @else
                <div class="levels-subtitle">{{ $tagline }}</div>
                <div class="levels-logo">LEVELS</div>
                <div class="levels-academy">ACADEMY</div>
                <div class="background-description">
                    An advanced learning platform to develop your skills and achieve your academic and professional goals
                </div>
            @endif
        </div>

        <!-- Login Form Container -->
        <div class="login-form-container">

            @if ($errors->any())
                <div class="flash flash--error" role="alert">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86 1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <div>
                        <strong>Please fix the following:</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="flash flash--success" role="alert">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            <form action="{{ route('users.login') }}" method="POST">
                @csrf
                {{-- Auto-detected browser timezone, stored on the user for server-side rendering (emails/ICS). --}}
                <input type="hidden" name="tz" id="tz">
                <script>
                    try { document.getElementById('tz').value = Intl.DateTimeFormat().resolvedOptions().timeZone || ''; } catch (e) {}
                </script>

                @if ($org && $orgLogo)
                    <div class="login-logo">
                        <img src="{{ $orgLogo }}" alt="{{ $brandName }} logo" onerror="this.parentNode.style.display='none'">
                    </div>
                @endif

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-control"
                        value="{{ old('email') }}" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input id="password" name="password" type="password" class="form-control"
                        placeholder="Enter your password" required>
                </div>

                <button class="btn-login" type="submit">Login</button>

                <div class="forgot-password">
                    <a href="#">Forgot your password?</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
