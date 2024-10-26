<?php
if ($route && $id) {
    if ($privilegeRestoreId) {
        if (has_permission($privilegeRestoreId)) {
?>
            <a href='{{ Route::has("restore-$route") ? route("restore-$route", [$id]) : "#"}}' data-toggle="tooltip" data-placement="left" title="" data-original-title="Restore Record" class='btn btn-icon  btn-sm btn-primary'>
                <i class="fa fa-recycle"></i>
            </a>
        <?php
        }
    } else {
        if (has_permission($privilegeEditId)) {
        ?>
            <a href='{{ Route::has("edit-$route") ? route("edit-$route", [$id]) : "#"}}' data-toggle="tooltip" data-placement="left" title="" data-original-title="Edit Record" class='btn btn-icon  btn-sm btn-primary'>
                <i class="far fa-edit"></i>
            </a>
        <?php }
        if (has_permission($privilegeDeleteId)) {
            $url = "#";
            if (Route::has("trash-$route")) {
                $url = route("trash-$route", [$id]);
            }
        ?>
            <span onclick="showDeleteConfirmation('<?= $url ?>');" class='btn btn-icon btn-sm btn-danger' data-toggle="tooltip" data-placement="left" title="" data-original-title="Delete Record">
                <i class="fa fa-trash"></i>
            </span>
<?php }
    }
} ?>


@section('exfooter')
<div id="delete_confirmation" class="modal fade" tabindex="-1" role="dialog" id="list">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="delete_modal_form" method="get" action='#'>
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Are you sure you want to delete this?</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function showDeleteConfirmation(url) {
        $("#delete_modal_form").attr('action', url);
        $("#delete_confirmation").modal('show');
    }
</script>
@endsection