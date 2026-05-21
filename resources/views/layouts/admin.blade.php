{{-- Author: Emily Cardona Castañeda --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Admin') — Grow and Bloom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* ── Solo lo que app.css NO tiene: shell del sidebar ── */
        :root {
            --sidebar-w: 230px;
            --topbar-h:  56px;
        }

        /* Shell */
        body { overflow-x: hidden; background: var(--c-bg); }

        /* ── Sidebar ── */
        .adm-sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-w);
            background: var(--c-accent-dk);
            display: flex;
            flex-direction: column;
            z-index: 300;
            overflow-y: auto;
        }

        .adm-sidebar-brand {
            padding: 1.5rem 1.25rem 1.25rem;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .adm-sidebar-brand-name {
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-style: italic;
            font-weight: 600;
            color: #c8e6c2;
            letter-spacing: .02em;
            display: block;
            line-height: 1.1;
        }
        .adm-sidebar-brand-sub {
            font-size: .62rem;
            letter-spacing: .18em;
            text-transform: uppercase;
            color: rgba(255,255,255,.35);
            margin-top: 3px;
            display: block;
        }

        .adm-sidebar-section {
            font-size: .6rem;
            font-weight: 700;
            letter-spacing: .2em;
            text-transform: uppercase;
            color: rgba(255,255,255,.28);
            padding: 1.25rem 1.25rem .35rem;
        }

        .adm-sidebar-link {
            display: flex;
            align-items: center;
            gap: .7rem;
            padding: .6rem 1.25rem;
            font-family: var(--font-body);
            font-size: .8rem;
            font-weight: 500;
            color: rgba(255,255,255,.58);
            border-left: 3px solid transparent;
            transition: all .18s;
            text-decoration: none;
            cursor: pointer;
        }
        .adm-sidebar-link i {
            font-size: .95rem;
            width: 1rem;
            text-align: center;
            flex-shrink: 0;
        }
        .adm-sidebar-link:hover {
            color: rgba(255,255,255,.9);
            background: rgba(255,255,255,.07);
            border-left-color: var(--c-accent);
        }
        .adm-sidebar-link.active {
            color: #fff;
            background: rgba(255,255,255,.12);
            border-left-color: #8aba78;
            font-weight: 600;
        }
        .adm-sidebar-divider {
            height: 1px;
            background: rgba(255,255,255,.08);
            margin: .6rem 1.25rem;
        }
        .adm-sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        /* ── Topbar ── */
        .adm-topbar {
            position: fixed;
            top: 0;
            left: var(--sidebar-w);
            right: 0;
            height: var(--topbar-h);
            background: var(--c-surface);
            border-bottom: 1px solid var(--c-border);
            z-index: 200;
            display: flex;
            align-items: center;
            padding: 0 2rem;
            gap: 1rem;
        }
        .adm-topbar-title {
            flex: 1;
            font-family: var(--font-display);
            font-size: 1rem;
            font-style: italic;
            color: var(--c-accent-dk);
            font-weight: 400;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .adm-topbar-right {
            display: flex;
            align-items: center;
            gap: .75rem;
            flex-shrink: 0;
        }
        .adm-topbar-locale form { display: inline; }
        .adm-topbar-locale button {
            background: transparent;
            border: 1.5px solid var(--c-border);
            color: var(--c-muted);
            font-family: var(--font-body);
            font-size: .68rem;
            font-weight: 700;
            letter-spacing: .1em;
            padding: 3px 9px;
            border-radius: var(--radius);
            cursor: pointer;
            transition: all .15s;
        }
        .adm-topbar-locale button.loc-active,
        .adm-topbar-locale button:hover {
            background: var(--c-accent);
            border-color: var(--c-accent);
            color: #fff;
        }
        .adm-topbar-store {
            font-size: .72rem;
            font-weight: 600;
            color: var(--c-muted);
            border: 1.5px solid var(--c-border);
            padding: 5px 13px;
            border-radius: var(--radius);
            transition: all .15s;
            white-space: nowrap;
            text-decoration: none;
            letter-spacing: .04em;
            display: inline-flex;
            align-items: center;
            gap: .35rem;
        }
        .adm-topbar-store:hover {
            border-color: var(--c-accent);
            color: var(--c-accent-dk);
            background: var(--c-accent-lt);
        }
        .adm-topbar-logout button {
            background: transparent;
            border: none;
            font-family: var(--font-body);
            font-size: .72rem;
            color: var(--c-muted);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: .3rem;
            transition: color .15s;
            padding: 0;
        }
        .adm-topbar-logout button:hover { color: var(--c-danger); }

        /* ── Main shell ── */
        .adm-shell {
            margin-left: var(--sidebar-w);
            padding-top: var(--topbar-h);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* ── Page header (debajo del topbar, dentro del main) ── */
        .adm-page-header {
            background: var(--c-surface);
            border-bottom: 1px solid var(--c-border);
            padding: 1.25rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .adm-page-header h1 {
            font-family: var(--font-display);
            font-size: 1.55rem;
            font-style: italic;
            font-weight: 400;
            color: var(--c-accent-dk);
            margin: 0;
            line-height: 1.15;
        }
        .adm-page-header h1 em { font-weight: 600; }
        .adm-page-header-actions {
            display: flex;
            gap: .65rem;
            align-items: center;
            flex-wrap: wrap;
        }

        /* ── Content ── */
        .adm-content {
            padding: 2rem;
            flex: 1;
        }

        /* ── Flash messages ── */
        .adm-flash { margin-bottom: 1.5rem; }

        /* ── Footer ── */
        .adm-footer {
            padding: .85rem 2rem;
            border-top: 1px solid var(--c-border);
            font-size: .72rem;
            color: var(--c-muted);
            background: var(--c-surface);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* ── Responsive ── */
        @media (max-width: 991px) {
            :root { --sidebar-w: 0px; }
            .adm-sidebar { transform: translateX(-100%); transition: transform .25s; }
            .adm-sidebar.open { transform: translateX(0); --sidebar-w: 230px; }
            .adm-topbar { left: 0; }
            .adm-shell { margin-left: 0; }
            .adm-topbar-toggle {
                display: flex !important;
                align-items: center;
                justify-content: center;
                width: 36px; height: 36px;
                border: 1.5px solid var(--c-border);
                border-radius: var(--radius);
                background: transparent;
                color: var(--c-muted);
                cursor: pointer;
                font-size: 1.1rem;
                flex-shrink: 0;
            }
        }
        @media (min-width: 992px) {
            .adm-topbar-toggle { display: none !important; }
        }
        @media (max-width: 767px) {
            .adm-content { padding: 1.25rem; }
            .adm-page-header { padding: 1rem 1.25rem; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- ── SIDEBAR ─────────────────────────────────────── --}}
<aside class="adm-sidebar" id="admSidebar">

    <div class="adm-sidebar-brand">
        <span class="adm-sidebar-brand-name">Grow & Bloom</span>
        <span class="adm-sidebar-brand-sub">Administración</span>
    </div>

    <nav style="flex:1; padding-bottom:1rem;">

        <span class="adm-sidebar-section">General</span>

        @if(Route::has('admin.index'))
        <a class="adm-sidebar-link {{ request()->routeIs('admin.index') ? 'active' : '' }}"
           href="{{ route('admin.index') }}">
            <i class="bi bi-grid-1x2"></i> Panel
        </a>
        @endif

        <div class="adm-sidebar-divider"></div>
        <span class="adm-sidebar-section">Catálogo</span>

        @if(Route::has('admin.plant.index'))
        <a class="adm-sidebar-link {{ request()->routeIs('admin.plant.*') ? 'active' : '' }}"
           href="{{ route('admin.plant.index') }}">
            <i class="bi bi-flower1"></i> Plantas
        </a>
        @endif

        @if(Route::has('admin.category.index'))
        <a class="adm-sidebar-link {{ request()->routeIs('admin.category.*') ? 'active' : '' }}"
           href="{{ route('admin.category.index') }}">
            <i class="bi bi-tags"></i> Categorías
        </a>
        @endif

        @if(Route::has('admin.service.index'))
        <a class="adm-sidebar-link {{ request()->routeIs('admin.service.*') ? 'active' : '' }}"
           href="{{ route('admin.service.index') }}">
            <i class="bi bi-scissors"></i> Servicios
        </a>
        @endif

        <div class="adm-sidebar-divider"></div>
        <span class="adm-sidebar-section">Operaciones</span>

        @if(Route::has('admin.order.index'))
        <a class="adm-sidebar-link {{ request()->routeIs('admin.order.*') ? 'active' : '' }}"
           href="{{ route('admin.order.index') }}">
            <i class="bi bi-bag-check"></i> Pedidos
        </a>
        @endif

        @if(Route::has('admin.user.index'))
        <a class="adm-sidebar-link {{ request()->routeIs('admin.user.*') ? 'active' : '' }}"
           href="{{ route('admin.user.index') }}">
            <i class="bi bi-people"></i> Usuarios
        </a>
        @endif

        <div class="adm-sidebar-divider"></div>

        @if(Route::has('home.index'))
        <a class="adm-sidebar-link" href="{{ route('home.index') }}">
            <i class="bi bi-arrow-left-circle"></i> Volver a la tienda
        </a>
        @endif

    </nav>

    <div class="adm-sidebar-footer">
        @auth
        @if(Route::has('logout'))
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="
                background:transparent; border:none;
                font-family:var(--font-body); font-size:.72rem;
                color:rgba(255,255,255,.4); cursor:pointer;
                display:inline-flex; align-items:center; gap:.35rem;
                transition:color .15s; padding:0;
            ">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </button>
        </form>
        @endif
        @endauth
    </div>
</aside>

{{-- ── TOPBAR ──────────────────────────────────────── --}}
<header class="adm-topbar">

    <button class="adm-topbar-toggle" id="sidebarToggle" aria-label="Abrir menú">
        <i class="bi bi-list"></i>
    </button>

    <span class="adm-topbar-title">
        @yield('title', 'Panel de administración')
    </span>

    <div class="adm-topbar-right">

        @if(Route::has('home.index'))
        <a class="adm-topbar-store" href="{{ route('home.index') }}">
            <i class="bi bi-arrow-left"></i> Tienda
        </a>
        @endif

        <div class="adm-topbar-locale">
            <form method="POST" action="{{ route('locale.switch') }}">
                @csrf
                <button type="submit" name="locale" value="en"
                    class="{{ app()->getLocale() === 'en' ? 'loc-active' : '' }}">EN</button>
                <button type="submit" name="locale" value="es"
                    class="{{ app()->getLocale() === 'es' ? 'loc-active' : '' }}">ES</button>
            </form>
        </div>

        @auth
        @if(Route::has('logout'))
        <div class="adm-topbar-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <i class="bi bi-box-arrow-right"></i> Salir
                </button>
            </form>
        </div>
        @endif
        @endauth

    </div>
</header>

{{-- ── MAIN SHELL ───────────────────────────────────── --}}
<div class="adm-shell">

    {{-- Page header: título de sección + acciones --}}
    <div class="adm-page-header">
        <h1>@yield('subtitle', 'Dashboard')</h1>
        <div class="adm-page-header-actions">
            @stack('header-actions')
        </div>
    </div>

    <main class="adm-content">

        {{-- Flash messages --}}
        <div class="adm-flash">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
                </div>
            @endif
        </div>

        @yield('content')

    </main>

    <footer class="adm-footer">
        <span>Grow and Bloom · Admin</span>
        <span>{{ date('Y') }}</span>
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
<script>
    // Toggle sidebar en móvil
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('admSidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', () => sidebar.classList.toggle('open'));
        document.addEventListener('click', e => {
            if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }
</script>
@stack('scripts')
</body>
</html>
