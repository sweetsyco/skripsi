<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
            
            // Simulasi upload gambar
            $('.verification-image').click(function() {
                alert('Membuka dialog pilih gambar');
            });
        });
    </script>
</body>
</html>
