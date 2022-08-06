<div class="fade modal modal-confirm-delete" id="modal_confirm_delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="text-center">
                    {{ trans('core::admin.delete_confirm') }}
                </div>
            </div>
            <!-- Modal footer -->
            <form action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                        {{ trans('core::admin.button.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-danger btn-sm">
                        {{ trans('core::admin.button.confirm') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>