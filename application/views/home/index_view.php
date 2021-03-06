<?php
$q1 = "SELECT COUNT(*) AS jumlah FROM keranjang WHERE id_session = '". $this->session->userdata('id_session') ."'";
$q2 = "
  SELECT o.nama AS nama_obat
  FROM keranjang k
  INNER JOIN obat o
    ON k.kode_obat = o.kode_obat
  WHERE id_session = '". $this->session->userdata('id_session') ."'";

$jumlah_keranjang = $this->db->query($q1)->row()->jumlah;

$detail_keranjang = $this->db->query($q2)->result();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Apotek Berkah</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/css/main.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/dist/css/skins/skin-blue-light.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- jQuery 3 -->
  <script src="<?= base_url();?>assets/bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script type="text/javascript" src="<?= base_url();?>assets/js/bootstrap.min.js"></script>

  <!-- DataTable -->
  <link rel="stylesheet" href="<?= base_url(); ?>/assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"/>
</head>
<body class="hold-transition skin-blue-light layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="<?= site_url(); ?>" class="navbar-brand"><b>Apotek </b>Berkah</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#panel-navigasi">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <div id="panel-navigasi" class="collapse navbar-collapse pull-left">
          <ul class="nav navbar-nav">
            <li<?= uri_string() == 'obat' ? ' class="active"' : ''; ?>><a href="<?= site_url('obat'); ?>">Obat</a></li>
            <li<?= uri_string() == 'konfirmasi' ? ' class="active"' : '' ?>><a href="<?= site_url('konfirmasi'); ?>">Konfirmasi Pembayaran</a></li>
            <li<?= uri_string() == 'cek' ? ' class="active"' : '' ?>><a href="<?= site_url('cek'); ?>">Cek Pembelian</a></li>
          </ul>
        </div>
        
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <?php if($jumlah_keranjang > 0){ ?>

              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-shopping-cart"></i>
                  <span class="label label-warning"><?= $jumlah_keranjang; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Barang di keranjang : <?= $jumlah_keranjang; ?></li>
                  <li>
                    <ul class="menu">
                      <?php
                      $num = 1;
                      function classDefiner($num){
                        if($num == 1) $c = 'class="fa fa-medkit text-aqua"';
                        elseif($num % 3 == 0) $c = 'class="fa fa-medkit text-green"';
                        elseif($num % 5 == 0) $c = 'class="fa fa-medkit text-yellow"';
                        else $c = 'class="fa fa-medkit text-red"';
                        return $c;
                      }
                      foreach($detail_keranjang as $item):
                      ?>
                        <li>
                          <a href="#">
                            <i <?= classDefiner($num); ?>></i> <?= $item->nama_obat; ?>
                          </a>
                        </li>
                      <?php $num++; endforeach; ?>
                    </ul>
                  </li>
                  <li class="footer"><a href="<?= site_url('beli'); ?>">Lihat semua</a></li>
                </ul>
              </li>

            <?php } else { ?>
            
              <li>
                <a href="<?= site_url('beli'); ?>" title="Keranjang belanjaan">
                  <i class="fa fa-shopping-cart"></i>
                </a>
              </li>
            
            <?php } ?>

          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  
  <div class="content-wrapper">
    <div class="container">
      <section class="content-header">
        <?= isset($view_title) ? '<h1>' . $view_title . '</h1>' : ''; ?>
      </section>
      <section class="content">
        <?php $this->load->view('home/'. $view_name); ?>
      </section>
    </div>
  </div>
</div>
<!-- ./wrapper -->

<!-- DataTable -->
<script src="<?= base_url(); ?>/assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>/assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="<?= base_url();?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?= base_url();?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url();?>assets/dist/js/adminlte.min.js"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree()
  });

  <?php if(uri_string() == 'obat'){ ?>

    $(function() {
      $("#tabeldata").DataTable({
        "pagingType": "first_last_numbers"
      });
    })

  <?php } ?>
</script>
</body>
</html>