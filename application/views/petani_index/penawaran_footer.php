<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Script untuk validasi form penawaran
    const hargaInput = document.getElementById('hargaInput');
    if (hargaInput) {
        const hargaMaks = <?= isset($permintaan['harga_maks']) ? $permintaan['harga_maks'] : 0 ?>;
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
        if (form) {
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
        }
    }

    // Script untuk modal detail dan hapus
    // Handler untuk tombol detail
    if (document.querySelector('.btn-detail')) {
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function() {
                const row = this.closest('tr');
                if (!row) return;
                
                const status = row.dataset.status;
                const harga = row.dataset.harga;
                
                // Tentukan kelas CSS berdasarkan status
                let statusClass = 'bg-secondary';
                if (status === 'pending') statusClass = 'bg-warning';
                else if (status === 'accepted') statusClass = 'bg-success';
                else if (status === 'rejected') statusClass = 'bg-danger';
                
                // Format harga menjadi Rupiah
                const hargaNum = parseFloat(harga);
                const hargaFormatted = isNaN(hargaNum) 
                    ? 'Rp 0' 
                    : 'Rp ' + hargaNum.toLocaleString('id-ID');
                
                // Isi data ke dalam modal
                if (document.getElementById('detail-komoditas')) {
                    document.getElementById('detail-komoditas').textContent = row.dataset.komoditas || '-';
                }
                if (document.getElementById('detail-distributor')) {
                    document.getElementById('detail-distributor').textContent = row.dataset.distributor || '-';
                }
                if (document.getElementById('detail-jumlah')) {
                    document.getElementById('detail-jumlah').textContent = (row.dataset.jumlah || '0') + ' kg';
                }
                if (document.getElementById('detail-harga')) {
                    document.getElementById('detail-harga').textContent = hargaFormatted;
                }
                
                const statusElement = document.getElementById('detail-status');
                if (statusElement) {
                    statusElement.textContent = status ? status.charAt(0).toUpperCase() + status.slice(1) : '-';
                    statusElement.className = 'badge ' + statusClass;
                }
                
                if (document.getElementById('detail-tanggal')) {
                    document.getElementById('detail-tanggal').textContent = row.dataset.tanggal || '-';
                }
                if (document.getElementById('detail-update')) {
                    document.getElementById('detail-update').textContent = row.dataset.update || '-';
                }
                if (document.getElementById('detail-catatan')) {
                    document.getElementById('detail-catatan').textContent = row.dataset.catatan || 'Tidak ada catatan tambahan';
                }

                // Tampilkan modal
                const modal = document.getElementById('detailModal');
                if (modal) {
                    new bootstrap.Modal(modal).show();
                }
            });
        });
    }

    // Handler untuk tombol hapus
    if (document.querySelector('.btn-delete')) {
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const komoditas = this.dataset.komoditas;
                const distributor = this.dataset.distributor;
                const id = this.dataset.id;
                
                if (document.getElementById('delete-komoditas')) {
                    document.getElementById('delete-komoditas').textContent = komoditas || '';
                }
                if (document.getElementById('delete-distributor')) {
                    document.getElementById('delete-distributor').textContent = distributor || '';
                }
                
                const deleteLink = document.getElementById('confirm-delete');
                if (deleteLink) {
                    deleteLink.href = '<?= site_url('petani/penawaran/delete/') ?>' + id;
                }
                
                const modal = document.getElementById('deleteModal');
                if (modal) {
                    new bootstrap.Modal(modal).show();
                }
            });
        });
    }
});
</script>
</body>
</html>