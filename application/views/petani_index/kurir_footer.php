<script>
$(document).ready(function() {
    // Tangani klik tombol detail
    $('.btn-detail').on('click', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        $('#detailPenugasanModal').modal('show');
        
        // Load data via AJAX
        $.ajax({
            url: '<?= site_url("petani/kurir/get_detail/") ?>' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    var data = response.data;
                    var html = `
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Komoditas</label>
                                    <p class="fs-5">
                                        <i class="fas fa-seedling me-2 text-success"></i>
                                        ${data.nama_komoditas}
                                    </p>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted">Distributor</label>
                                    <p class="fs-5">${data.nama_perusahaan}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted">Kurir</label>
                                    <p class="fs-5">${data.nama_kurir}</p>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label text-muted">Jumlah</label>
                                    <p class="fs-5">${data.jumlah} kg</p>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted">Status</label>
                                    <p>${getStatusBadge(data.status)}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label text-muted">Tanggal Penugasan</label>
                                    <p class="fs-5">${formatDate(data.ditugaskan_pada)}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <label class="form-label text-muted">Catatan</label>
                            <p>${data.catatan || '<em class="text-muted">Tidak ada catatan</em>'}</p>
                        </div>
                    `;
                    $('#modal-body-content').html(html);
                } else {
                    $('#modal-body-content').html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function() {
                $('#modal-body-content').html('<div class="alert alert-danger">Terjadi kesalahan saat memuat data</div>');
            }
        });
    });
    
    function getStatusBadge(status) {
        let badgeClass = '';
        switch(status) {
            case 'pending': badgeClass = 'bg-warning'; break;
            case 'approved': badgeClass = 'bg-success'; break;
            case 'rejected': badgeClass = 'bg-danger'; break;
            default: badgeClass = 'bg-secondary';
        }
        return `<span class="badge ${badgeClass} fs-6 p-2">${status.charAt(0).toUpperCase() + status.slice(1)}</span>`;
    }
    
    function formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('id-ID', { 
            day: '2-digit', 
            month: 'long', 
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
});
</script>