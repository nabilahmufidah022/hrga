<div data-control="toolbar">
    <a
        href="<?= Backend::url('ppl/hrga/meetingroomlists/create') ?>"
        class="btn btn-primary wn-icon-plus">
        <?= e(trans('ppl.locale::lang.models.dashboard.listruangrapat.btn_tmbh')); ?>
    </a>

        <button
            class="btn btn-danger wn-icon-trash-o"
            disabled="disabled"
            onclick="$(this).data('request-data', { checked: $('.control-list').listWidget('getChecked') })"
            data-request="onDelete"
            data-request-confirm="<?= e(trans('ppl.locale::lang.models.dashboard.listruangrapat.alert_delete')); ?>"
            data-trigger-action="enable"
            data-trigger=".control-list input[type=checkbox]"
            data-trigger-condition="checked"
            data-request-success="$(this).prop('disabled', 'disabled')"
            data-stripe-load-indicator>
            <?= e(trans('backend::lang.list.delete_selected')); ?>
        </button>
</div>
