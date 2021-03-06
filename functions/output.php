<?php
include ('db_fns.php');


function report_content($term){
	$contents = get_titles($term);
	while($rows = $contents->fetch_assoc()){
	$frequence = rand(0,100);
    $title = $rows["Title"];
    if (isset($_SESSION['ID'])) {
        $score = get_score($term,$title,$_SESSION['ID']);
        if($score>0.3){
           $score=1;
        }
        if($score<-0.3){
           $score=-1;
        }
        if($score<=0.3 && $score>=-0.3){
           $score=0;
        }
    }else{
        $score = rand(0,2)-1;
    }
	if(!is_nan($score)){
    $csstitle = str_replace("/", "_", $title);
    $genefactor = str_replace("：","：<br>",$rows["Gen_F"]);
    $genefactor = str_replace("；","；<br>",$genefactor);
    $envfactor = str_replace("：","：<br>",$rows["Env_F"]);
    $envfactor = str_replace("；","；<br>",$envfactor);
    $levels = get_danger_level($term,$title);
    switch ($score)
	{
		case -1:
		    $level = "panel-heading-danger";
            $button = '<button type="button" class="btn btn-danger disabled">'.$levels["-1"].'</button>';
		    break;
		case 0:
		    $level = "panel-heading-normal";
            $button = '<button type="button" class="btn btn-warning disabled">'.$levels["0"].'</button>';
		    break;
		case 1:
		    $level = "panel-heading-good";
            $button = '<button type="button" class="btn btn-success disabled">'.$levels["1"].'</button>';
		    break;
	}
    $solutions = get_solution($term,$title,$score);
    $solution = mysqli_fetch_array($solutions);
    #$affect = $solution["Phenotype"];
    $affect = $solution["Interpretation"];
    $food = $solution["Food"];
	$food_support = $solution["Oral"];
	$skin_support = $solution["Pro"];
	$drug_support = $solution["Top"];
    $advice = $solution["Advice"];
    ?>
    	<div class="col-lg-6">
        <div class="panel panel-default">
            <div class=<?php echo $level; ?> >
                <?php echo $title; ?>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href=<?php echo '"#result-'.$csstitle.'"'; ?> data-toggle="tab">检测结果</a>
                    </li>
                    <li><a href=<?php echo '"#description-'.$csstitle.'"'; ?> data-toggle="tab">项目描述</a>
                    </li>
                    <?php
                    if(strlen($food_support)>1){
                        echo '<li><a href="#food_support-'.$csstitle.'" data-toggle="tab">膳食推荐</a></li>';
                    }
                    if(strlen($skin_support)>1){
                        echo '<li><a href="#skin_support-'.$csstitle.'" data-toggle="tab">护肤参考</a></li>';
                    }
                    if(strlen($drug_support)>1){
                        echo '<li><a href="#drug_support-'.$csstitle.'" data-toggle="tab">医嘱措施</a></li>';
                    }
                    if(strlen($advice)>1){
                        echo '<li><a href="#advice-'.$csstitle.'" data-toggle="tab">指导建议</a></li>';
                    }
                    ?>

                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane fade in active" id=<?php echo '"result-'.$csstitle.'"'; ?> >
                        <!--<h4><?php echo $title.$affect; ?></h4> -->
                        <p></p>
                        <p><?php  echo $button; ?></p>
                        <p><?php echo $affect; ?></p>
                        <span class="chart" data-percent=<?php echo '"'.$frequence.'"'; ?> data-scale-color="#ffb400"><span class="percent"></span></span>
                        <span>人群中有<?php echo $frequence; ?>%的人和您一致</span>
                    </div>
                    <div class="tab-pane fade" id=<?php echo '"description-'.$csstitle.'"'; ?>>
                        <h4>项目描述</h4>
                        <p><?php echo $rows["Description"] ; ?></p>
                        <p><?php echo $genefactor ; ?></p>
                        <p><?php echo $envfactor ; ?></p>
                    </div>
                    <div class="tab-pane fade" id=<?php echo '"food_support-'.$csstitle.'"'; ?>>
                        <h4>膳食建议</h4>
                        <p><?php echo $food_support; display_food($food); ?></p>
                    </div>
                    <div class="tab-pane fade" id=<?php echo '"skin_support-'.$csstitle.'"'; ?>>
                        <h4>护肤参考</h4>
                        <p><?php echo $skin_support;  echo display_brand($term,$title); ?></p>
                    </div>
                    <div class="tab-pane fade" id=<?php echo '"drug_support-'.$csstitle.'"'; ?>>
                        <h4>医嘱措施</h4>
                        <p><?php echo $drug_support; ?></p>
                    </div>
                    <div class="tab-pane fade" id=<?php echo '"advice-'.$csstitle.'"'; ?>>
                        <h4>指导建议</h4>
                        <p><?php echo $advice; ?></p>
                    </div>
                </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <?php
	
      }
	}
}

function report_advices(){
    $contents = get_advices();
    while($solution = $contents->fetch_assoc()){
        $title = $solution["Title"];
        $csstitle = str_replace("/", "_", $title);
        $affect = $solution["Phenotype"];
        $advice = $solution["Advice"];
        ?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href=<?php echo "#".$csstitle; ?>><?php echo $title.$affect; ?></a>
            </h4>
        </div>
        <div id=<?php echo $csstitle; ?> class="panel-collapse collapse">
            <div class="panel-body">
                <?php echo $advice; ?>
            </div>
        </div>
    </div>
        <?php
    }

}



?>
