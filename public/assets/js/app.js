/**
 * Chirakama Main App UI Script
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Sidebar Toggle Mobile
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', (e) => {
            e.preventDefault();
            sidebar.classList.toggle('show');
        });
    }

    // 2. Initialize Bootstrap Tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // 3. Handle Logout Form/Action
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            
            // Visual feedback
            const originalText = logoutBtn.innerHTML;
            logoutBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Cerrando...';
            
            try {
                // await ApiService.logout(); // Descomentar cuando la API esté enlazada
                localStorage.removeItem('chirakama_token');
                
                // Simular redirección
                setTimeout(() => {
                    window.location.href = '/login'; // O usar ruteo Blade
                }, 500);
            } catch (error) {
                console.error("Logout error", error);
                logoutBtn.innerHTML = originalText;
            }
        });
    }

    // 4. Helper for showing notifications (Toast)
    window.showToast = function(message, type = 'success') {
        // En una app real, podrías crear un Toast de Bootstrap dinámicamente
        alert(message); // Placeholder
    };
});
