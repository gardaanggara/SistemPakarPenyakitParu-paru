$(document).ready(function () {
    roleList = new Tabulator("#role-list", {
        columns: [
            { 
                title: "#",
                field: "aksi",
                headerSort: false,
                formatter: function(cell, formatterParams, onRendered) {
                    var id = cell.getRow().getData().id;
                    return `
                        <button class="btn btn-primary btn-sm edit-btn" data-id="${id}" data-bs-toggle="modal" data-bs-target="#editModal">
                            <ion-icon name="create-outline"></ion-icon>
                        </button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${id}">
                            <ion-icon name="trash-outline"></ion-icon>
                        </button>`;
                },
                width: "10%",
            },
            { 
                title: "Keterangan", 
                field: "keterangan",
                sorter: true,
                width: "90%",
            }
        ],
        ajaxURL: "/roles/api/data",
        ajaxConfig: "GET",
        pagination: "remote",
        paginationSize: 10,
        placeholder: "Data tidak tersedia",
    });

    // Event handler untuk tombol edit
    $("#role-list").on("click", ".edit-btn", function () {
        var id = $(this).data("id");
        console.log("Edit ID: " + id);
        
        // Memasukkan data ke dalam modal
        $("#editId").val(id); // Memasukkan ID ke dalam input tersembunyi
        
        // Melakukan request AJAX untuk mengambil data detail role
        $.get(`/roles/${id}`, function(data) {
            $("#editKeterangan").val(data.keterangan); // Memasukkan keterangan ke dalam input editKeterangan
        });

        // Pastikan modal edit ditampilkan setelah data dimuat
        $('#editModal').modal('show');
    });

    // Submit form edit
    $("#editForm").submit(function (e) {
        e.preventDefault();
        var id = $("#editId").val();
        var keterangan = $("#editKeterangan").val();
        console.log("Simpan perubahan untuk ID: " + id);
        
        // Tambahkan logika untuk menyimpan perubahan menggunakan AJAX
        $.ajax({
            url: `/roles/store/${id}`,
            type: 'POST',
            data: {
                _method: 'PATCH', // Metode PATCH untuk update
                keterangan: keterangan
            },
            success: function(response) {
                console.log(response);
                // Tambahkan logika lain sesuai kebutuhan, misalnya menampilkan pesan sukses
                // dan mengupdate data di tabel jika perlu
                roleList.setData("/roles/api/data"); // Refresh data tabel setelah update
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });

        // Tutup modal setelah sukses menyimpan perubahan
        $("#editModal").modal("hide");
    });

    // Event handler untuk tombol hapus (jika diperlukan)
    $("#role-list").on("click", ".delete-btn", function () {
        var id = $(this).data("id");
        console.log("Delete ID: " + id);
        // Tambahkan logika untuk menghapus data di sini
    });
});
