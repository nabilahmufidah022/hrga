<?php Block::put('breadcrumb') ?>
    <ul>
        <li><a href="<?= Backend::url('ppl/hrga/userroomorders') ?>"><?= e(trans('ppl.locale::lang.models.home.peminjamanruang.label')); ?></a></li>
        <li><?= e($this->pageTitle) ?></li>
    </ul>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <div style="margin-bottom: 10px;" >
    <h2> <?= $ruangan->room_name ?></h2>

    <div style="margin-bottom: 10px;" >
    <h2> <?= $datestring ?></h2>
</div>
<br>
<div style="margin-bottom: 10px;" >
   
</div>
<br>

    <?= Form::open(['class' => 'layout']) ?>

        <div class="layout-row">
            <?= $this->formRender() ?>
        </div>

        <div class="form-buttons">
            <div class="loading-indicator-container">
                <button
                    type="button"
                    data-request="onOrder"
                    data-request-data="merapat_id:<?= $ruangan->id ?>, dateStr:'<?= $dateStr ?>'"
                    data-hotkey="ctrl+enter, cmd+enter"
                    data-load-indicator="<?= e(trans('backend::lang.form.creating_name', ['name' => trans('ppl.locale::lang.models.home.peminjamanruang.form.unit_kerja')])); ?>"
                    class="btn btn-primary">
                    <?= e(trans('ppl.locale::lang.button.buat')); ?>
                </button>
            </div>
        </div>

    <?= Form::close() ?>

<?php else: ?>

    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p><a href="<?= Backend::url('ppl/hrga/userroomorders') ?>" class="btn btn-default"><?= e(trans('backend::lang.form.return_to_list')); ?></a></p>

<?php endif ?>
