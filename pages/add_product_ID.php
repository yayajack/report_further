<?php
#include ('../functions/db_fns.php');
include ('../functions/header.php');
include ('../functions/output.php');

chead();
?>
<body>

    <div id="wrapper">

        <!-- Navigation -->

        <?php
        nav_info();
        ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-4">
			<?php 
				if (isset($_SESSION['user']) && isset($_SESSION['ID'])) {
					echo '<h1 class="page-header">欢迎'.$_SESSION['user'].'，这是您的结果报告';
				}else{
					echo '';
                    echo '<h1 class="page-header">绑定产品</a></h1>';
                 ?>
                    <div class="panel-body">
<?php
  if($_POST['ID']){
	$ID = $_POST['ID'];
	$Email = $_SESSION['Email'];
}else{
	echo "输入错误，请重新输入";
}


if (add_product_ID($ID,$Email)) {
	$_SESSION['ID'] = $ID;
	echo "<p>产品绑定成功！</p>";
}else{
	echo "";
}
?>
                    </div>
                 <?php
				}
			?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>

