<x-dashboard.layout>
    {{-- Start::Head component --}}
    <x-slot name="title">Pendahuluan</x-slot>

    <x-slot name="style">
        <link rel="stylesheet" href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }} ">
    </x-slot>
    {{-- End::Head component --}}

    {{-- Start::Toolbar component --}}
    <x-slot name="toolbar">
        <x-dashboard.toolbar.main>
            <x-slot name="title">Pendahuluan</x-slot>

            <x-slot name="breadcrumb">
                <li class="breadcrumb-item">
                    <span class="text-muted">Beranda</span>
                </li>
            </x-slot>

            <x-slot name="backbutton">
                {{-- empty --}}
            </x-slot>
        </x-dashboard.toolbar.main>
    </x-slot>
    {{-- End::Toolbar component --}}

    {{-- Start::Post component --}}
    <x-slot name="post">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder text-dark fs-5 my-1">Pendahuluan</span>
                    <span class="text-muted mt-1 fw-bold fs-7">Beranda</span>
                </h3>
                <div class="card-toolbar">
                    {{-- @if (Auth::user()->hasAnyRole('administrator')) --}}
                    <a href="" class="btn btn-sm btn-light-primary">
                        <span class="svg-icon svg-icon-muted svg-icon-3"><svg xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2"
                                    rx="1" transform="rotate(-90 11.364 20.364)" fill="black" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1"
                                    fill="black" />
                            </svg></span> Tambah Pendahuluan
                    </a>
                    {{-- @endif --}}
                </div>
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body">
                <table id="datatable"
                    class="table table-sm table-row-bordered gy-5 gs-4 border rounded no-footer nowrap dataTable">
                    <thead>
                        <tr class="border-gray-200 fw-bold bg-lighten fs-7">
                            <th class="mw-50px">No.</th>
                            <th class="min-w-150px">Tahun Periode</th>
                            <th>Berkas</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </x-slot>
    {{-- End::Post component --}}

    {{-- Start::Javascript --}}
    <x-slot name="javascript">
        {{-- Start::Sweetalert2 --}}
        <script>
            $(document).on('click', '.delete', function() {
                var id = $(this).attr('id');
                swal.fire({
                    title: "Hapus data ini?",
                    text: "Data yang terhapus tidak dapat dikembalikan.",
                    icon: "warning",
                    showCloseButton: true,
                    confirmButtonColor: '#f1416c',
                    confirmButtonText: 'Ya, Hapus!'
                }).then(function(result) {
                    if (result.value) {
                        var url = '{{ route("example.destroy", ":example") }}';
                        url = url.replace(':introduction', id);

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            type: 'POST',
                            datatype: 'json',
                            data: {
                                "_method": 'DELETE',
                            },
                            success: function(data) {
                                setTimeout(function() {
                                    location.reload()
                                }, 1500);
                            },
                            complete: function() {
                                swal.hideLoading();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                swal.hideLoading();
                                swal.fire("Maaf ", "Terjadi kesalahan", "error");
                            }
                        });
                    }
                });
            });
        </script>
        {{-- End::Sweetalert2 --}}

        {{-- Start::Datatable --}}
        <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('example.datatable') }}",
                    columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    }, {
                        data: 'setting.period',
                        name: 'setting.period'
                    }, {
                        data: 'attachment',
                        name: 'attachment'
                    }, {
                        data: 'action',
                        name: 'action'
                    }],
                    columnDefs: [{
                        className: 'text-center',
                        orderable: false,
                        targets: [0]
                    }, {
                        className: 'text-center mw-100px',
                        orderable: false,
                        targets: [2,3]
                    }],
                    pagingType: "full_numbers",
                    "language": {
                        "search": "Cari:",
                        "emptyTable": "Tidak ada data yang tersedia pada tabel ini",
                        "info": "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        "infoEmpty": "Tidak menampilkan data apapun",
                        "infoFiltered":   "(difilter dari total _MAX_ data)",
                        "loadingRecords": "Memuat...",
                        "processing": "Memproses...",
                        "zeroRecords": "Tidak ada data yang cocok ditemukan",
                    },
                    dom: "<'row'" +
                        "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                        "<'col-sm-6 d-flex align-items-center justify-content-end z-0'f>" +
                        ">" +

                        "<'table-responsive'tr>" +

                        "<'row'" +
                        "<'col-sm-6 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                        "<'col-sm-6 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                        ">"
                });
            });
        </script>
        {{-- Start::Datatable --}}
    </x-slot>
    {{-- End::Javascript --}}

</x-dashboard.layout>
