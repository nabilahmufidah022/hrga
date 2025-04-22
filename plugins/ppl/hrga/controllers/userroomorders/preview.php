
<?php Block::put('breadcrumb') ?>
    <ul>
        <li><a href="<?= Backend::url('ppl/hrga/userroomorders') ?>"><?= e(trans('ppl.locale::lang.models.home.peminjamanruang.label')); ?></a></li>
        <li><?= e(trans('ppl.locale::lang.models.home.peminjamanruang.detail')); ?></li>
    </ul>

<?php Block::endPut() ?>

<?php if( $form == '1' && $tanggalmulai > '0' ):?>
<a data-toggle="modal" href="#content-confirmation" style="background-color:red; color: white;" class="btn">Batal</a>

<div class="control-popup modal fade" id="content-confirmation" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Masukkan Alasan Pembatalan Peminjaman Ruang Rapat!!!!! </h4>
            </div>
            <div class="modal-body">
                <label for="">Pembatalan Peminjaman Ruang Rapat</label><br>
                <!-- <input type="text" name="alasan" style="width:-webkit-fill-available;"> -->
                <textarea name="alasan" style="width:-webkit-fill-available; height:150px; color: black;"></textarea> 
            </div>
            <div class="modal-footer" style="margin-top:10px;">
                <button type="button" class="btn btn-default" aria-hidden="true" style="background-color:red; color:white;" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" 
                 data-dismiss="modal"
                 data-request="onBatal" 
                 data-request-data="merapat_id:<?= $formModel->id ?>"
                 data-attach-loading>Simpan</button>
            </div>
            </form>
        </div>
    </div>
    </div>
<br>
<br>
<?php endif; ?>

<?php if (!$this->fatalError): ?>

    <div class="form-preview">
        
        <?= $this->formRenderPreview() ?>
    </div>

<?php else: ?>

    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p><a href="<?= Backend::url('ppl/hrga/userroomorders') ?>" class="btn btn-default"><?= e(trans('backend::lang.form.return_to_list')); ?></a></p>

<?php endif ?>
