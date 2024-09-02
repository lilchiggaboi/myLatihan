@if(session('success'))
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        swal({
            title: "Success",
            text: "{!! session('success') !!}",
            icon: "success",
            button: "OK",
        });
    </script>
@endif

@if(session('error'))
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        swal({
            title: "Error",
            text: "{!! session('error') !!}",
            icon: "error",
            button: "OK",
        });
    </script>
@endif
