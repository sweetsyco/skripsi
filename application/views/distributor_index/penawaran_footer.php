<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.btn-accept', function(e) {
    e.preventDefault();
    console.log('Tombol Terima diklik!');
    const id = $(this).data('id');
    console.log('ID Penawaran:', id);
    updateStatus(id, 'accepted');
});

$(document).on('click', '.btn-reject', function(e) {
    e.preventDefault();
    console.log('Tombol Tolak diklik!');
    const id = $(this).data('id');
    console.log('ID Penawaran:', id);
    updateStatus(id, 'rejected');
});

function updateStatus(id, status) {
    console.log('Memanggil updateStatus dengan ID:', id, 'Status:', status);
    
    if(confirm('Apakah Anda yakin ingin mengubah status penawaran?')) {
        console.log('Konfirmasi diterima, mengirim AJAX...');
        
        $.ajax({
            url: '<?= site_url('distributor/penawaran/update_status') ?>',
            method: 'POST',
            data: {
                id_penawaran: id,
                status_baru: status,
                '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
            },
            dataType: 'json',
            success: function(response) {
                console.log('Respon dari server:', response);
                if(response.sukses) {
                    alert('Status berhasil diperbarui!');
                    location.reload();
                } else {
                    alert('Error: ' + response.pesan);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                alert('Terjadi kesalahan pada server. Status: ' + xhr.status);
            }
        });
    }
}
    </script>
</body>
</html>