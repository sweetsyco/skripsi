 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       $(document).ready(function() {
            // Toggle between view and edit mode
            $('#toggleEdit').click(function() {
                $('#viewProfile').slideUp(300, function() {
                    $('#editProfile').slideDown(300);
                });
            });
            
            $('#cancelEdit').click(function() {
                $('#editProfile').slideUp(300, function() {
                    $('#viewProfile').slideDown(300);
                });
            });
            
            // Jika ada error, tampilkan form edit
            <?php if(validation_errors() || $this->session->flashdata('error')): ?>
                $('#viewProfile').hide();
                $('#editProfile').show();
            <?php endif; ?>
        });
    </script>
</body>
</html>