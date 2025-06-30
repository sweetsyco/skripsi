<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Animasi sederhana untuk stat card
        document.addEventListener('DOMContentLoaded', function() {
            const statCards = document.querySelectorAll('.stat-card');
            statCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });
            
            // Atur opacity awal untuk animasi
            statCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'opacity 0.5s, transform 0.5s';
            });
        });
        

        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi pencarian
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('tbody tr');
            
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    
                    tableRows.forEach(row => {
                        const rowText = row.textContent.toLowerCase();
                        if (rowText.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
        const komoditasData = [
        <?php foreach ($komoditas as $k): ?>
        {
            id_komoditas: '<?php echo $k->id_komoditas; ?>',
            nama_komoditas: '<?php echo addslashes($k->nama_komoditas); ?>',
            satuan: '<?php echo addslashes($k->satuan); ?>'
        },
        <?php endforeach; ?>
    ];
    
        
        document.addEventListener('DOMContentLoaded', function() {
            // Elemen form
            const komoditasSelect = document.getElementById('id_komoditas');
            const jumlahInput = document.getElementById('jumlah');
            const hargaInput = document.getElementById('harga_maks');
            
            // Elemen detail
            const detailNama = document.getElementById('detail-nama');
            const detailSatuan = document.getElementById('detail-satuan');
            const detailTotal = document.getElementById('detail-total');
            
            // Fungsi untuk update detail
            function updateDetail() {
                const selectedKomoditasId = komoditasSelect.value;
                const jumlah = parseFloat(jumlahInput.value) || 0;
                const harga = parseFloat(hargaInput.value) || 0;
                
                // Cari komoditas yang dipilih
                const selectedKomoditas = komoditasData.find(k => k.id_komoditas == selectedKomoditasId);
                
                if (selectedKomoditas) {
                    detailNama.textContent = selectedKomoditas.nama_komoditas;
                    detailSatuan.textContent = selectedKomoditas.satuan;
                } else {
                    detailNama.textContent = '-';
                    detailSatuan.textContent = '-';
                }
                
                // Hitung total nilai permintaan
                const total = jumlah * harga;
                if (total > 0) {
                    detailTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
                } else {
                    detailTotal.textContent = 'Rp 0';
                }
            }
            
            // Panggil saat halaman dimuat
            updateDetail();
            
            // Tambahkan event listeners
            komoditasSelect.addEventListener('change', updateDetail);
            jumlahInput.addEventListener('input', updateDetail);
            hargaInput.addEventListener('input', updateDetail);
            
            // Validasi form sebelum submit
            document.querySelector('form').addEventListener('submit', function(e) {
                if (komoditasSelect.value === '') {
                    e.preventDefault();
                    alert('Pilih komoditas terlebih dahulu');
                    komoditasSelect.focus();
                }
            });
        });
    </script>
</body>
</html>