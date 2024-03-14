<!-- Modal -->
<div class="modal fade" id="modalSubscription" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New Subscription List</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="main_form">
                @csrf
                <input type="hidden" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Name of subscription">
                        <div class="invalid-feedback error-text">

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <textarea type="text" name="description" class="form-control" id="description" required> </textarea>
                        <div class="invalid-feedback error-text">

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price:</label>
                        <input type="number" name="price" class="form-control" id="price" placeholder="100000">
                        <div class="invalid-feedback error-text">

                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="time" class="form-label">Time:</label>
                        <input type="number" name="time" class="form-control" id="time"
                            placeholder="Time in month">
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
            function setDefaultValue(data) {
                var $form = $('#main_form');
                // console.log(data);
                if (data) {
                    $('#id', $form).val(data.id);
                    $('#name', $form).val(data.name);
                    $('#description', $form).val(data.description);
                    $('#time', $form).val(data.time);
                    $('#price', $form).val(data.price);
                }
            }

            function resetFormMenu() {
                $('#main_form')[0].reset();
                $(document).find('div.error-text').text('');
                $('#main_form input').removeClass('is-valid is-invalid');
                $('.invalid-feedback').text('');
            }

            /* When click add menu */
            $('body').on('click', '.add-subscription', function() {
                resetFormMenu();
                var data_action = $(this).data('action')
                var data_method = $(this).data('method')

                $('#main_form').attr({
                    action: data_action,
                    method: data_method
                });
            });

            /* When click edit subscription */
            $('body').on('click', '.edit-subscription', function() {
                resetFormMenu();
                var data_subscription = $(this).data('subscription')
                console.log(data_subscription);
                var data_action = $(this).data('action')
                var data_method = $(this).data('method')

                setDefaultValue(data_subscription);

                $('#main_form').attr({
                    action: data_action,
                    method: data_method
                });
            });
        });
    </script>
    
    {{-- Script Delete Confirmation --}}
    <script>
        $(document).on('click', '.confirm-delete', function(event) {
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

    {{-- Script ajax POST --}}
    <script>
        $(function() {
            $("#main_form").on('submit', function(e) {
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
                        $('#main_form input').removeClass('is-valid is-invalid');
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
                            $('#main_form')[0].reset();
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

    {{-- Toast Script --}}
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.js') }}"></script>

    @livewireScripts
@endsection
