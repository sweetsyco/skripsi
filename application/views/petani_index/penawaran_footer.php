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

   
    if (document.querySelector('.btn-detail')) {
        document.querySelectorAll('.btn-detail').forEach(button => {
            button.addEventListener('click', function() {
                const idPenawaran = this.getAttribute('data-id');
                const button = this;
                console.log(idPenawaran);
                
                // Tampilkan loading
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                button.disabled = true;
                
                // AJAX request
                fetch(`<?= site_url('petani/penawaran/get_detail_json/') ?>${idPenawaran}`)
                    .then(response => response.json())
                    .then(data => {
                        // Kembalikan tombol ke semula
                        button.innerHTML = '<i class="fas fa-eye"></i>';
                        button.disabled = false;
                        
                        if (data.success) {
                            const penawaran = data.data;
                            
                            // Tentukan kelas CSS berdasarkan status
                            let statusClass = 'bg-secondary';
                            if (penawaran.status === 'pending') statusClass = 'bg-warning';
                            else if (penawaran.status === 'accepted') statusClass = 'bg-success';
                            else if (penawaran.status === 'rejected') statusClass = 'bg-danger';
                            
                            // Isi data ke dalam modal
                            document.getElementById('detail-komoditas').textContent = penawaran.komoditas;
                            document.getElementById('detail-distributor').textContent = penawaran.distributor;
                            document.getElementById('detail-jumlah').textContent = penawaran.jumlah;
                            document.getElementById('detail-harga').textContent = penawaran.harga;
                            
                            const statusElement = document.getElementById('detail-status');
                            statusElement.textContent = penawaran.status.charAt(0).toUpperCase() + penawaran.status.slice(1);
                            statusElement.className = 'badge ' + statusClass;
                            
                            document.getElementById('detail-tanggal').textContent = penawaran.tanggal;

                            // Tampilkan modal
                            const modal = new bootstrap.Modal(document.getElementById('detailModal'));
                            modal.show();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.error || 'Gagal mengambil data detail'
                            });
                        }
                    })
                    .catch(error => {
                        button.innerHTML = '<i class="fas fa-eye"></i>';
                        button.disabled = false;
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat mengambil data'
                        });
                    });
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
   
    function formatRupiah(angka) {
        if (angka === undefined || angka === null || isNaN(angka)) {
            return 'Rp 0';
        }
        return 'Rp ' + parseFloat(angka).toLocaleString('id-ID');
    }

    
    if (document.querySelector('.btn-edit')) {
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const komoditas = this.dataset.komoditas;
                const distributor = this.dataset.distributor;
                const hargaMax = this.dataset.harga_max; 
                const jumlah = this.dataset.jumlah;
                const harga = this.dataset.harga;
                
                document.getElementById('edit-id').value = id;
                document.getElementById('edit-komoditas').value = komoditas;
                document.getElementById('edit-distributor').value = distributor;
                document.getElementById('edit-hargamaks').value = hargaMax;
                document.getElementById('edit-jumlah').value = jumlah;
                document.getElementById('edit-harga').value = harga;
                console.log(hargaMax);
                
                
                const hargaInput = document.getElementById('edit-harga');
                hargaInput.setAttribute('max', hargaMax);
                
               
                const oldInfo = document.getElementById('harga-max-info');
                if (oldInfo) oldInfo.remove();
                
                // Tambahkan info baru
                const infoElement = document.createElement('small');
                infoElement.id = 'harga-max-info';
                infoElement.className = 'form-text text-muted';
                infoElement.textContent = `Harga maksimal: ${formatRupiah(hargaMax)}`;
                hargaInput.parentNode.appendChild(infoElement);
                
                // Tampilkan modal edit
                const editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            });
        });
    }

    // Validasi real-time pada input harga
    const editHarga = document.getElementById('edit-harga');
    if (editHarga) {
        editHarga.addEventListener('input', function() {
            const hargaMax = parseFloat(this.getAttribute('max'));
            const hargaInput = parseFloat(this.value) || 0;
            const infoElement = document.getElementById('harga-max-info');
            
            if (hargaInput > hargaMax) {
                this.classList.add('is-invalid');
                if (infoElement) infoElement.classList.add('text-danger');
            } else {
                this.classList.remove('is-invalid');
                if (infoElement) infoElement.classList.remove('text-danger');
            }
        });
    }

  
    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            const hargaInput = document.getElementById('edit-harga');
            const hargaMax = parseFloat(hargaInput.getAttribute('max'));
            const hargaValue = parseFloat(hargaInput.value) || 0;
            
            if (hargaValue > hargaMax) {
                e.preventDefault();
                
                
                Swal.fire({
                    icon: 'error',
                    title: 'Harga Melebihi Batas',
                    text: `Harga tidak boleh melebihi ${formatRupiah(hargaMax)}`,
                    confirmButtonColor: '#28a745'
                });
                
                
                hargaInput.focus();
            }
        });
    }
});
</script>
</body>
</html>