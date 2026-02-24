<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Autentikasi') - Banyu Biru</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}" rel="stylesheet">
</head>
<body class="auth-body">
    <div class="auth-backdrop" aria-hidden="true">
        <span class="orb orb-a"></span>
        <span class="orb orb-b"></span>
        <span class="orb orb-c"></span>
    </div>

    <div class="auth-wrap">
        @yield('content')
    </div>

    @include('partials.alerts')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Password Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            initPasswordToggles();
        });
        
        function initPasswordToggles() {
            const passwordInputs = document.querySelectorAll('input[type="password"]');
            
            passwordInputs.forEach(input => {
                if (input.parentElement.classList.contains('password-toggle-wrapper')) {
                    return;
                }
                
                const wrapper = document.createElement('div');
                wrapper.className = 'password-toggle-wrapper';
                wrapper.style.position = 'relative';
                
                input.parentNode.insertBefore(wrapper, input);
                wrapper.appendChild(input);
                
                const toggleBtn = document.createElement('button');
                toggleBtn.type = 'button';
                toggleBtn.className = 'password-toggle-btn';
                toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
                toggleBtn.setAttribute('aria-label', 'Toggle password visibility');
                toggleBtn.style.cssText = 'position: absolute; right: 0; top: 0; height: 100%; width: 3rem; border: none; background: transparent; color: #6b7280; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: color 0.2s ease; z-index: 10;';
                
                wrapper.appendChild(toggleBtn);
                
                input.style.paddingRight = '3rem';
                
                toggleBtn.addEventListener('click', function() {
                    const type = input.getAttribute('type');
                    if (type === 'password') {
                        input.setAttribute('type', 'text');
                        toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                    } else {
                        input.setAttribute('type', 'password');
                        toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
                    }
                });
                
                toggleBtn.addEventListener('mouseenter', function() {
                    toggleBtn.style.color = '#0d9488';
                });
                
                toggleBtn.addEventListener('mouseleave', function() {
                    toggleBtn.style.color = '#6b7280';
                });
            });
        }
    </script>
</body>
</html>
