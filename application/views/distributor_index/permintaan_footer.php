<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
        
            
            // Konfirmasi sebelum menutup permintaan
            const closeButtons = document.querySelectorAll('.btn-close');
            closeButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    if (!confirm('Apakah Anda yakin ingin menutup permintaan ini? Penawaran yang sedang berjalan mungkin akan terpengaruh.')) {
                        e.preventDefault();
                    }
                });
            });
    

        $(document).ready(function() {
            $('.btn-view').click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#modalContent').html(`
                    <div class="text-center">
                        <i class="fas fa-spinner fa-spin fa-3x"></i>
                        <p>Memuat data...</p>
                    </div>
                `);
                
                $.ajax({
                    url: 'http://localhost/skripsi/distributor/permintaan/detail/' + id,
                    type: 'GET',
                    success: function(response) {
                        if (response.error) {
                            $('#modalContent').html(`
                                <div class="alert alert-danger">
                                    ${response.error}
                                </div>
                            `);
                            return;
                        }
                        
                        var permintaan = response.permintaan;
                        var penawaran = response.penawaran;
                        var total_diterima = response.total_diterima;
                        var progres = (total_diterima / permintaan.jumlah * 100).toFixed(0);
                        
                        var html = `
                            <div class="mb-3">
                                <h4>${permintaan.nama_komoditas}</h4>
                                <p class="text-muted">${formatTanggal(permintaan.dibuat_pada)}</p>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <strong>Detail Permintaan</strong>
                                        </div>
                                        <div class="card-body">
                                            <table class="table">
                                                <tr>
                                                    <th>Jumlah</th>
                                                    <td>${formatNumber(permintaan.jumlah)} ${permintaan.satuan}</td>
                                                </tr>
                                                <tr>
                                                    <th>Harga Maks</th>
                                                    <td>Rp ${formatRupiah(permintaan.harga_maks)}/${permintaan.satuan}</td>
                                                </tr>
                                                <tr>
                                                    <th>Sisa Kebutuhan</th>
                                                    <td>${formatNumber(permintaan.sisa_permintaan)} ${permintaan.satuan}</td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>
                                                        <span class="badge ${permintaan.status == 'open' ? 'bg-success' : 'bg-secondary'}">
                                                            ${permintaan.status == 'open' ? 'Aktif' : 'Selesai'}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <strong>Statistik Pemenuhan</strong>
                                        </div>
                                        <div class="card-body">
                                            <p>Total Diterima: <strong>${formatNumber(total_diterima)} ${permintaan.satuan}</strong></p>
                                            <div class="progress mb-3" style="height: 25px;">
                                                <div class="progress-bar bg-success" 
                                                    role="progressbar" 
                                                    style="width: ${progres}%" 
                                                    aria-valuenow="${progres}" 
                                                    aria-valuemin="0" 
                                                    aria-valuemax="100">
                                                    ${progres}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        if (penawaran.length > 0) {
                            html += `
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <strong>Daftar Penawaran</strong>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Petani</th>
                                                    <th>Jumlah</th>
                                                    <th>Harga</th>
                                                    <th>Status</th>
                                                    <th>Tanggal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                            `;
                            
                            penawaran.forEach(function(p) {
                                var badgeClass = '';
                                var statusText = '';
                                
                                if(p.status == 'accepted') {
                                    badgeClass = 'bg-success';
                                    statusText = 'Diterima';
                                } else if(p.status == 'rejected') {
                                    badgeClass = 'bg-danger';
                                    statusText = 'Ditolak';
                                } else {
                                    badgeClass = 'bg-warning';
                                    statusText = 'Menunggu';
                                }
                                
                                html += `
                                <tr>
                                    <td>${p.nama_petani}</td>
                                    <td>${formatNumber(p.jumlah_penawaran)} ${permintaan.satuan}</td>
                                    <td>Rp ${formatRupiah(p.harga)}/${permintaan.satuan}</td>
                                    <td><span class="badge ${badgeClass}">${statusText}</span></td>
                                    <td>${formatTanggal(p.dibuat_pada)}</td>
                                </tr>
                                `;
                            });
                            
                            html += `
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            `;
                        } else {
                            html += `<div class="alert alert-info">Belum ada penawaran</div>`;
                        }
                        
                        $('#modalContent').html(html);
                    }
                });
                
                $('#detailModal').modal('show');
            });
            
            function formatTanggal(dateString) {
                const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                return new Date(dateString).toLocaleDateString('id-ID', options);
            }
            
            function formatRupiah(angka) {
                
                return angka ? angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : 0;
            }
            
            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        });
    </script>
</body>
</html>