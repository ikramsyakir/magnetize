<script type="text/javascript">
    function confirmChangeStatus(url) {
        event.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "You would like to change the account status of user!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                axios.put(url)
                    .then(function (response) {
                        console.log(response);
                        if (response.data.success) {
                            Swal.fire({
                                title: "Success",
                                text: "Record updated!",
                                icon: "success",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                showCancelButton: false,
                                allowEnterKey: false,
                                timer: 5000
                            }).then((success) => {
                                if (success.isConfirmed) {
                                    location.reload();
                                }

                                if (success.dismiss === Swal.DismissReason.timer) {
                                    location.reload();
                                }
                            });
                        } else {
                            Swal.fire("Error", response.data.message, "error");
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                        Swal.fire("Error", "An error occurred", "error");
                    })
            } else {
                Swal.fire("Cancelled", "Your record is safe", "error");
            }
        });
    }
</script>
