@extends('layout.main')
@section('content')


<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Mutasi Table</h6>
        </div>
        <div class="card-body">
            <div class="float-right mb-4">
                <button href="#" class="btn btn-primary text-end" onclick="add()"><i class="fa fa-plus"></i>
                    Tambah Mutasi</button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="table-mutation" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Lokasi&nbsp;Awal</th>
                            <th>Lokasi&nbsp;Akhir</th>
                            <th>Produk</th>
                            <th>Pegawai</th>
                            <th>Jumlah</th>
                            <th>Jenis</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="modal" id="modal-product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Customer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="customer_form">
                            <div class="modal-body">


                                <div class="form-group">
                                    <label for="tanggal">Tanggal</label>
                                    <input type="date" name="tanggal" class="form-control" id="tanggal">
                                    <small id="error_tanggal" class="form-text text-danger">We'll never share your email with anyone else.</small>
                                </div>

                                <div class="form-group">
                                    <label for="location_from">Lokasi Awal</label>
                                    <select name="location_from" id="location-awal-select2" class="form-select select2" style="width: 100%;">
                                        <option value="" disabled selected>Select a location</option>
                                    </select>
                                    <small id="error_lokasi_awal" class="form-text text-danger">We'll never share your email with anyone else.</small>
                                </div>

                                <div class="form-group">
                                    <label for="location_to">Lokasi Akhir</label>
                                    <select name="location_to" id="location-akhir-select2" class="form-select select2" style="width: 100%;">
                                        <option value="" disabled selected>Select a location</option>
                                    </select>
                                    <small id="error_lokasi_akhir" class="form-text text-danger">We'll never share your email with anyone else.</small>
                                </div>

                                <div class="form-group">
                                    <label for="product">Product</label>
                                    <select name="product" id="product-select2" class="form-select select2" style="width: 100%;">
                                        <option value="" disabled selected>Select a location</option>
                                    </select>
                                    <small id="error_product" class="form-text text-danger">We'll never share your email with anyone else.</small>
                                </div>

                                <div class="form-group">
                                    <label for="qty">Qty</label>
                                    <input name="qty" type="text" class="form-control" id="qty" aria-describedby="emailHelp" placeholder="Enter Qty">
                                    <small id="error_qty" class="form-text text-danger">We'll never share your email with anyone else.</small>
                                </div>


                                <div class="form-group">
                                    <label for="jenis_mutasi">Jenis</label>
                                    <select name="jenis_mutasi" id="jenis-mutasi-select2" class="form-select select2" style="width: 100%;">
                                        <option value="" disabled selected>Select a jenis</option>
                                    </select>
                                    <small id="error_jenis" class="form-text text-danger">We'll never share your email with anyone else.</small>
                                </div>

                                <div class="form-group">
                                    <label for="pegawai">Pegawai</label>
                                    <select name="pegawai" id="pegawai-select2" class="form-select select2" style="width: 100%;">
                                        <option value="" disabled selected>Select a jenis</option>
                                    </select>
                                    <small id="error_pegawai" class="form-text text-danger">We'll never share your email with anyone else.</small>
                                </div>

                                <div class="form-group">
                                    <label for="keterangan">Keterangan</label>
                                    <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                                    <small id="error_keterangan" class="form-text text-danger">We'll never share your email with anyone else.</small>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary add-customer">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('js_script')
<script>
    var table;
    var modal = $('#modal-category');
    var formData = $('#customer_form');
    var saveData;
    var id_category;
    var url, method;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Authorization': 'Bearer ' + $('meta[name="api-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        loadData();
        getCategory();
        getProduct();
        getLocation();
        getLocation2();
        getPegawai();
        getJenis();
        $('#error_tanggal').css('visibility', 'hidden');
        $('#error_category').css('visibility', 'hidden');
        $('#error_price').css('visibility', 'hidden');
        $('#error_lokasi_awal').css('visibility', 'hidden');
        $('#error_lokasi_akhir').css('visibility', 'hidden');
        $('#error_product').css('visibility', 'hidden');
        $('#error_qty').css('visibility', 'hidden');
        $('#error_jenis').css('visibility', 'hidden');
        $('#error_pegawai').css('visibility', 'hidden');
        $('#error_keterangan').css('visibility', 'hidden');
    });

    function loadData() {

        $('#table-mutation').DataTable({
            bDestroy: true,
            searching: true,
            processing: true,
            pagination: true,
            responsive: true,
            ordering: true,
            serverSide: true,
            ajax: "{{ route('data.mutation') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'no',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'tanggal',
                    name: 'created_at'
                },
                {
                    data: 'lokasi_awal',
                    name: 'lokasi_awal'
                },
                {
                    data: 'lokasi_akhir',
                    name: 'lokasi_akhir'
                },
                {
                    data: 'product_name',
                    name: 'product.name'
                },
                {
                    data: 'pegawai_name',
                    name: 'pegawai.name'
                }, {
                    data: 'jumlah',
                    name: 'jumlah'
                },
                {
                    data: 'jenis',
                    name: 'jenis'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });
    }

    function getCategory(category_id = null) {
        let url = "{{ route('data.category.all')}}"; // Ambil semua kategori

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                // console.log(response);
                // if (!response.data) return console.error('Invalid response format:', response);

                let html = '<option value="">Silahkan Pilih Category</option>';
                response.data.forEach(category => {
                    let selected = (category_id && category.uuid == category_id) ? ' selected' : '';
                    html += `<option value="${category.uuid}"${selected}>${category.name}</option>`;
                });

                $("#category-select2").html(html).select2({
                    placeholder: "Pilih Category",
                    allowClear: true,
                    width: "100%"
                });
            },
            error: function(error) {
                console.error('Error fetching categories:', error);
            }
        });
    }

    function getLocation(lokasi_id = null) {
        let url = "{{ route('data.location.all')}}"; // Ambil semua kategori

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                // console.log(response);
                // if (!response.data) return console.error('Invalid response format:', response);

                let html = '<option value="">Silahkan Pilih Lokasi</option>';
                response.data.forEach(lokasi => {
                    let selected = (lokasi_id && lokasi.id == lokasi_id) ? ' selected' : '';
                    html += `<option value="${lokasi.id}"${selected}>${lokasi.name}</option>`;
                });

                $("#location-awal-select2").html(html).select2({
                    placeholder: "Pilih Category",
                    allowClear: true,
                    width: "100%",
                    // dropdownParent: $('#modal-product')
                });
            },
            error: function(error) {
                console.error('Error fetching categories:', error);
            }
        });
    }

    function getLocation2(lokasi_id = null) {
        let url = "{{ route('data.location.all')}}"; // Ambil semua kategori

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                // console.log(response);
                // if (!response.data) return console.error('Invalid response format:', response);

                let html = '<option value="">Silahkan Pilih Lokasi</option>';
                response.data.forEach(lokasi => {
                    let selected = (lokasi_id && lokasi.id == lokasi_id) ? ' selected' : '';
                    html += `<option value="${lokasi.id}"${selected}>${lokasi.name}</option>`;
                });

                $("#location-akhir-select2").html(html).select2({
                    placeholder: "Pilih Category",
                    allowClear: true,
                    width: "100%",
                    // dropdownParent: $('#modal-product')
                });
            },
            error: function(error) {
                console.error('Error fetching categories:', error);
            }
        });
    }

    function getProduct(product_id = null) {
        let url = "{{ route('data.product.all')}}"; // Ambil semua kategori

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                // console.log(response);
                // if (!response.data) return console.error('Invalid response format:', response);

                let html = '<option value="">Silahkan Pilih Product</option>';
                response.data.forEach(product => {
                    let selected = (product_id && product.id == product_id) ? ' selected' : '';
                    html += `<option value="${product.id}"${selected}>${product.name}</option>`;
                });

                $("#product-select2").html(html).select2({
                    placeholder: "Pilih Category",
                    allowClear: true,
                    width: "100%",
                    // dropdownParent: $('#modal-product')
                });
            },
            error: function(error) {
                console.error('Error fetching categories:', error);
            }
        });
    }

    function getJenis(jenis_id = null) {
        let url = "{{ route('data.utilty-type-mutasi.all')}}"; // Ambil semua kategori

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                // console.log(response);
                // if (!response.data) return console.error('Invalid response format:', response);

                let html = '<option value="">Silahkan Pilih Jenis</option>';
                response.data.forEach(jenis => {
                    let selected = (jenis_id && jenis.name == jenis_id) ? ' selected' : '';
                    html += `<option value="${jenis.name}"${selected}>${jenis.name}</option>`;
                });

                $("#jenis-mutasi-select2").html(html).select2({
                    placeholder: "Pilih Jenis",
                    allowClear: true,
                    width: "100%",
                    // dropdownParent: $('#modal-product')
                });
            },
            error: function(error) {
                console.error('Error fetching categories:', error);
            }
        });
    }

    function getPegawai(pegawai_id = null) {
        let url = "{{ route('data.pegawai.all')}}"; // Ambil semua kategori

        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                // console.log(response);
                // if (!response.data) return console.error('Invalid response format:', response);

                let html = '<option value="">Silahkan Pilih Pegawai</option>';
                response.data.forEach(pegawai => {
                    let selected = (pegawai_id && pegawai.id == pegawai_id) ? ' selected' : '';
                    html += `<option value="${pegawai.id}"${selected}>${pegawai.name}</option>`;
                });

                $("#pegawai-select2").html(html).select2({
                    placeholder: "Pilih Pegawai",
                    allowClear: true,
                    width: "100%",
                    // dropdownParent: $('#modal-product')
                });
            },
            error: function(error) {
                console.error('Error fetching categories:', error);
            }
        });
    }


    function add() {
        saveData = 'add';
        $('#modal-product').modal('show');
        formData[0].reset();
        $(".modal-title").text("Tambah Mutasi");
        $(".add-customer").text("Tambah");
    }

    function byid(id) {

        var uuid = id;
        id_customer = id;
        saveData = 'edit';

        $('#modal-product').modal('show');
        $(".modal-title").text("Update Product");
        $(".add-product").text("Update");

        $.ajax({
            url: "{{ route('mutations.show', ':uuid') }}".replace(':uuid', uuid),
            method: 'get',
            dataType: "json",
            data: formData,
            success: function(response) {
                console.log(response);
                $("#qty").val(response.data.jumlah);
                $("#tanggal").val(response.data.tanggal);
                $("#keterangan").val(response.data.keterangan);
                getLocation(response.data.lokasi_awal);
                getLocation2(response.data.lokasi_akhir);
                getProduct(response.data.product_id);
                getJenis(response.data.jenis);
                getPegawai(response.data.pegawai_id);
                
            },
            error: function(response) {

                console.log(response);

                Swal.fire({
                    title: "Ambil" + " Data Gagal",
                    icon: "error"
                });

            }
        });

    }

    function destroy(id) {
        saveData = "delete";

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {

                if (saveData == 'delete') {
                    url = "{{ route('mutations.destroy', ':uuid') }}";
                    url = url.replace(':uuid', id);
                    method = 'DELETE';
                }

                if (saveData == 'delete') {
                    formData.append('_method', 'DELETE');
                }

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _method: 'DELETE', // Simulasi DELETE
                    },
                    success: function(response) {
                        console.log(response);
                        $('#modal-product').hide();
                        $('#modal-product').modal('hide');
                        loadData();
                        Swal.fire({
                            title: saveData + " Data Berhasil",
                            icon: "success"
                        });
                    },
                    error: function(response) {

                        console.log(response);

                        Swal.fire({
                            title: saveData + " Data Gagal",
                            icon: "error"
                        });

                    }
                });
            }
        });

    }

    $(formData).submit(function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        if (saveData == 'add') {
            method = 'POST';
            url = "{{ route('mutations.store') }}";
        } else if (saveData == 'edit') {
            url = "{{ route('mutations.update', ':uuid') }}";
            url = url.replace(':uuid', id_customer);
            method = 'PUT';
        } else if (saveData == 'delete') {
            url = "{{ route('mutations.update', ':uuid') }}";
            url = url.replace(':uuid', id_customer);
            method = 'DELETE';
        }

        if (saveData == 'edit') {
            formData.append('_method', 'PUT');
        } else if (saveData == 'delete') {
            formData.append('_method', 'DELETE');
        }


        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('#modal-product').hide();
                $('#modal-product').modal('hide');
                loadData();
                Swal.fire({
                    title: saveData + " Data Berhasil",
                    icon: "success"
                });
            },
            error: function(response) {

                console.log(response);

                if (response.responseJSON.errors.tanggal != undefined) {
                    $('#error_tanggal').css('visibility', 'visible');
                }

                if (response.responseJSON.errors.location_from != undefined) {
                    $('#error_lokasi_awal').css('visibility', 'visible');
                }

                if (response.responseJSON.errors.location_to != undefined) {
                    $('#error_lokasi_akhir').css('visibility', 'visible');
                }

                if (response.responseJSON.errors.product != undefined) {
                    $('#error_product').css('visibility', 'visible');
                }
                
                if (response.responseJSON.errors.qty != undefined) {
                    $('#error_qty').css('visibility', 'visible');
                }

                if (response.responseJSON.errors.jenis_mutasi != undefined) {
                    $('#error_jenis').css('visibility', 'visible');
                }

                if (response.responseJSON.errors.pegawai != undefined) {
                    $('#error_pegawai').css('visibility', 'visible');
                }

                if (response.responseJSON.errors.keterangan != undefined) {
                    $('#error_keterangan').css('visibility', 'visible');
                }

                Swal.fire({
                    title: saveData + " Data Gagal",
                    icon: "error"
                });

                $("#error_tanggal").html(response.responseJSON.errors.tanggal);
                $("#error_lokasi_awal").html(response.responseJSON.errors.location_from);
                $("#error_lokasi_akhir").html(response.responseJSON.errors.location_to);
                $("#error_product").html(response.responseJSON.errors.product);
                $("#error_qty").html(response.responseJSON.errors.qty);
                $("#error_jenis").html(response.responseJSON.errors.jenis_mutasi);
                $("#error_pegawai").html(response.responseJSON.errors.pegawai);
                $("#error_keterangan").html(response.responseJSON.errors.keterangan);


            }
        });

    });
</script>
@endsection