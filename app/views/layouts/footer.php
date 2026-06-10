
            </div><!-- /.content-body -->
        </main><!-- /.main-content -->
    </div><!-- /.app-container -->

    <script>
        /**
         * Toggle del sidebar para dispositivos móviles
         */
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }

        /**
         * Cerrar sidebar al cambiar tamaño de ventana
         */
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebarOverlay');
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }
        });

        /**
         * Auto-ocultar mensajes flash después de 5 segundos
         */
        document.addEventListener('DOMContentLoaded', function() {
            const flashMessages = document.querySelectorAll('.flash-message');
            flashMessages.forEach(function(msg) {
                setTimeout(function() {
                    msg.style.opacity = '0';
                    msg.style.transform = 'translateY(-10px)';
                    msg.style.transition = 'all 0.3s ease';
                    setTimeout(function() {
                        msg.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>
</html>
