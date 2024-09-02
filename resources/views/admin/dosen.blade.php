<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">DataTables</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                            <li class="breadcrumb-item active">DataTables</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- alert page -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        <!-- end alert page -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title">Data Dosen</h4>
                            <button type="button" class="btn btn-primary" onclick="openModalForm()"><i class="fas fa-user-plus"></i> Tambahkan Dosen</button>
                        </div>
                    </div>
                    <div class="card-body">
                    <button type="button" class="btn btn-danger mb-2" id="deleteSelectedButton">Hapus yang dipilih</button>
                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                <th><input type="checkbox" id="selectAllCheckbox"></th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>No Telp</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dosen as $item)
// $dosen dari mana?
                                <tr>
                                <td><input type="checkbox" class="selectCheckbox" value="{{ $item->NIP_DOSEN }}"></td>
                                    <td>{{ $item->NIP_DOSEN }}</td>
                                    <td>{{ $item->NAMA_DOSEN }}</td>
                                    <td>{{ $item->NOTELP_DOSEN }}</td>
                                    <td>{{ $item->EMAIL_DOSEN }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" onclick="openModalForm(`<?= htmlentities(json_encode($item)) ?>`)"><i class="fas fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger" onclick="openModalDelete(`<?= $item->NIP_DOSEN ?>`)"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- end cardaa -->
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div> <!-- container-fluid -->
</div>
<!-- Static Backdrop modal Button -->
<!-- Static Backdrop Modal -->
<div class="modal fade" id="modalForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFormLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-dosen" action="" method='POST' enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">NIP</label>
                                <input type="text" class="form-control" name="nip_dosen" id="nip_dosen" placeholder="Enter the NIP">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" name="nama_dosen" id="nama_dosen" placeholder="Enter the Nama">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">No Telp</label>
                                <input type="text" class="form-control" name="notelp_dosen" id="notelp_dosen" placeholder="Enter the No Telp">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email_dosen" id="email_dosen" placeholder="Enter the Email">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" class="btn btn-primary"><span id="text-btn"></span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Page-content -->
<style>
    .swal2-confirm {
        margin-left: 1rem !important;
    }
</style>
<script>
    $(document).ready(function() {
        $("#datatable-buttons").DataTable({
            lengthChange: !1,
            buttons: ["pageLength", "colvis"]
        }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"), $(".dataTables_length select").addClass("form-select form-select-sm")
    });

    $('#selectAllCheckbox').click(function() {
            $('.selectCheckbox').prop('checked', this.checked);
        });

        // Delete Selected Button Click
        $('#deleteSelectedButton').click(function() {
            var selected = [];
            $('.selectCheckbox:checked').each(function() {
                selected.push($(this).val());
            });

            if (selected.length > 0) {
                // Konfirmasi hapus
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: "Kamu tidak akan bisa mengembalikan data yang sudah dihapus!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
    url: '<?= url('admin/delete-selected-dosen') ?>', // Pastikan rutenya benar
    method: 'POST',
    data: {
        _token: '{{ csrf_token() }}',
        ids: selected
    },
    success: function(response) {
        if (response.success) {
            Swal.fire('Terhapus!', response.message, 'success').then(() => {
                location.reload();
            });
        } else {
            Swal.fire('Gagal!', response.message, 'error');
        }
    }
});
                    }
                });
            } else {
                Swal.fire('Tidak ada yang dipilih', 'Silakan pilih data terlebih dahulu.', 'info');
            }
        });

    function openModalForm(dataRaw = "") {
        if (dataRaw.length > 0) {
            var data = JSON.parse(dataRaw)
            $('input[name="nip_dosen"]').val(data.NIP_DOSEN)
            $('input[name="nama_dosen"]').val(data.NAMA_DOSEN)
            $('input[name="notelp_dosen"]').val(data.NOTELP_DOSEN)
            $('input[name="email_dosen"]').val(data.EMAIL_DOSEN)
            $('#text-btn').html('Simpan Perubahan')
            $('#form-lend').attr('action', '<?= url('admin/edit-dosen') ?>')
        } else {
            $('#text-btn').html('Tambahkan Peminjaman')
            $('#form-dosen').attr('action', '<?= url('admin/save-dosen') ?>')
        }
        $('#modalForm').modal('show')
    }

    function openModalDelete(nipDosen) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "Apakah kamu yakin?",
            text: "Kamu tidak akan bisa mengembalikan data peminjaman yang sudah dihapus!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, Hapus Peminjaman",
            cancelButtonText: "Tidak",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                location.href = "<?= url('admin/delete-dosen') ?>/" + nipDosen
            }
        });
    }
</script>