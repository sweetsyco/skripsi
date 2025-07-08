<?php if(isset($error)) echo '<div class="alert alert-danger">'.$error.'</div>'; 
?>
<div class="main-content">
    <div class="header">
        <h1>Upload Bukti Pengiriman</h1>
    </div>

    <div class="verification-form">
        <h4>Penugasan #<?= $penugasan['id_penugasan']; ?></h4>
        
        <?= form_open_multipart('kurir/verifikasi/upload_bukti/'.$penugasan['id_penugasan']); ?>
            <div class="form-group">
                <label>Foto Bukti</label>
                <div class="verification-image" id="image-preview">
                    <i class="fas fa-camera"></i>
                    <span>Klik untuk upload foto</span>
                </div>
                <input type="file" name="foto_bukti" id="foto_bukti" style="display: none;" required>
                <small class="text-muted">Format: gif, jpg, jpeg, png. Max 2MB.</small>
                <?= form_error('foto_bukti', '<small class="text-danger">', '</small>'); ?>
            </div>
            
            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control" rows="3"><?= set_value('catatan'); ?></textarea>
            </div>
            <div class="button-group">
                <button type="submit" class="btn btn-upload">
                    <i class="fas fa-upload"></i> Upload Bukti
                </button>
                <a href="<?= base_url('kurir/verifikasi'); ?>" class="btn btn-batal">
                    <i class="fas fa-times"></i> Batal
                </a>
            </div>
        <?= form_close(); ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        // PERBAIKAN: Gunakan event delegation dan hentikan propagasi
        $(document).on('click', '#image-preview', function(e) {
            e.stopPropagation(); // Hentikan propagasi event
            $('#foto_bukti').click();
        });

        $('#foto_bukti').change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#image-preview').css({
                        'background-image': 'url(' + e.target.result + ')',
                        'background-size': 'cover',
                        'background-position': 'center'
                    });
                    $('#image-preview i, #image-preview span').hide();
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>