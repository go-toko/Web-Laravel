{{-- Modal menu --}}
<div class="modal fade" id="modalMenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabelMenu"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="menu_form">
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
                        <label for="icon" class="form-label">Icon:</label>
                        <input class="form-control" id="icon" name="icon" onchange="previewIcon(this.value)"
                            readonly>
                        <div class="invalid-feedback error-text">

                        </div>
                        <div class="mt-3">
                            <span class="" id="icon-span" style="font-size: 5rem"></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <table>
                            <tbody style="font-size: 2rem;">
                                <tr>
                                    <td class="p-3"><i class="fas fa-home" onclick="selectIcon('fas fa-home')"></i>
                                    </td>
                                    <td class="p-3"><i class="fas fa-user" onclick="selectIcon('fas fa-user')"></i>
                                    </td>
                                    <td class="p-3"><i class="fas fa-cog" onclick="selectIcon('fas fa-cog')"></i>
                                    </td>
                                    <td class="p-3"><i class="fas fa-bell" onclick="selectIcon('fas fa-bell')"></i>
                                    </td>
                                    <td class="p-3"><i class="fas fa-file-alt"
                                            onclick="selectIcon('fas fa-file-alt')"></i></td>
                                    <td class="p-3"><i class="fas fa-shipping-fast"
                                            onclick="selectIcon('fas fa-shipping-fast')"></i></td>
                                </tr>
                                <tr>
                                    <td class="p-3"><i class="fas fa-envelope"
                                            onclick="selectIcon('fas fa-envelope')"></i></td>
                                    <td class="p-3"><i class="fas fa-search"
                                            onclick="selectIcon('fas fa-search')"></i></td>
                                    <td class="p-3"><i class="fas fa-trash" onclick="selectIcon('fas fa-trash')"></i>
                                    </td>
                                    <td class="p-3"><i class="fas fa-shopping-cart"
                                            onclick="selectIcon('fas fa-shopping-cart')"></i></td>
                                    <td class="p-3"><i class="fas fa-shopping-basket"
                                            onclick="selectIcon('fas fa-shopping-basket')"></i></td>
                                    <td class="p-3"><i class="fas fa-box-open"
                                            onclick="selectIcon('fas fa-box-open')"></i></td>
                                </tr>
                                <!-- Tambahkan baris lain jika diperlukan -->
                            </tbody>
                        </table>
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

{{-- Modal submenu --}}
<div class="modal fade" id="modalSubmenu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalSubmenuLabel">New SubMenu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="submenu_form">
                @csrf
                <input type="hidden" id="menu_id" name="menu_id">
                <input type="hidden" id="submenu_id" name="submenu_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name">
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
    {{-- Script modal menu --}}
    <script id="script-menu">
        $(document).ready(function() {
            function setDefaultMenuValue(data) {
                var $form = $('#menu_form');
                if (!data.menu) {
                    $('#role_id', $form).val(data.id);
                    $('#ModalLabelMenu').append('Add New Menu');
                } else {
                    $('#id', $form).val(data.id);
                    $('#role_id', $form).val(data.role_id);
                    $('#name', $form).val(data.menu.name);
                    $('#icon', $form).val(data.menu.icon);
                    $('#ModalLabelMenu').append('Edit Menu');
                }
            }

            function resetFormMenu() {
                $('#menu_form')[0].reset();
                $('#ModalLabelMenu').empty();
                $(document).find('div.error-text').text('');
                $('#menu_form input').removeClass('is-valid is-invalid');
                $('.invalid-feedback').text('');
            }

            /* When click add menu */
            $('body').on('click', '.add-menu', function() {
                resetFormMenu();
                var data_role = $(this).data('role')
                var data_action = $(this).data('action')
                var data_method = $(this).data('method')

                setDefaultMenuValue(data_role);

                $('#menu_form').attr({
                    action: data_action,
                    method: data_method
                });
            });

            /* When click edit menu */
            $('body').on('click', '.edit-menu', function() {
                resetFormMenu();
                var menu_role = $(this).data('menu')
                var data_action = $(this).data('action')
                var data_method = $(this).data('method')
                console.log(menu_role);
                setDefaultMenuValue(menu_role);

                $('#menu_form').attr({
                    action: data_action,
                    method: data_method
                });
            });
        });
    </script>

    {{-- Script modal submenu --}}
    <script>
        $(document).ready(function() {
            function setDefaultSubmenuValue(data) {
                var $form = $('#submenu_form');
                if (!data.menu_id) {
                    $('#menu_id', $form).val(data.id)
                    $('#ModalSubmenuLabel').append('Add New Submenu');
                } else {
                    $('#submenu_id', $form).val(data.id);
                    $('#menu_id', $form).val(data.menu_id);
                    $('#name', $form).val(data.name);
                    $('#ModalSubmenuLabel').append('Edit Submenu');
                }
            }

            function resetForm() {
                $('#submenu_form')[0].reset();
                $(document).find('div.error-text').text('');
                $('#submenu_form input').removeClass('is-valid is-invalid');
                $('.invalid-feedback').text('');
                $('#ModalSubmenuLabel').empty();
            }

            /* When click add menu */
            $('body').on('click', '.add-submenu', function() {
                resetForm();
                var data_menu = $(this).data('menu')
                var data_action = $(this).data('action')
                var data_method = $(this).data('method')

                setDefaultSubmenuValue(data_menu);

                $('#submenu_form').attr({
                    action: data_action,
                    method: data_method
                });
            });

            /* When click edit menu */
            $('body').on('click', '.edit-submenu', function() {
                resetForm();
                console.log($(this).data('submenu'));
                var data_submenu = $(this).data('submenu')
                var data_action = $(this).data('action')
                var data_method = $(this).data('method')

                setDefaultSubmenuValue(data_submenu);

                $('#submenu_form').attr({
                    action: data_action,
                    method: data_method
                });
            });
        });
    </script>

    {{-- Script to preview icon --}}
    <script>
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

    {{-- Delete Script --}}
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
                        data: {
                            'role_id': $(this).data('role_id'),
                        },
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
    {{-- Submenu --}}
    <script>
        $(function() {
            $("#submenu_form").on('submit', function(e) {
                e.preventDefault();
                var submit = document.getElementById('submit');
                submit.disabled = true;

                // create span class for spinning style
                var spinSpan = document.createElement('span');
                spinSpan.classList.add('spinner-border', 'spinner-border-sm');
                spinSpan.setAttribute('role', 'status');
                spinSpan.setAttribute('aria-hidden', 'true');

                // append span to submit button
                submit.append('...');
                submit.appendChild(spinSpan);

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
                            // enable button
                            submit.disabled = false;

                            // remove thing that has been added in html
                            var buttonText = submit.innerText.slice(0, -3);
                            submit.innerText = buttonText;
                            spinSpan.remove();

                            // add warning to html
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
                            }, 1000)
                        }
                    }
                });
            });
        });
    </script>

    {{-- Menu --}}
    <script>
        $(function() {
            $("#menu_form").on('submit', function(e) {
                e.preventDefault();

                var submit = document.getElementById('submit');
                submit.disabled = true;

                // create span class for spinning style
                var spinSpan = document.createElement('span');
                spinSpan.classList.add('spinner-border', 'spinner-border-sm');
                spinSpan.setAttribute('role', 'status');
                spinSpan.setAttribute('aria-hidden', 'true');

                // append span to submit button
                submit.append('...');
                submit.appendChild(spinSpan);

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(document).find('div.error-text').text('');
                        $('#menu_form input').removeClass('is-valid is-invalid');
                        $('.invalid-feedback').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            // enable button
                            submit.disabled = false;

                            // remove thing that has been added in html
                            var buttonText = submit.innerText.slice(0, -3);
                            submit.innerText = buttonText;
                            spinSpan.remove();

                            // add warning to html
                            $.each(data.error, function(prefix, val) {
                                var inputElem = $('input[name="' + prefix + '"]');
                                inputElem.addClass('is-invalid');
                                inputElem.next('.invalid-feedback').text(val[0]);
                            });
                            toastr.error(data.msg, 'Error')
                        } else {
                            $('#menu_form')[0].reset();
                            toastr.success(data.msg, 'Success');
                            setTimeout(function() {
                                location.reload();
                            }, 1000)
                        }
                    }
                });
            });
        });
    </script>

    {{-- Sortable Script --}}
    <script>
        $(document).ready(function() {
            $(".menu").sortable({
                update: function(event, ui) {
                    var order = [];

                    $(".menu > div").each(function() {
                        order.push($(this).data("id"));
                    });

                    $.ajax({
                        url: "{{ route('superadmin.settings.menu.updateOrder') }}",
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            order: order
                        },
                        success: function(data) {
                            if (data.status === 0) {
                                toastr.error(data.msg, 'Error')
                            } else {
                                toastr.success(data.msg, 'Success');
                            }
                        }
                    });
                }
            });
        });
    </script>

    {{-- Icon Reference --}}
    <script>
        function selectIcon(iconClass) {
            document.getElementById('icon').value = iconClass;
            document.getElementById('icon-span').className = iconClass;
        }
    </script>


    {{-- Toast Script --}}
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.js') }}"></script>

    {{-- Jquery UI --}}
    <script src="{{ URL::asset('/assets/js/jquery-ui.min.js') }}"></script>
@endsection
