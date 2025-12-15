<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CollectePlus</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="login-page">
        <!-- Section de gauche avec le logo et le message -->
        <div class="brand-section">
            <div class="brand-content">
                <!-- Logo -->
                <div class="logo-container">
                    <div class="logo-icon">
                        <i class="fas fa-recycle"></i>
                    </div>
                    <h1 class="logo-text">Collecte<span>Plus</span></h1>
                </div>
                
                <!-- Message de bienvenue -->
                <div class="welcome-message">
                    <h2>Bienvenue dans votre système de gestion</h2>
                    <p>
                        CollectePlus simplifie la gestion de vos collectes et optimise 
                        vos processus logistiques. Accédez à votre tableau de bord 
                        pour suivre vos opérations en temps réel.
                    </p>
                   
                </div>
            </div>
            
            <!-- Citation en bas -->
            <div class="quote">
                <p>"Bienvenue dans votre système de gestion CollectePlus, veuillez saisir vos informations de connexion"</p>
            </div>
        </div>

        <!-- Section de droite avec le formulaire -->
        <div class="login-section">
            <div class="login-container">
                <div class="login-header">
                    <h2>Connexion à votre compte</h2>
                    <p>Entrez vos identifiants pour accéder à votre espace</p>
                </div>

                <!-- Affichage des erreurs -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <div class="alert-icon">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                        <div class="alert-content">
                            <h4>Erreur de connexion</h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Formulaire -->
                <form method="POST" action="{{ route('login') }}" class="login-form">
                    @csrf

                    <div class="form-group">
                        <label for="email">
                            <i class="fas fa-envelope"></i>
                            Adresse Email
                        </label>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            class="form-control @error('email') is-invalid @enderror" 
                            placeholder="exemple@collecteplus.com" 
                            required 
                            autofocus
                        >
                        @error('email')
                            <span class="error-message">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">
                            <i class="fas fa-lock"></i>
                            Mot de passe
                        </label>
                        <div class="password-container">
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Votre mot de passe" 
                                required
                            >
                            <button type="button" class="toggle-password" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="error-message">
                                <i class="fas fa-exclamation-triangle"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Se souvenir de moi</label>
                        </div>
                       
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i>
                        Se connecter
                    </button>

                   
                </form>
            </div>
        </div>
    </div>

    <script>
        // Fonction pour afficher/masquer le mot de passe
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
        
        // Animation d'entrée pour les champs
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (!this.value) {
                    this.parentElement.classList.remove('focused');
                }
            });
        });
    </script>
</body>
</html>
<style>

:root {
            --primary-color: #10b981;
            --primary-dark: #059669;
            --primary-light: #d1fae5;
            --secondary-color: #3b82f6;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
            --bg-white: #ffffff;
            --border-color: #e5e7eb;
            --error-color: #ef4444;
            --success-color: #10b981;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --radius: 8px;
        }

        /* Reset et styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        .login-page {
            display: flex;
            min-height: 70%;
            width: 90%;
            padding-left: 15%;
            padding-top: 6%;
        }

        /* Section de gauche (Brand) */
        .brand-section {
            flex: 1;
            background: linear-gradient(135deg, #0f766e 0%, #047857 100%);
            color: white;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .brand-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.3;
        }

        .brand-content {
            position: relative;
            z-index: 1;
        }

        /* Logo */
        .logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 40px;
        }

        .logo-icon {
            font-size: 2.2rem;
            background: rgba(255, 255, 255, 0.1);
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .logo-text span {
            color: var(--primary-light);
            font-weight: 800;
        }

        /* Message de bienvenue */
        .welcome-message {
            max-width: 500px;
        }

        .welcome-message h2 {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 16px;
            line-height: 1.3;
        }

        .welcome-message p {
            font-size: 0.95rem;
            opacity: 0.9;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        /* Citation en bas */
        .quote {
            position: relative;
            z-index: 1;
            padding: 18px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.95rem;
            font-weight: 500;
            text-align: center;
            margin-top: 20px;
        }

        /* Section de droite (Login) */
        .login-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
            background-color: var(--bg-white);
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .login-header p {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        /* Alert */
        .alert {
            display: flex;
            gap: 12px;
            padding: 16px;
            background-color: #fef2f2;
            border: 1px solid #fee2e2;
            border-radius: var(--radius);
            margin-bottom: 24px;
        }

        .alert-icon {
            color: var(--error-color);
            font-size: 1.2rem;
        }

        .alert-content h4 {
            color: var(--error-color);
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .alert-content ul {
            list-style: none;
            color: #991b1b;
            font-size: 0.85rem;
        }

        /* Formulaire */
        .login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
        }

        .form-group label i {
            color: var(--primary-color);
            font-size: 0.9rem;
        }

        .form-control {
            padding: 12px 16px;
            border: 1.5px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 0.95rem;
            transition: all 0.2s ease;
            background-color: var(--bg-white);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px var(--primary-light);
        }

        .form-control::placeholder {
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-light);
            cursor: pointer;
            font-size: 1rem;
            padding: 4px;
        }

        .toggle-password:hover {
            color: var(--primary-color);
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 6px;
            color: var(--error-color);
            font-size: 0.8rem;
            margin-top: 6px;
            font-weight: 500;
        }

        .error-message i {
            font-size: 0.8rem;
        }

        /* Options du formulaire */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--primary-color);
            cursor: pointer;
        }

        .remember-me label {
            font-size: 0.9rem;
            color: var(--text-light);
            cursor: pointer;
        }

        /* Boutons */
        .btn-login {
            padding: 14px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: var(--shadow-md);
        }

        .btn-login:hover {
            background-color: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login i {
            font-size: 0.95rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .login-page {
                flex-direction: column;
                min-height: 100vh;
            }
            
            .brand-section, .login-section {
                flex: none;
                width: 100%;
            }
            
            .brand-section {
                padding: 24px;
                min-height: 40vh;
            }
            
            .login-section {
                padding: 24px;
                min-height: 60vh;
            }
            
            .logo-container {
                margin-bottom: 30px;
            }
            
            .welcome-message h2 {
                font-size: 1.4rem;
            }
            
            .login-container {
                max-width: 400px;
            }
        }

        @media (max-width: 768px) {
            .logo-icon {
                font-size: 1.8rem;
                width: 50px;
                height: 50px;
            }
            
            .logo-text {
                font-size: 1.5rem;
            }
            
            .welcome-message h2 {
                font-size: 1.3rem;
            }
            
            .welcome-message p {
                font-size: 0.9rem;
            }
            
            .quote {
                font-size: 0.9rem;
                padding: 14px;
            }
            
            .login-header h2 {
                font-size: 1.4rem;
            }
            
            .login-header p {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .brand-section, .login-section {
                padding: 20px;
            }
            
            .form-options {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .logo-container {
                gap: 10px;
                margin-bottom: 25px;
            }
            
            .logo-icon {
                font-size: 1.6rem;
                width: 45px;
                height: 45px;
            }
            
            .logo-text {
                font-size: 1.3rem;
            }
            
            .welcome-message h2 {
                font-size: 1.2rem;
            }
            
            .quote {
                font-size: 0.85rem;
                padding: 12px;
            }
            
            .login-container {
                max-width: 100%;
            }
        }
    </style>