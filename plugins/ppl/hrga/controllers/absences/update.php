<?php Block::put('breadcrumb') ?>
    <ul>
        <li><a href="<?= Backend::url('ppl/hrga/absences') ?>"><?= e(trans('ppl.hrga::lang.models.absence.label_plural')) ?></a></li>
        <li><?= e($this->pageTitle) ?></li>
    </ul>
<?php Block::endPut() ?>

<?php if (!$this->fatalError): ?>

    <div style="padding: 10px 50px; margin: 0;">
        <?= Form::open(['class' => 'layout']) ?>

            <div class="layout-row">
                <?= $this->formRender() ?>
            </div>

            <div class="form-buttons" style="margin-top: 20px;">
                <div class="loading-indicator-container">

                    <button
                        type="button"
                        data-request="onSave"
                        data-request-data="redirect:0"
                        data-hotkey="ctrl+s, cmd+s"
                        data-load-indicator="<?= e(trans('backend::lang.form.saving_name', ['name' => trans('ppl.hrga::lang.models.absence.label')])) ?>"
                        class="btn btn-primary">
                        <?= e(trans('backend::lang.form.save')) ?>
                    </button>

                    <button
                        type="button"
                        data-request="onSave"
                        data-request-data="close:1"
                        data-hotkey="ctrl+enter, cmd+enter"
                        data-load-indicator="<?= e(trans('backend::lang.form.saving_name', ['name' => trans('ppl.hrga::lang.models.absence.label')])) ?>"
                        class="btn btn-default">
                        <?= e(trans('backend::lang.form.save_and_close')) ?>
                    </button>

                    <button
                        type="button"
                        class="wn-icon-trash-o btn-icon danger pull-right"
                        data-request="onDelete"
                        data-load-indicator="<?= e(trans('backend::lang.form.deleting_name', ['name' => trans('ppl.hrga::lang.models.absence.label')])) ?>"
                        data-request-confirm="<?= e(trans('backend::lang.form.confirm_delete')) ?>">
                    </button>

                    <span class="btn-text" style="margin-left: 10px;">
                        or <a href="<?= Backend::url('ppl/hrga/absences') ?>"><?= e(trans('backend::lang.form.cancel')) ?></a>
                    </span>

                </div>
            </div>

        <?= Form::close() ?>
    </div>

<?php else: ?>

    <div style="padding: 10px 50px; margin: 0;">
        <p class="flash-message static error"><?= e($this->fatalError) ?></p>
        <p><a href="<?= Backend::url('ppl/hrga/absences') ?>" class="btn btn-default"><?= e(trans('backend::lang.form.return_to_list')) ?></a></p>
    </div>

<?php endif ?>