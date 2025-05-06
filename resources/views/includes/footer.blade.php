</main>
</div>
<footer class="bg-gray-800 text-gray-100 py-4">
    <div class="max-w-7xl mx-auto px-4 text-center">
        &copy; {{ date('Y') }} Admin Panel. All Rights Reserved.
    </div>
</footer>
<!-- Custom Toggle Script -->
<script>
    function toggleMenu(menuId) {
        const menu = document.getElementById(menuId);
        const icon = document.getElementById(menuId + 'Icon');

        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            menu.classList.add('flex');
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-up');
        } else {
            menu.classList.add('hidden');
            menu.classList.remove('flex');
            icon.classList.remove('bi-chevron-up');
            icon.classList.add('bi-chevron-down');
        }
    }
</script>
</body>

</html>
