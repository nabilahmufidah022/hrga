<?php Block::put('breadcrumb') ?>
    <ul>
        <li><a href="<?= Backend::url('ppl/hrga/meetingroomlists') ?>"><?= e(trans('ppl.locale::lang.models.dashboard.listruangrapat.label')); ?></a></li>
        <li><?= e(trans('ppl.locale::lang.models.dashboard.listruangrapat.detail_ruang')) ?></li>
    </ul>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <div class="form-preview">
        <?= $this->formRenderPreview() ?>
    </div>

<?php else: ?>

    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p><a href="<?= Backend::url('ppl/hrga/meetingroomlists') ?>" class="btn btn-default"><?= e(trans('backend::lang.form.return_to_list')); ?></a></p>

<?php endif ?>
