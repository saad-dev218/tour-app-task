<script>
    function EditImage(id) {
        $('#EditImageModal').modal('show');
        $('#image_id').val(id);
        var actionUrl = "{{ route('tour-images.update', ':id') }}".replace(':id', id);
        $('#editImageForm').attr('action', actionUrl);
    }

    function DeleteImage(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('tour-images.destroy', ':id') }}".replace(':id',
                        id), // Ensure correct route
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}" // Include CSRF token for security
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show Swal success message
                            Swal.fire(
                                'Deleted!',
                                'The image has been deleted.',
                                'success'
                            );
                            location.reload();
                        } else {
                            Swal.fire(
                                'Error!',
                                response.message || 'Something went wrong.',
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        Swal.fire(
                            'Error!',
                            'Something went wrong. Please try again later.',
                            'error'
                        );
                    }
                });
            }
        });
    }
</script>
