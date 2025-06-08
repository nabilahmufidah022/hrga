<?php Block::put('breadcrumb') ?>
    <ul>
        <li><a href="<?= Backend::url('ppl/hrga/permissions') ?>"><?= e(trans('List Izin')); ?></a></li>
        <li><?= e(trans('backend::lang.form.create_title', ['name' => trans('Edit Ajukan Izin')])); ?></</li>
    </ul>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <?= Form::open(['class' => 'layout']) ?>

        <div class="layout-row">
            <?= $this->formRender() ?>
        </div>

        <div class="form-buttons">
            <div class="loading-indicator-container">
                <button
                    type="button"
                    data-request="onSave"
                    data-request-data="close:1"
                    data-hotkey="ctrl+enter, cmd+enter"
                    data-load-indicator="<?= e(trans('backend::lang.form.saving_name', ['name' => trans('ppl.hrga::lang.models.deviceorder.label')])); ?>"
                    class="btn btn-primary">
                    <?= e(trans('ppl.locale::lang.models.form-pengajuan.form-perangkat.form.btn_setuju')); ?>
                </button>
                <a data-toggle="modal" href="#content-confirmation" style="background-color:red; color: white;" class="btn">Tolak</a>
            </div>
        </div>

    <?= Form::close() ?>

    <div class="control-popup modal fade" id="content-confirmation" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Masukkan Alasan Penolakan Pengajuan Perangkat!</h4>
                </div>
                <div class="modal-body">
                    <label for="">Alasan Penolakan Permohonan</label><br>
                    <!-- <input type="text" name="alasan" style="width:-webkit-fill-available;"> -->
                    <textarea name="alasan" style="width:-webkit-fill-available; height:150px;"></textarea> 
                </div>
                <div class="modal-footer" style="margin-top:10px;">
                    <button type="button" class="btn btn-default" aria-hidden="true" style="background-color:red; color:white;" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" 
                    data-dismiss="modal"
                    data-request="onSimpanTolak" 
                    data-request-data="sick_id:<?= $formModel->id ?>"
                    data-attach-loading>Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<?php else: ?>

    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p><a href="<?= Backend::url('ppl/hrga/permissions') ?>" class="btn btn-default"><?= e(trans('backend::lang.form.return_to_list')); ?></a></p>

<?php endif ?>
