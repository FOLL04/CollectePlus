<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CollectePlus')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Variables CSS cohérentes */
        :root {
            --primary-color: #10b981;
            --primary-dark: #059669;
            --primary-gradient: linear-gradient(135deg, #0f766e 0%, #047857 100%);
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
            --bg-white: #ffffff;
            --border-color: #e5e7eb;
            --sidebar-width: 260px;
            --footer-height: 50px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --radius: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            overflow-x: hidden;
        }

        .app-container {
            display: flex;
            flex: 1;
            padding-top: 0;
            margin-top: 0;
        }

        /* Sidebar fixe */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--primary-gradient);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            bottom: var(--footer-height);
            height: calc(100vh - var(--footer-height));
            z-index: 100;
            overflow-y: auto;
            box-shadow: var(--shadow-md);
        }

        /* Contenu principal avec marge pour la sidebar */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: calc(100vh - var(--footer-height));
            background-color: var(--bg-white);
            width: calc(100% - var(--sidebar-width));
            overflow-y: auto;
        }

        /* Footer fixe en bas */
        .footer {
            background: var(--primary-gradient);
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            padding: 14px 20px;
            font-size: 0.85rem;
            font-weight: 500;
            height: var(--footer-height);
            position: fixed;
            bottom: 0;
            left: var(--sidebar-width);
            right: 0;
            z-index: 99;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        .footer p {
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            :root {
                --sidebar-width: 240px;
            }
        }

        @media (max-width: 768px) {
            :root {
                --sidebar-width: 220px;
                --footer-height: 45px;
            }
            
            .main-content {
                padding: 20px;
            }
            
            .footer {
                font-size: 0.8rem;
                padding: 12px 16px;
            }
        }

        @media (max-width: 640px) {
            :root {
                --sidebar-width: 200px;
            }
            
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                width: 100%;
            }
            
            .footer {
                left: 0;
            }
            
            /* Bouton hamburger pour mobile */
            .mobile-menu-toggle {
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 101;
                background: var(--primary-gradient);
                color: white;
                border: none;
                padding: 10px;
                border-radius: var(--radius);
                cursor: pointer;
                display: block;
            }
        }
    </style>
</head>
<body>
    <!-- Bouton hamburger pour mobile -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle" style="display: none;">
        <i class="fas fa-bars"></i>
    </button>

    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            @include('layouts.sidebar')
        </aside>

        <!-- Contenu principal -->
        <main class="main-content" id="mainContent">
            @yield('content')
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer">
        @include('layouts.footer')
    </footer>

    
</body>
</html>