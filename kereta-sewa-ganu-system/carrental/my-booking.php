<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
  header('location:index.php');
} else {

  if (isset($_POST['send'])) {

    // $allowedFileTypes = ['image/jpeg', 'image/png']; // List of allowed file types
    $vimage1 = $_FILES["img1"]["name"];

    if (!empty($vimage1)) {

      // Validate file type
      $allowedFileTypes = ['image/jpeg', 'image/png']; // List of allowed file types
      $uploadedFileType = $_FILES['img1']['type'];

      if (!in_array($uploadedFileType, $allowedFileTypes)) {
        echo "<script>alert('Failed! Only JPEG/JPG/PNG image files allowed.');</script>";
        echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";        exit;
    }
    $id = $_POST['payId'];
    $status = 1;
    move_uploaded_file($_FILES["img1"]["tmp_name"], "uploads/" . $_FILES["img1"]["name"]);
    $sql = "update tblpayment set image=:vimage1, status=:status where id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':vimage1', $vimage1, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->execute();

    echo "<script>alert('Payment Proof Uploaded!');</script>";
    echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";  }

    else{
      echo "<script>alert('Failed! No Image was Chosen.');</script>";
    echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";
    }}

  if(isset($_REQUEST['eid']))
	{
    $eid=intval($_GET['eid']);
    $status="2";
    $sql = "UPDATE tblbooking SET Status=:status WHERE  id=:eid";
    $query = $dbh->prepare($sql);
    $query -> bindParam(':status',$status, PDO::PARAM_STR);
    $query-> bindParam(':eid',$eid, PDO::PARAM_STR);
    $query -> execute();
      echo "<script>alert('Booking Successfully Cancelled');</script>";
      echo "<script type='text/javascript'> document.location = 'my-booking.php'; </script>";

}

?>
  <!DOCTYPE HTML>
  <html lang="en">

  <head>

    <title>Kereta Sewa Ganu - Tempahan</title>
    <!--Bootstrap -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
    <!--Custome Style -->
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
    <!--OWL Carousel slider-->
    <link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
    <!--slick-slider -->
    <link href="assets/css/slick.css" rel="stylesheet">
    <!--bootstrap-slider -->
    <link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
    <!--FontAwesome Font Style -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- SWITCHER -->
    <link rel="stylesheet" id="switcher-css" type="text/css" href="assets/switcher/css/switcher.css" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/red.css" title="red" media="all" data-default-color="true" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/orange.css" title="orange" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/pink.css" title="pink" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/green.css" title="green" media="all" />
    <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/purple.css" title="purple" media="all" />

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="assets/images/favicon-icon/ksg_logo.png">
    <!-- Google-Font-->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
  </head>

  <body>

    <!-- Start Switcher -->
    <!-- <?php include('includes/colorswitcher.php'); ?> -->
    <!-- /Switcher -->

    <!--Header-->
    <?php include('includes/header.php'); ?>
    <!--Page Header-->
    <!-- /Header -->

    <!--Page Header-->
    <section class="page-header profile_page">
      <div class="container">
        <div class="page-header_wrap">
          <div class="page-heading">
            <h1>Senarai Tempahan</h1>
          </div>
          <ul class="coustom-breadcrumb">
            <li><a href="#">Utama</a></li>
            <li>Senarai Tempahan</li>
          </ul>
        </div>
      </div>
      <!-- Dark Overlay-->
      <div class="dark-overlay"></div>
    </section>
    <!-- /Page Header-->

    <?php
    $useremail = $_SESSION['login'];
    $sql = "SELECT * from tblusers where EmailId=:useremail ";
    $query = $dbh->prepare($sql);
    $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    $cnt = 1;
    if ($query->rowCount() > 0) {
      foreach ($results as $result) { ?>
        <section class="user_profile inner_pages">
          <div class="container">
            <div class="user_profile_info gray-bg padding_4x4_40">
              <div class="upload_user_logo"> <img src="assets/images/cat-profile.png" alt="image">
              </div>

              <div class="dealer_info">
                <h5><?php echo htmlentities($result->FullName); ?></h5>
                <p><?php echo htmlentities($result->Address); ?><br>
                  <?php echo htmlentities($result->City); ?>&nbsp;<?php echo htmlentities($result->Country);
                                                                }
                                                              } ?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-3">
                <?php include('includes/sidebar.php'); ?>

                <div class="col-md-8 col-sm-8">
                  <div class="profile_wrap">
                    <h5 class="uppercase underline">Senarai Tempahan </h5>
                    <div class="my_vehicles_list">
                      <ul class="vehicle_listing">
                        <?php
                        $useremail = $_SESSION['login'];
                        $sql = "SELECT tblvehicles.Vimage1 as Vimage1,tblvehicles.VehiclesTitle,tblvehicles.id as vid,tblbrands.BrandName, tblbooking.FromDate,tblbooking.ToDate,tblbooking.message,tblbooking.Status,tblvehicles.PricePerDay,DATEDIFF(tblbooking.ToDate,tblbooking.FromDate) as totaldays,tblbooking.BookingNumber, tblbooking.id as bookId, tblpayment.*, tblpayment.id as payId, tblpayment.status as statusPay from tblpayment join tblbooking on tblpayment.bookingId = tblbooking.id join tblvehicles on tblbooking.VehicleId=tblvehicles.id join tblbrands on tblbrands.id=tblvehicles.VehiclesBrand where tblbooking.userEmail=:useremail order by tblbooking.id desc";
                        $query = $dbh->prepare($sql);
                        $query->bindParam(':useremail', $useremail, PDO::PARAM_STR);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                          foreach ($results as $result) {  ?>

                            <li>
                              <h4 style="color:red">Nombor Tempahan #<?php echo htmlentities($result->BookingNumber); ?></h4>
                              <!-- <h4 style="color:red">Nombor Payment #<?php echo htmlentities($result->payId); ?></h4>
                              <h4 style="color:red">Nombor id booking #<?php echo htmlentities($result->bookId); ?></h4> -->
                              <div class="vehicle_img"> <a href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->Vimage1); ?>" alt="image"></a> </div>
                              <div class="vehicle_title">

                                <h6><a href="vehical-details.php?vhid=<?php echo htmlentities($result->vid); ?>"> <?php echo htmlentities($result->BrandName); ?> , <?php echo htmlentities($result->VehiclesTitle); ?></a></h6>
                                <p><b>Dari </b> <?php echo htmlentities($result->FromDate); ?> <b>To </b> <?php echo htmlentities($result->ToDate); ?></p>
                                <div style="float: left">
                                  <p><b>Mesej:</b> <?php echo htmlentities($result->message); ?> </p>

                                  <?php if ($result->Status == 1) { ?>
                                    <a href="#"><span class="badge alert-success">Disahkan</span></a>
                                    <?php if ($result->statusPay == 1) { ?>
                                    <a href="#"><span class="badge alert-danger">Dibayar</span></a>
                                    <?php } ?>
                                          <form method="post" enctype="multipart/form-data">
                                            <div class="input-group mb-3">
                                              <div class="custom-file">
                                                <a class="text-secondary" style="color:gray; font-size: small;"><i>Sila Muat Naik Bukti Pembayaran</i></a>
                                                <input type="hidden" class="custom-file-input" id="inputGroupFile01" name="payId" value="<?php echo htmlentities($result->payId); ?>">
                                                <input type="file" class="custom-file-input" id="inputGroupFile01" name="img1">
                                              </div><br>
                                            </div>
                                            <!-- <div class="form-group"> -->
                                            <button class="btn btn-primary" type="submit" name="send" type="submit">Hantar sini</button>
                                            <!-- </div> -->
                                          </form>
                                        </div>
                                        <!-- <input type="button" name="answer" value="Show Div" onclick="showDiv()" /> -->

                                        <!-- nm tambah button cancel -->

                                          <?php if($result->statusPay == 0){ ?>
                                            <div class="form-group">
                                                <div class="col-sm-1 col-sm-offset-10">
                                                    <div class="col-sm-12">
                                                        <a href="my-booking.php?eid=<?php echo htmlentities($result->bookId);?>" onclick="return confirm('Do you really want to Cancel this Booking')" class="btn btn-danger btn-sm">Batalkan Tempahan</a>
                                                    </div>
                                                </div>
                                            </div>

                                          <?php } ?>

                                  <?php } else if ($result->Status == 2) { ?>
                                    <a href="#"><span class="badge alert-danger">Dibatalkan</span></a>
                                    <div class="clearfix"></div>


                                  <?php } else { ?>
                                    <a href="#"><span class="badge alert-warning">Belum Disahkan</span></a>
                                    <div class="clearfix"></div>


                                  <?php } ?>
                                </div>
                              </div>
                            </li>

                            

                            <h5 style="color:blue">Invois</h5>
                            <table>
                              <tr>
                                <th>Kereta</th>
                                <th>Dari</th>
                                <th>Sehingga</th>
                                <th>Jumlah hari</th>
                                <th>Sewaan/Hari</th>
                              </tr>
                              <tr>
                                <td><?php echo htmlentities($result->VehiclesTitle); ?>, <?php echo htmlentities($result->BrandName); ?></td>
                                <td><?php echo htmlentities($result->FromDate); ?></td>
                                <td> <?php echo htmlentities($result->ToDate); ?></td>
                                <td><?php echo htmlentities($tds = $result->totaldays); ?></td>
                                <td> <?php echo htmlentities($ppd = $result->PricePerDay); ?></td>
                              </tr>
                              <tr>
                                <th colspan="4" style="text-align:center;"> Jumlah Keseluruhan</th>
                                <th><?php echo htmlentities($tds * $ppd); ?></th>
                              </tr>
                            </table>
                            <hr />
                          <?php }
                        } else { ?>
                          <h5 align="center" style="color:red">Tiada Tempahan</h5>
                        <?php } ?>


                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </section>
        <!--/my-vehicles-->
        <?php include('includes/footer.php'); ?>

        <!-- Scripts -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/interface.js"></script>
        <!--Switcher-->
        <script src="assets/switcher/js/switcher.js"></script>
        <!--bootstrap-slider-JS-->
        <script src="assets/js/bootstrap-slider.min.js"></script>
        <!--Slider-JS-->
        <script src="assets/js/slick.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script>
          function myFunction() {
            var x = document.getElementById("myDIV");
            if (x.style.display === "none") {
              x.style.display = "block";
            } else {
              x.style.display = "none";
            }
          }
        </script>
  </body>

  </html>
<?php } ?>
