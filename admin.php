<?php
require './connect.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>CV Media Utama Group</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="asset/css/style5.css">
    <link rel="stylesheet" type="text/css" href="asset/plugin/font-icon/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    <!-- Tambahan untuk membuat tabel responsif -->
    <style>
        .dataTables_wrapper {
        overflow-x: auto;
        }

        table.dataTable thead th,
        table.dataTable tbody td {
        white-space: nowrap;
        text-align: center;
        vertical-align: middle;
        padding: 6px 10px;
        font-size: 14px;
        }
        .dt-buttons{
          margin: 5px 20px;
        }
    </style>

</head>
<body>
<header>
    <img src="asset/image/LOGO-CV-MEDIA.png" class="mb-4 mt-4" width="1000" id="logo-header">
</header>
<nav>
    <?php include "nav.php"; ?>
</nav>
<main>
    <div id="bg-green"></div>
    <div id="main-body">
      <?php
          if (isset($_SESSION['alert'])) {
            $alert = $_SESSION['alert'];
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    icon: '{$alert['type']}',
                    title: '{$alert['message']}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>";
            unset($_SESSION['alert']); // Hapus agar tidak muncul terus
        }
      ?>
        <?php include "page.php"; ?>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="asset/js/jquery.js" type="text/javascript"></script>
<!-- <script src="asset/js/main.js" type="text/javascript"></script> -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>

<!-- DataTables core -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- DataTables Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>

<!-- JSZip dan PDFMake untuk export (opsional, tapi baiknya include aja) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<!-- HTML5 export & column visibility -->
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



<script>


    $(document).ready(function () {
      new DataTable('#formatTgl', {
        dom: 'lfrBtip', // B = Buttons, f = filter, r = processing, t = table, i = info, p = pagination
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
        pageLength: 10, // default-nya di awal
        buttons: ['copy', 'excel', 'pdf'],
        columnDefs: [
          {
            target: 1,
            render: DataTable.render.date(),
          }
        ],
      });
      new DataTable('#normalTable', {
        dom: 'lfrBtip', // B = Buttons, f = filter, r = processing, t = table, i = info, p = pagination
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
        pageLength: 10, // default-nya di awal
        buttons: ['copy', 'excel', 'pdf'],
      });
  
    });
</script>

<script>
    $('#id_produk').on('change', function() {
        var id_produk = $(this).val();

        if (id_produk !== '') {
            $.ajax({
                url: 'ajax/get_tanggal_produksi.php',
                type: 'POST',
                data: { id_produk: id_produk },
                success: function(data) {
                    $('#tgl_produksi').html(data);
                }
            });
        } else {
            $('#tgl_produksi').html('<option value="">-- Pilih Tanggal Produksi --</option>');
        }
    });
</script>

<script>
const ctx = document.getElementById('kendaliChart').getContext('2d');
const kendaliChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($labels) ?>,
        datasets: [
            {
                label: 'Proporsi Cacat',
                data: <?= json_encode($proporsi) ?>,
                borderColor: 'blue',
                backgroundColor: 'rgba(0,0,255,0.1)',
                fill: false,
                tension: 0.3
            },
            {
                label: 'CL (Center Line)',
                data: <?= json_encode($clData) ?>,
                borderColor: 'green',
                borderDash: [5,5],
                fill: false,
                tension: 0.3
            },
            {
                label: 'UCL (Upper Control Limit)',
                data: <?= json_encode($uclData) ?>,
                borderColor: 'red',
                borderDash: [5,5],
                fill: false,
                tension: 0.3
            },
            {
                label: 'LCL (Lower Control Limit)',
                data: <?= json_encode($lclData) ?>,
                borderColor: 'orange',
                borderDash: [5,5],
                fill: false,
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Diagram Kendali (Control Chart)'
            },
            legend: {
                position: 'top'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 1
            }
        }
    }
});
</script>

<script>
  const ctx = document.getElementById('grafikProduksi').getContext('2d');
  const grafikProduksi = new Chart(ctx, {
    type: 'line',
    data: {
      labels: <?php echo json_encode($tanggal); ?>,
      datasets: [{
        label: 'Jumlah Produksi',
        data: <?php echo json_encode($jumlah); ?>,
        fill: true,
        borderColor: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Jumlah Produksi'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Tanggal Produksi'
          }
        }
      }
    }
  });
</script>
<script>
  const ctxCacat = document.getElementById('grafikKecacatan').getContext('2d');
  const grafikKecacatan = new Chart(ctxCacat, {
    type: 'bar',
    data: {
      labels: <?php echo json_encode($tanggal_cacat); ?>,
      datasets: [{
        label: 'Jumlah Kecacatan',
        data: <?php echo json_encode($jumlah_cacat); ?>,
        backgroundColor: 'rgba(255, 99, 132, 0.5)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Jumlah Kecacatan'
          }
        },
        x: {
          title: {
            display: true,
            text: 'Tanggal Produksi'
          }
        }
      }
    }
  });
</script>
<script>
    // Misalnya data yang diambil dari database
    const data = {
    labels: <?php echo json_encode($labels); ?>,  // Jenis kecacatan
    datasets: [
        {
        label: 'Persentase (%)',
        data: <?php echo json_encode($jumlah_kecacatan); ?>,  // Jumlah kecacatan
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
        },
        {
        label: 'Persentase Kumulatif (%)',
        data: <?php echo json_encode($kumulatif); ?>,  // Persentase kumulatif
        type: 'line',
        fill: false,
        borderColor: 'rgba(255, 99, 132, 1)',
        tension: 0.1
        }
    ]
    };

    const config = {
    type: 'bar',
    data: data,
    options: {
        scales: {
        y: {
            beginAtZero: true
        }
        }
    }
    };

    const paretoChart = new Chart(document.getElementById('paretoChart'), config);

    $.ajax({
    url: 'url_to_get_data', // Endpoint untuk mengambil data
    type: 'GET',
    success: function(response) {
        const labels = response.map(item => item.jenis_kecacatan); // Jenis kecacatan
        const jumlahKecacatan = response.map(item => item.jumlah_kecacatan); // Jumlah kecacatan
        const persentaseKumulatif = response.map(item => item.persentase_kumulatif); // Persentase kumulatif

        // Update grafik dengan data yang baru
        paretoChart.data.labels = labels;
        paretoChart.data.datasets[0].data = jumlahKecacatan;
        paretoChart.data.datasets[1].data = persentaseKumulatif;
        paretoChart.update();
    }
    });

</script>
<script>
    const passwordInput = document.getElementById('password');
    const togglePasswordButton = document.getElementById('toggle-password');

    togglePasswordButton.addEventListener('click', () => {
        // Toggle the input type between password and text
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;

        // Change the button icon accordingly
        togglePasswordButton.textContent = type === 'password' ? '👁️' : '🙈';
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const hapusButtons = document.querySelectorAll(".btn-hapus");

    hapusButtons.forEach(function (button) {
        button.addEventListener("click", function (e) {
            e.preventDefault();

            const id = this.getAttribute("data-id");
            const op = this.getAttribute("data-op");
            const nama = this.getAttribute("data-nama");

            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data: " + nama,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                  window.location.href = `proses/proseshapus.php/?page=hapus&op=${op}&id=${id}`;
                }
            });
        });
    });
});
</script>

</body>
</html>