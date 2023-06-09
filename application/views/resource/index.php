<?php


ob_start();
?>
<div class="panel panel-default">
  <div class="panel-body">
    <form name="resource_search" id="resource_search" class="form-inline" method="get" action="<?php echo site_url('/resource/index') ?>">
      <div class="form-group">
        <input type="text" name="keywords" class="form-control" placeholder="Put one or more keyword(s) here" />
      </div>
      <div class="form-group">
        <?php $type_data = $this->Taxonomy_model->getForSelect('Type', 100, true); ?>
        <select name="type" class="form-control" >
          <option value="">ALL RESOURCE TYPE</option>
          <?php
            foreach ($type_data as $type) {
              echo '<option value="'.$type.'">'.$type.'</option>';
            }
          ?>
        </select>
      </div>
      
      <style type="text/css">
	body{
		font-family: sans-serif;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		padding: 3px 8px;
 
	}
	a{
		
		color: black;
		padding: 8px 10px;
		text-decoration: none;
		border-radius: 2px;
	}
	</style>
      <input type="submit" name="save" class="btn btn-primary" value="Search" />
      <div class="pull-right">
        <a class="btn btn-success" href="<?php echo site_url('/resource/add') ?>"><i class="glyphicon glyphicon-plus"></i> Add New Resource</a>
        <div class="btn-group">
          <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            Import Resource <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">From Bibtex (.bib) file</a></li>
            <li><a href="#">From URL</a></li>
            <li><a href="#">From Z39.50 SRU</a></li>
            <li><a href="#">From CSV file</a></li>
            <li><a href="#">From SLiMS</a></li>
          </ul>
        </div>
      </div>
    </form>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Author</th>
        <th>Subject</th>
        <th>Publish Year</th>
        <th>Publisher</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $n = 1;
      foreach ($records as $data) :
      ?>
      <tr>
        <td><?php echo $n ?></td><td><?php echo $data->title ?></td>
        <td><?php echo $data->authors ?></td><td><?php echo $data->subjects ?></td>
        <td><?php echo $data->publish_year ?></td><td><?php echo $data->publisher ?></td>
        <td><a class="btn btn-warning" href="<?php echo site_url('/resource/update/'.$data->id) ?>">Edit</a></td>
        <td><a class="btn btn-danger" data-confirm="Are you sure want to delete this resource?" href="<?php echo site_url('/resource/delete/'.$data->id) ?>">Delete</a></td>
      </tr>
      <?php
      $n++;
      endforeach;
      ?>
    </tbody>
  </table>
</div>
<?php
$main_content = ob_get_clean();
require './assets/themes/default/index.tpl.php';
?>