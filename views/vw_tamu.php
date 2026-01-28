<?php
require_once __DIR__ . '/../controllers/TamuController.php';
$controller = new TamuController();

/* ================= PROSES CRUD ================= */
if (isset($_POST['simpan'])) {
    $controller->store($_POST);
    header("Location: vw_tamu.php");
    exit;
}

if (isset($_POST['update'])) {
    $controller->update($_POST);
    header("Location: vw_tamu.php");
    exit;
}

if (isset($_GET['hapus'])) {
    $controller->destroy($_GET['hapus']);
    header("Location: vw_tamu.php");
    exit;
}

/* ================= MODE ================= */
$mode = 'list';
$data = null;

if (isset($_GET['tambah'])) {
    $mode = 'tambah';
}

if (isset($_GET['detail'])) {
    $mode = 'detail';
    $data = $controller->edit($_GET['detail']);
}

if (isset($_GET['edit'])) {
    $mode = 'edit';
    $data = $controller->edit($_GET['edit']);
}

/* ================= DATA ================= */
$dataTamu = $controller->index();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>CRUD Tamu MVC</title>

<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f6f8;
    padding: 30px;
}
.container {
    max-width: 1000px;
    margin: auto;
}
.card {
    background: #fff;
    padding: 20px;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(0,0,0,.1);
    margin-bottom: 25px;
}
.card h2 {
    margin-top: 0;
}
.row {
    margin-bottom: 12px;
}
.label {
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}
input[type=text] {
    width: 100%;
    padding: 10px;
}
.btn {
    padding: 8px 16px;
    border-radius: 4px;
    border: none;
    text-decoration: none;
    color: #fff;
    cursor: pointer;
    display: inline-block;
}
.btn-primary { background: #0d6efd; }
.btn-success { background: #198754; }
.btn-warning { background: #ffc107; color:#000; }
.btn-danger { background: #dc3545; }
.btn-secondary { background: #6c757d; }

table {
    width: 100%;
    border-collapse: collapse;
}
table th, table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}
table th {
    background: #0d6efd;
    color: #fff;
}
.actions a {
    font-size: 13px;
    margin: 0 3px;
}
</style>
</head>

<body>
<div class="container">

<!-- ================= PANEL MODE ================= -->
<?php if ($mode !== 'list'): ?>
<div class="card">

    <?php if ($mode === 'tambah'): ?>
        <h2>➕ Tambah Tamu</h2>
        <form method="post" onsubmit="return validasiForm()">
            <div class="row">
                <label class="label">Nama</label>
                <input type="text" name="nama" id="nama">
            </div>
            <div class="row">
                <label class="label">Alamat</label>
                <input type="text" name="alamat" id="alamat">
            </div>
            <button name="simpan" class="btn btn-primary">Simpan</button>
            <a href="vw_tamu.php" class="btn btn-secondary">Batal</a>
        </form>

    <?php elseif ($mode === 'detail'): ?>
        <h2>👤 Detail Tamu</h2>
        <p><strong>ID:</strong> <?= $data['id'] ?></p>
        <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama']) ?></p>
        <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']) ?></p>

        <a href="?edit=<?= $data['id'] ?>" class="btn btn-warning">Edit</a>
        <a href="vw_tamu.php" class="btn btn-secondary">Kembali</a>

    <?php elseif ($mode === 'edit'): ?>
        <h2>✏️ Edit Tamu</h2>
        <form method="post" onsubmit="return validasiForm()">
            <input type="hidden" name="id" value="<?= $data['id'] ?>">
            <div class="row">
                <label class="label">Nama</label>
                <input type="text" name="nama" id="nama"
                       value="<?= htmlspecialchars($data['nama']) ?>">
            </div>
            <div class="row">
                <label class="label">Alamat</label>
                <input type="text" name="alamat" id="alamat"
                       value="<?= htmlspecialchars($data['alamat']) ?>">
            </div>
            <button name="update" class="btn btn-success">Update</button>
            <a href="vw_tamu.php" class="btn btn-secondary">Batal</a>
        </form>
    <?php endif; ?>

</div>
<?php endif; ?>

<!-- ================= TABLE ================= -->
<div class="card">
    <h2>📋 Data Tamu</h2>
    <a href="?tambah=1" class="btn btn-primary" style="margin-bottom:10px;">➕ Tambah Tamu</a>

    <table>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>

        <?php $no=1; while ($row = $dataTamu->fetch_assoc()): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama']) ?></td>
            <td><?= htmlspecialchars($row['alamat']) ?></td>
            <td class="actions">
                <a href="?detail=<?= $row['id'] ?>" class="btn btn-secondary">Detail</a>
                <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning">Edit</a>
                <a href="?hapus=<?= $row['id'] ?>" class="btn btn-danger"
                   onclick="return confirm('Hapus data ini?')">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</div>

<script>
function validasiForm() {
    let nama = document.getElementById('nama').value.trim();
    let alamat = document.getElementById('alamat').value.trim();

    if (nama === '' || alamat === '') {
        alert("Nama dan alamat wajib diisi!");
        return false;
    }
    return true;
}
</script>

</body>
</html>
