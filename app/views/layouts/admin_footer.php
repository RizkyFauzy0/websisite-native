        </main>
    </div>
    
    <!-- Overlay for mobile sidebar -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-cloak
         class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden"></div>
    
    <script>
        // Auto-close flash messages
        setTimeout(() => {
            const flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                flashMessage.style.display = 'none';
            }
        }, 5000);
    </script>
</body>
</html>
