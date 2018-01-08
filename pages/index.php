<?php
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
			<?php
				if (isset($_SESSION['user']) && isset($_SESSION['ID'])) {
                    if(!get_term_score("紧致",$_SESSION['ID'])){
                        echo '<h1 class="page-header">示例报告              <a id="btn-login" href="#" class="btn">您的报告正在路上，请耐心等待！</a></h1>';
                    }else{
                        echo '<h1 class="page-header">欢迎'.$_SESSION['user'].'，这是您的结果报告';
                    }
				}else{
                    echo '<h1 class="page-header">示例报告              <a id="btn-login" href="add_product.php" class="btn">您还没有绑定产品，请点击绑定！</a></h1>';

				}
			?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
            	<!-- /.panel -->
                <!--    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> 主要特性汇总
                        </div>
                        <div class="panel-body">
                            <div id="morris-donut-chart"></div>
                        </div>
                    </div>
                -->
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-orange">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-align-justify fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php  echo isset($_SESSION['user']) ? "紧致  ".get_term_score("紧致",$_SESSION['ID']) : "紧致 80" ;?></div>
                                    <div>总体得分高于70%人群</div>
                                </div>
                            </div>
                        </div>
                        <a href="tightening.php">
                            <div class="panel-footer">
                                <span class="pull-left">查看详细信息</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-blue">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-magic fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php  echo isset($_SESSION['user']) ? "幻颜  ".get_term_score("幻颜",$_SESSION['ID']) : "幻颜 50" ;?></div>
                                    <div>总体得分高于90%人群</div>
                                </div>
                            </div>
                        </div>
                        <a href="beauty.php">
                            <div class="panel-footer">
                                <span class="pull-left">查看详细信息</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-heart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php  echo isset($_SESSION['user']) ? "呵护  ".get_term_score("呵护",$_SESSION['ID']) : "呵护 60" ;?></div>
                                    <div>总体得分高于80%人群</div>
                                </div>
                            </div>
                        </div>
                        <a href="care.php">
                            <div class="panel-footer">
                                <span class="pull-left">查看详细信息</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-coffee fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?php  echo isset($_SESSION['user']) ? "膳食  ".get_term_score("膳食",$_SESSION['ID']) : "膳食 50" ;?></div>
                                    <div>总体得分高于65%人群</div>
                                </div>
                            </div>
                        </div>
                        <a href="food.php">
                            <div class="panel-footer">
                                <span class="pull-left">查看详细信息</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            护肤概况及建议
                        </div>
                        <!-- .panel-heading -->
                        <div class="panel-body">
                            <div class="panel-group" id="accordion">
                                <?php
                                report_advices();
                                ?>
                                <!--
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Collapsible Group Item #3</a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                                        </div>
                                    </div>
                                </div>
                                -->
                            </div>
                        </div>
                        <!-- .panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>




            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->



    <!-- Morris Charts JavaScript -->
    <script src="../vendor/raphael/raphael.min.js"></script>
    <script src="../vendor/morrisjs/morris.min.js"></script>
    <script src="../data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->

</body>

</html>
