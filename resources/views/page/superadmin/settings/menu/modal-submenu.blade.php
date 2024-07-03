<div class="modal fade" id="modalSubmenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New SubMenu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="submenu_form">
                @csrf
                <input type="hidden" id="role_id" value='' name="role_id">
                <input type="hidden" id="menu_id" name="menu_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <div class="invalid-feedback error-text">

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">Url:</label>
                        <input type="text" name="url" class="form-control" id="url" value=""
                            required>
                        <div class="invalid-feedback error-text">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('forscript')
    <script id="script-submenu">
        $(document).ready(function() {
            function setDefaultValue(data) {
                var $form = $('#submenu_form');
                console.log(data);
                if (!data.submenu) {
                    $('#role_id', $form).val(data.id)
                    $('#url', $form).val(data.menu.name.toLowerCase() + '/');
                } else {
                    $('#id', $form).val(data.id);
                    $('#name', $form).val(data.menu.name);
                    $('#url', $form).val(data.menu.url);
                    $('#icon', $form).val(data.menu.icon);
                }
            }

            function preventDeleteBeforeSlash() {
                var $url = $('#url');
                var readOnlyLength = $url.val().length;

                $('#output').text(readOnlyLength);

                $url.on('keypress, keydown', function(event) {
                    var $field = $(this);
                    $('#output').text(event.which + '/' + this.selectionStart);
                    if ((event.which != 37 && (event.which != 39)) &&
                        ((this.selectionStart < readOnlyLength) ||
                            ((this.selectionStart == readOnlyLength) && (event.which == 8)))) {
                        return false;
                    }
                });
            }

            function resetForm() {
                $('#submenu_form')[0].reset();
                $(document).find('div.error-text').text('');
                $('#submenu_form input').removeClass('is-valid is-invalid');
                $('.invalid-feedback').text('');
            }

            
            $('body').on('click', '.add-submenu', function() {
                console.log('submenu');
            })

            /* When click add menu */
            $('body').on('click', '.add-submenu', function() {
                console.log('submenu');
                resetForm();
                var data_menu = $(this).data('menu')
                var data_action = $(this).data('action')
                var data_method = $(this).data('method')

                setDefaultValue(data_menu);
                preventDeleteBeforeSlash();

                $('#submenu_form').attr({
                    action: data_action,
                    method: data_method
                });
            });

            /* When click edit menu */
            $('body').on('click', '.edit-submenu', function() {
                resetForm();
                var menu_role = $(this).data('menu')
                var data_action = $(this).data('action')
                var data_method = $(this).data('method')

                setDefaultValue(menu_role);
                preventDeleteBeforeSlash();

                $('#submenu_form').attr({
                    action: data_action,
                    method: data_method
                });
            });
        });
    </script>

    <script>
        // Function to preview icon
        function previewIcon(val) {
            const icon = document.querySelector('#icon-span');
            if (val === '') {
                icon.classList.remove(...(icon.className).split(" "));
            } else {
                if (icon.className) {
                    icon.classList.remove(...(icon.className).split(" "))
                }
                icon.classList.add(...val.split(" "));
            }
        }
        // ------------------------- //
    </script>

    <script>
        $(document).on('click', '#confirm-delete', function(event) {
            event.preventDefault();
            const url = $(this).data('action');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        success: function(data) {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Your file has been deleted.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            location.reload();
                        },
                        error: function(data) {
                            Swal.fire({
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                icon: 'error',
                                confirmButtonColor: '#dc3545'
                            })
                        }
                    });
                }
            });
        });
    </script>

    {{-- AJAX VALIDATOR && TRIGGER UPDATE OR CREATE URL --}}
    <script>
        $(function() {
            $("#submenu_form").on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('div.error-text').text('');
                        $('#submenu_form input').removeClass('is-valid is-invalid');
                        $('.invalid-feedback').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                var inputElem = $('input[name="' + prefix + '"]');
                                inputElem.addClass('is-invalid');
                                inputElem.next('.invalid-feedback').text(val[0]);
                            });
                            toastr.error(data.msg, 'Error')
                        } else {
                            $('#submenu_form')[0].reset();
                            toastr.success(data.msg, 'Success');
                            document.getElementById('submit').disabled = true;
                            setTimeout(function() {
                                location.reload();
                            }, 2000)
                        }
                    }
                });
            });
        });
    </script>
@endsection
