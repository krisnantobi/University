<?php
  $kode_barang   = get('kode_barang');
  $kode_supplier = get('kode_supplier');
  $barang   = $db->findAll('barang');
  $supplier = $db->findAll('supplier');

  if ($kode_barang || $kode_supplier) {
    $data = $db->query("SELECT * FROM stok  
                        INNER JOIN barang ON stok.kode_barang=barang.kode_barang 
                        INNER JOIN supplier ON stok.kode_supplier=supplier.kode_supplier 
                        WHERE stok.kode_barang LIKE '%$kode_barang%' 
                        AND stok.kode_supplier LIKE '%$kode_supplier%'");
  } else {
    $data = $db->query("SELECT * FROM stok 
                        INNER JOIN barang ON stok.kode_barang=barang.kode_barang 
                        INNER JOIN supplier ON stok.kode_supplier=supplier.kode_supplier");
  }
?>

<div class="main-header">
  <h2>Tabel Stok</h2>
  <a href="?p=stok/create"><b>Tambah Stok</b></a>
  
  <form action="?p=stok/index" class="mt-20">
    <label>Filter by </label>
    <input type="hidden" name="p" value="stok/index" >
    <select name="kode_barang" class="input-search">
      <option value="">Pilih Barang</option>
      <?php
        foreach ($barang as $value) {
          ?>
          <option 
            value="<?= $value['kode_barang'] ?>"
            <?= ($kode_barang == $value['kode_barang'])? 'selected': '' ?>
            ><?= $value['nama_barang'] ?></option>
          <?php        
        }
      ?>
    </select>
    <select name="kode_supplier" class="input-search">
      <option value="">Pilih supplier</option>
      <?php
        foreach ($supplier as $value) {
          ?>
          <option 
            value="<?= $value['kode_supplier'] ?>"
            <?= ($kode_supplier == $value['kode_supplier'])? 'selected': '' ?>
            ><?= $value['nama_supplier'] ?></option>
          <?php        
        }
      ?>
    </select>
    <input type="submit" name="search" value="Filter">
  </form>
</div>

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Nama Barang</th>
      <th>Nama Supplier</th>
      <th>Stok</th>
      <th>Pilihan</th>
    </tr>
  </thead>
  <tbody>
    <?php
    foreach ($data as $key => $value) {
      ?>
        <tr>
          <td><?= ++$key ?></td>
          <td><?= $value['nama_barang']?></td>
          <td><?= $value['nama_supplier']?></td>
          <td><?= $value['jumlah']?></td>
          <td>
              <a href="?p=stok/delete&id=<?= $value['kode_stok'] ?>"><b>Delete</b></a> | 
              <a href="?p=stok/edit&id=<?= $value['kode_stok'] ?>"><b>Update</b></a>
          </td>
        </tr>
      <?php
    }
    ?>
  </tbody>
</table>
