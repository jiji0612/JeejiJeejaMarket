<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>รายการสินค้า</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Projects</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">รายการสินค้า</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">รายการสินค้า</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
              <i class="fas fa-minus"></i>
            </button>
          </div>
        </div>
        <div class="card-body p-0">
          <table class="table table-striped projects">
              <thead>
                  <tr>
                      <th style="width: 5%">
                          ลำดับ
                      </th>
                      <th style="width: 20%">
                          สินค้า
                      </th>
                      <th style="width: 15%">
                          รูปสินค้า
                      </th>
                      <th style="width: 20%">
                          ราคาขาย
                      </th>
                      <th style="width: 10%" class="text-center">
                          สถานะ
                      </th>
                      <th style="width: 30%">
                      </th>
                  </tr>
              </thead>
              <tbody>
                  <?php Include "dbconnhd.php"; 
                  $objQuery = mysqli_query ($conn,"select * from items order by cate,items_name asc");
                  $row_cnt = mysqli_num_rows($objQuery);
                  $i = 0;
                  while($objResult = mysqli_fetch_array($objQuery))
                  {
                      $itmid = $objResult["items_id"] ;
                      $itmname = $objResult["items_name"];
                      $itmdesc = $objResult["items_desc"];
                      $itmprice = $objResult["items_price"];
                      $imagefile = $objResult["image"];
                      $status = $objResult["items_status"];
                      $i = $i + 1;
                  ?>

                  <tr>
                      <td>
                      <?php echo $i; ?>
                      </td>
                      <td>
                          <a>
                            <?php echo $itmdesc; ?>
                          </a>
                          <br/>
                          <small>
                            <?php echo $itmid; ?>
                          </small>
                      </td>
                      <td>
                          <ul class="list-inline">
                              <li class="list-inline-item">
                                  <img alt="Avatar" class="table-avatar" src="../images/<?php echo $imagefile; ?>">
                              </li>
                          </ul>
                      </td>
                      <td>
                        <a>
                            <?php echo $itmprice; ?> บาท
                        </a>
                      </td>
                      <td class="project-state">
                          <span class="badge badge-success"><?php echo $status; ?></span>
                      </td>
                      <td class="project-actions text-right">
                          <a class="btn btn-primary btn-sm" href="#">
                              <i class="fas fa-folder">
                              </i>
                              View
                          </a>
                          <a class="btn btn-info btn-sm" href="#">
                              <i class="fas fa-pencil-alt">
                              </i>
                              Edit
                          </a>
                          <a class="btn btn-danger btn-sm" href="#">
                              <i class="fas fa-trash">
                              </i>
                              Delete
                          </a>
                      </td>
                  </tr>
                  
                <?php 
                    }
                    Include "dbconndt.php"; 
                ?>

              </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
