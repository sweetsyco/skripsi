<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Animasi sederhana untuk stat card
        document.addEventListener('DOMContentLoaded', function() {
            // Animasi sederhana untuk statistik
            const statCards = document.querySelectorAll('.col-md-4 .card');
            statCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.transform = 'translateY(0)';
                    card.style.opacity = '1';
                }, index * 200);
                
                // Set initial state
                card.style.transform = 'translateY(20px)';
                card.style.opacity = '0';
                card.style.transition = 'transform 0.5s, opacity 0.5s';
            });
$(document).ready(function() {
    // Inisialisasi tooltip
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Refresh data
    $('#refresh-btn').click(function() {
        location.reload();
    });
    
    // Filter status
    $('#status-filter').change(function() {
        const status = $(this).val();
        if(status === 'all') {
            $('#penawaran-table tbody tr').show();
        } else {
            $('#penawaran-table tbody tr').each(function() {
                const rowStatus = $(this).data('status');
                $(this).toggle(rowStatus === status);
            });
        }
    });
    
    // Pencarian
    $('#search-btn').click(searchPenawaran);
    $('#search-input').keypress(function(e) {
        if(e.which === 13) searchPenawaran();
    });
    
    function searchPenawaran() {
        const term = $('#search-input').val().toLowerCase();
        if(term === '') {
            $('#penawaran-table tbody tr').show();
            return;
        }
        
        $('#penawaran-table tbody tr').each(function() {
            const rowText = $(this).text().toLowerCase();
            $(this).toggle(rowText.indexOf(term) > -1);
        });
    }
    
    // Sorting
    $('#sort-date-desc').click(function() {
        sortTable(true);
        $(this).addClass('active');
        $('#sort-date-asc').removeClass('active');
    });
    
    $('#sort-date-asc').click(function() {
        sortTable(false);
        $(this).addClass('active');
        $('#sort-date-desc').removeClass('active');
    });
    
    function sortTable(desc = true) {
        const rows = $('#penawaran-table tbody tr').get();
        rows.sort(function(a, b) {
            const dateA = new Date($(a).find('td:eq(7)').text().trim());
            const dateB = new Date($(b).find('td:eq(7)').text().trim());
            return desc ? dateB - dateA : dateA - dateB;
        });
        
        $.each(rows, function(index, row) {
            $('#penawaran-table tbody').append(row);
        });
    }
    
    // Modal Detail
    $('.btn-detail').click(function() {
        const id = $(this).data('id');
        $('#detailModal').modal('show');
        $('#detail-loading').show();
        $('#detail-content').hide();
        $('#detail-edit-link').hide();
        
        // Simulasi AJAX - di implementasi nyata ganti dengan AJAX ke server
        setTimeout(() => {
            const row = $(`tr[data-id="${id}"]`);
            if(row.length) {
                $('#detail-komoditas').text(row.find('td:eq(0) span').text());
                $('#detail-distributor').text(row.find('td:eq(1)').text());
                $('#detail-jumlah').text(row.find('td:eq(2)').text());
                $('#detail-harga').text(row.find('td:eq(3)').text());
                $('#detail-total').text(row.find('td:eq(4)').text());
                $('#detail-status').html(row.find('td:eq(6)').html());
                $('#detail-tanggal').text(row.find('td:eq(7)').text());
                $('#detail-sisa').html(row.find('td:eq(5)').html());
                
                // Tampilkan tombol edit jika status pending
                if(row.data('status') === 'pending') {
                    $('#detail-edit-link').attr('href', `<?= site_url('petani/penawaran/update_view/') ?>${id}`).show();
                }
            }
            
            $('#detail-loading').hide();
            $('#detail-content').show();
        }, 800);
    });
    
    // Modal Hapus
    $('.btn-delete').click(function() {
        const id = $(this).data('id');
        const komoditas = $(this).data('komoditas');
        const distributor = $(this).data('distributor');
        
        $('#delete-komoditas').text(komoditas);
        $('#delete-distributor').text(distributor);
        $('#confirm-delete').attr('href', `<?= site_url('petani/penawaran/delete/') ?>${id}`);
        $('#deleteModal').modal('show');
    });
    
    // Responsif tabel
    function checkTableResponsive() {
        if($(window).width() < 992) {
            if(!$('#penawaran-table').hasClass('table-responsive-sm')) {
                $('#penawaran-table').addClass('table-responsive-sm');
            }
        } else {
            $('#penawaran-table').removeClass('table-responsive-sm');
        }
    }
    
    checkTableResponsive();
    $(window).resize(checkTableResponsive);
});
        });
    </script>
</body>
</html>