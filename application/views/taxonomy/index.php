<?php
ob_start();
$save_message = $this->session->flashdata('save message');
if ($save_message) {
  echo '<div class="alert alert-success">';
  echo $save_message;
  echo '</div>' . "\n";
}

$delete_message = $this->session->flashdata('delete message');
if ($delete_message) {
  echo '<div class="alert alert-warning">';
  echo $delete_message;
  echo '</div>' . "\n";
}

$n = 1;
if ($page > 1) {
  $n = (($page * $per_page) - $per_page) + 1;
}
?>
<div class="panel panel-default">
  <div class="panel-body">
    <form name="taxonomy_search" id="taxonomy_search" class="form-inline" method="get" action="<?php echo site_url('/taxonomy/index/' . $type) ?>">
      <div class="form-group">
        <input type="text" name="keywords" class="form-control" placeholder="Cari Judul,Jenis,Penerbit,Dan Lain-lain" />
      </div>
      <input type="submit" name="save" class="btn btn-primary" value="Search" />
      <div class="pull-right">
        <a class="btn btn-success" href="<?php echo site_url('/taxonomy/add/' . $type) ?>"><i class="glyphicon glyphicon-plus"></i> Tambah Data</a>
      </div>
      <input type="hidden" name="type" value="<?php echo $type ?>" />
    </form>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
    <div class="list-group">
      <a href="<?php echo site_url('/taxonomy/index/subject') ?>" class="list-group-item<?php echo strtolower($type) == 'subject' ? ' active' : '' ?>"><i class="glyphicon glyphicon-tags"></i>Judul Buku</a>
      <a href="<?php echo site_url('/taxonomy/index/category') ?>" class="list-group-item<?php echo strtolower($type) == 'category' ? ' active' : '' ?>"><i class="glyphicon glyphicon-bookmark"></i> Pathfinder Kategori</a>
      <a href="<?php echo site_url('/taxonomy/index/type') ?>" class="list-group-item<?php echo strtolower($type) == 'type' ? ' active' : '' ?>"><i class="glyphicon glyphicon-open-file"></i> Jenis Buku</a>
      <a href="<?php echo site_url('/taxonomy/index/author') ?>" class="list-group-item<?php echo strtolower($type) == 'author' ? ' active' : '' ?>"><i class="glyphicon glyphicon-user"></i> Penulis</a>
      <a href="<?php echo site_url('/taxonomy/index/format') ?>" class="list-group-item<?php echo strtolower($type) == 'format' ? ' active' : '' ?>"><i class="glyphicon glyphicon-floppy-disk"></i> Format buku yang tersedia</a>
      <a href="<?php echo site_url('/taxonomy/index/location') ?>" class="list-group-item<?php echo strtolower($type) == 'location' ? ' active' : '' ?>"><i class="glyphicon glyphicon-map-marker"></i> Lokasi Buku</a>
      <a href="<?php echo site_url('/taxonomy/index/publisher') ?>" class="list-group-item<?php echo strtolower($type) == 'publisher' ? ' active' : '' ?>"><i class="glyphicon glyphicon-send"></i> Penerbit</a>
      <a href="<?php echo site_url('/taxonomy/index/place') ?>" class="list-group-item<?php echo strtolower($type) == 'place' ? ' active' : '' ?>"><i class="glyphicon glyphicon-map-marker"></i> Tempat Terbit</a>
      <a href="<?php echo site_url('/taxonomy/index/language') ?>" class="list-group-item<?php echo strtolower($type) == 'language' ? ' active' : '' ?>"><i class="glyphicon glyphicon-globe"></i> Bahasa</a>
    </div>
  </div>
  <div class="col-md-9">
    <?php
    if (!$records) {
      echo '<div class="alert alert-warning">';
      echo 'Sorry, no taxonomy data available yet';
      echo '</div>' . "\n";
    } else {
    ?>

      <table class="table table-bordered table-striped">
        <tr>
          <th style="width: 5%;">No.</th>
          <th>Nama Data</th>
          <th style="width: 5%;">Ubah</th>
          <th style="width: 5%;">Hapus</th>
        </tr>
        <?php
        foreach ($records as $data) :
        ?>
          <tr>
            <td><?php echo $n ?></td>
            <td><?php echo $data->name ?></td>
            <td><a class="btn btn-warning" href="<?php echo site_url('/taxonomy/update/' . $data->tid) ?>">Edit</a></td>
            <td><a class="btn btn-danger" href="<?php echo site_url('/taxonomy/delete/' . $data->tid) ?>" data-confirm="Are you sure want to delete this term?">Delete</a></td>
          </tr>
      <?php
          $n++;
        endforeach;
      } ?>
      </table>
      <?php echo $pagination; ?>
  </div>
</div>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>