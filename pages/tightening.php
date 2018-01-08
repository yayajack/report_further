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
                <div class="col-lg-12">
                    <h1 class="page-header">紧致肌肤</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <?php
                    report_content("紧致");
                ?>
               <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->


</body>

</html>
