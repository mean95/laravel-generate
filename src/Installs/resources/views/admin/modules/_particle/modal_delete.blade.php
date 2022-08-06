 <!-- Modal confirm delete module -->
 <div class="modal fade" id="modal_delete_module">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ trans('core::module.delete_module') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>{{ trans('core::module.confirm_delete') }}
                         <b class="module_name_delete text-danger"></b>
                    ?</p>
                    <p>{{ trans('core::module.list_delete') }}</p>
                    <div id="moduleDeleteFiles">
                        <ul>
                            <li>platform/src/app/Http/Controllers/Admin/<span class="module_name_delete"></span>Controller.php</li>
                            <li>platform/src/app/Http/Requests/Admin/<span class="module_name_delete"></span>Request.php</li>
                            <li>platform/src/app/Models/<span class="module_name_delete"></span>.php</li>
                            <li>platform/src/app/DataTables/<span class="module_name_delete"></span>DataTable.php</li>
                            <li>platform/src/app/Repositories/Contracts/<span class="module_name_delete"></span>Interface.php</li>
                            <li>platform/src/app/Repositories/Eloquent/<span class="module_name_delete"></span>Eloquent.php</li>
                            <li>platform/src/resources/view/admin/<span class="db_name_delete"></span></li>
                        </ul>
                    </div>
                    <p class="text-danger">{{ trans('core::module.note_delete_migrate') }}</p>
                </div>
                <div class="modal-footer pull-right">
                    <button type="submit" class="btn btn-info btn-sm">
                        {{ trans('core::admin.button.confirm') }}
                    </button>
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
                        {{ trans('core::admin.button.cancel') }}
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal confirm delete module-->