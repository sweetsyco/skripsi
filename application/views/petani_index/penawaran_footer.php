<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const hargaInput = document.getElementById('hargaInput');
    const hargaMaks = <?= $permintaan['harga_maks'] ?>;
    const form = document.getElementById('penawaranForm');
    const hargaFeedback = document.getElementById('hargaFeedback');
    
    // Real-time validation
    hargaInput.addEventListener('input', function() {
        if (parseFloat(this.value) > hargaMaks) {
            this.classList.add('is-invalid');
            hargaFeedback.style.display = 'block';
        } else {
            this.classList.remove('is-invalid');
            hargaFeedback.style.display = 'none';
        }
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (parseFloat(hargaInput.value) > hargaMaks) {
            e.preventDefault();
            hargaInput.classList.add('is-invalid');
            hargaFeedback.style.display = 'block';
            hargaInput.focus();
            
            // Show alert
            Swal.fire({
                icon: 'error',
                title: 'Harga Melebihi Batas',
                text: 'Harga tidak boleh melebihi Rp ' + hargaMaks.toLocaleString('id-ID'),
                confirmButtonColor: '#28a745'
            });
        }
    });
});
</script>
</body>
</html>