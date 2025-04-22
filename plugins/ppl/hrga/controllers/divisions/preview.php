<?php Block::put('breadcrumb') ?>
    <ul>
        <li><a href="<?= Backend::url('ppl/hrga/divisions') ?>"><?= e(trans('ppl.locale::lang.models.dashboard.divisi.label_plural')); ?></a></li>
        <li><?= e(trans('ppl.locale::lang.models.dashboard.divisi.viewform')) ?></li>
    </ul>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <div class="form-preview">
        <?= $this->formRenderPreview() ?>
    </div>

<?php else: ?>

    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p><a href="<?= Backend::url('ppl/hrga/divisions') ?>" class="btn btn-default"><?= e(trans('backend::lang.form.return_to_list')); ?></a></p>

<?php endif ?>
