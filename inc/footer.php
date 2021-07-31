<div class="well card-footer">

</div>


</body>


<!-- Jquery script -->
<script src="assets/jquery.min.js"></script>
<script src="assets/bootstrap.min.js"></script>
<script src="assets/jquery.dataTables.min.js"></script>
<script src="assets/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="assets/pdfmake.min.js"></script>
<script src="assets/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="assets/dataTables.bootstrap4.min.js"></script>
<script src="assets/dataTables.select.min.js"></script>
<script src="assets/bootbox.min.js"></script>

<script>
    $(document).ready(function () {
        $("#flash-msg").delay(7000).fadeOut("slow");
    });
    <?php
    if (Session::get('roleid') == 1): ?>
    $(document).ready(function () {
        let table = $('#example').DataTable({
            dom: 'Bfrtip',
            order: [[1, 'asc']],
            buttons: [
                {
                    extend: 'pageLength'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'All users'
                },
                {
                    text: 'Bulk edit',
                    className: 'bulk-edit',
                    action: function (event) {
                        if ($('.editRow:checked').length > 0) {  // at-least one checkbox checked
                            var ids = [];
                            $('.editRow').each(function () {
                                if ($(this).is(':checked')) {
                                    ids.push($(this).val());
                                }
                            });
                            var ids_string = ids.toString();  // array to string conversion
                            bootbox.prompt({
                                title: "Change selected users roles",
                                message: '<p>Please select an option below:</p>',
                                inputType: 'radio',
                                inputOptions: [{
                                    text: 'Admin',
                                    value: '1'
                                },
                                    {
                                        text: 'Editor',
                                        value: '2'
                                    },
                                    {
                                        text: 'User only',
                                        value: '3'
                                    }],
                                callback: function (roleid) {
                                    $.ajax({
                                        type: "POST",
                                        url: "bulk_edit_roles.php",
                                        success: function (result) {
                                            location.reload();
                                        },
                                        data: {data_ids: ids_string, roleid: roleid},
                                        async: false
                                    });
                                }
                            });
                        }
                    }
                }
            ],
            olumnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }],
            // select: {style: 'multi'},
        });
    });
    $('#bulkEdit').on('click', function () { // bulk checked
        var status = this.checked;
        $(".editRow").each(function () {
            $(this).prop("checked", status);
        });
    });
    <?php else: ?>
    $(document).ready(function () {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pageLength'
                }
            ],
        });
    });
    <?php endif; ?>
</script>
</html>
