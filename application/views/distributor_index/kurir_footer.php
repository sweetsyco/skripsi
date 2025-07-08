<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    // Tangkap event saat modal edit akan ditampilkan
    $('#editKurirModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);  // Tombol yang memicu modal
        const modal = $(this);
        
        // Ambil data dari atribut tombol
        const id = button.data('id');
        const nama = button.data('nama');
        const email = button.data('email');
        const noTel = button.data('no_telepon');
        const alamat = button.data('alamat');
        const noKendaraan = button.data('no_kendaraan');
        const cakupanArea = button.data('cakupan_area');
        
        console.log("Data yang diambil:", {id, nama, email, noKendaraan, cakupanArea});
        
        // Isi nilai ke form modal
        modal.find('#editIdKurir').val(id);
        modal.find('#editNama').val(nama);
        modal.find('#editEmail').val(email);
        modal.find('#editNo').val(noTel);
        modal.find('#editAlamat').val(alamat);
        modal.find('#editNoKendaraan').val(noKendaraan);
        modal.find('#editCakupanArea').val(cakupanArea);
    });
});
</script>
</body>
</html>