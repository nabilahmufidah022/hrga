<?php Block::put('breadcrumb') ?>
    <ul>
        <li><a href="<?= Backend::url('ppl/hrga/absences') ?>"><?= e(trans('ppl.hrga::lang.models.absence.label_plural')); ?></a></li>
        <li><?= e($this->pageTitle) ?></li>
    </ul>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <?= Form::open(['class' => 'layout']) ?>

       <div style="padding: 10px 50px; margin: 0px 0;">
        <div class="layout-row">
            <?= $this->formRender() ?>
        </div>
    </div>
        <div class="form-buttons" style="padding: 0 50px;">
            <div class="loading-indicator-container">
                <button
                    type="button"
                    data-request="onSave"
                    data-hotkey="ctrl+s, cmd+s"
                    data-load-indicator="<?= e(trans('backend::lang.form.creating_name', ['name' => trans('ppl.hrga::lang.models.absence.label')])); ?>"
                    class="btn btn-primary">
                    <?= e(trans('backend::lang.form.create')); ?>
                </button>
                <button
                    type="button"
                    data-request="onSave"
                    data-request-data="close:1"
                    data-hotkey="ctrl+enter, cmd+enter"
                    data-load-indicator="<?= e(trans('backend::lang.form.creating_name', ['name' => trans('ppl.hrga::lang.models.absence.label')])); ?>"
                    class="btn btn-default">
                    <?= e(trans('backend::lang.form.create_and_close')); ?>
                </button>
                <span class="btn-text">
                    or <a href="<?= Backend::url('ppl/hrga/absences') ?>"><?= e(trans('backend::lang.form.cancel')); ?></a>
                </span>
            </div>
        </div>

    <?= Form::close() ?>

<?php else: ?>

    <p class="flash-message static error"><?= e($this->fatalError) ?></p>
    <p><a href="<?= Backend::url('ppl/hrga/absences') ?>" class="btn btn-default"><?= e(trans('backend::lang.form.return_to_list')); ?></a></p>

<?php endif ?>
