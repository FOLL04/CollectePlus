<footer class="footer">
    <p>&copy; {{ date('Y') }} CollectePlus - Tous droits réservés</p>
</footer>

<style>
    /* Variables CSS cohérentes */
    :root {
        --primary-color: #10b981;
        --primary-dark: #059669;
        --primary-light: #d1fae5;
        --text-dark: #1f2937;
        --text-light: #6b7280;
        --bg-light: #f9fafb;
        --bg-white: #ffffff;
        --border-color: #e5e7eb;
        --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        --radius: 8px;
    }

    .footer {
        background: linear-gradient(135deg, #0f766e 0%, #047857 100%);
        color: rgba(255, 255, 255, 0.9);
        text-align: center;
        padding: 14px 20px;
        font-size: 0.85rem;
        font-weight: 500;
        width: 100%;
        position: fixed;
        bottom: 0;
        left: 0;
        z-index: 999;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
    }

    .footer p {
        margin: 0;
        letter-spacing: 0.3px;
    }

    /* Ajustement pour quand la sidebar est présente */
    body.has-sidebar .footer {
        margin-left: 260px;
        width: calc(100% - 260px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .footer {
            font-size: 0.8rem;
            padding: 12px 16px;
        }
        
        body.has-sidebar .footer {
            margin-left: 220px;
            width: calc(100% - 220px);
        }
    }

    @media (max-width: 480px) {
        .footer {
            font-size: 0.75rem;
            padding: 10px 12px;
        }
        
        body.has-sidebar .footer {
            margin-left: 200px;
            width: calc(100% - 200px);
        }
    }
</style>