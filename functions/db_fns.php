<?php

function db_connect() {
  $result = new mysqli("localhost", "skin", "skin123","skin");
  if ($result->connect_error) {
    echo "Connect failed: s\n", $result->connect_error;
  }

   if (!$result) {
      return false;
   } 
   //$result->autocommit(TRUE);
   return $result;

}
function getip(){
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) 
            $ip = getenv("HTTP_CLIENT_IP");
    else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) 
            $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) 
            $ip = getenv("REMOTE_ADDR");
    else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) 
            $ip = $_SERVER['REMOTE_ADDR'];
    else 
            $ip = "unknown";
    return($ip);
}
function register($Email, $Password, $Name){
  $IP = getip();
  $conn=db_connect();
  $conn->query("SET NAMES UTF8");
  $result = $conn->query("select * from User_Info where Email='".$Email."'");
  if ($result->num_rows>0) {
    return false;
  } else {
    $result = $conn->query("insert into User_Info (Name, Email, Password, IP) values ('".$Name."','".$Email."','".$Password."','".$IP."')");
    if($result){
      return 1;
    }else{
      return 0;
    }
  }
}
function login($Email, $Password){
  $conn=db_connect();
  $conn->query("SET NAMES UTF8");
  $result = $conn->query("select * from User_Info where Email='".$Email."'");
  while($rows = $result->fetch_assoc()){
    if(password_verify($Password,$rows['Password'])){
      return true;
    }else{
      return false;
    }
  }
}
function login_ID($ID, $Password){
  $conn=db_connect();
  $conn->query("SET NAMES UTF8");
  $result = $conn->query("select * from User_Info where ID='".$ID."'");
  while($rows = $result->fetch_assoc()){
    if(password_verify($Password,$rows['Password'])){
      return true;
    }else{
      return false;
    }
  }
}
function get_user($Email){
  $conn=db_connect();
  $conn->query("SET NAMES UTF8");
  $result = $conn->query("select * from User_Info where Email='".$Email."'");
  while($rows = $result->fetch_assoc()){
    return $rows["Name"];
  }
}
function get_ID($Email){
  $conn=db_connect();
  $conn->query("SET NAMES UTF8");
  $result = $conn->query("select * from User_Info where Email='".$Email."'");
  while($rows = $result->fetch_assoc()){
    return $rows["ID"];
  }
}
function add_product_ID($ID,$Email){
	$conn=db_connect();
	$result = $conn->query("select * from User_Info where Email='".$Email."' and ID='".$ID."'");
	if($result->num_rows==0){
		$result = $conn->query("update User_Info set ID = '".$ID."' where Email='".$Email."'");
		if($result){
			return true;
		}else{
			echo "更新错误";
			return false;
		}
	}else{
		echo "已经绑定产品！";
		return false;
	}

}
/*function db_result_to_array($result) {
   $res_array = array();
   
   for ($count=0; $row = $result->fetch_assoc(); $count++) {
     $res_array[$count] = $row;
   }
   
   return $res_array;
}
function get_detail($table_name){
    $conn=db_connect();
    if($table_name=="seq"){
        $query="select * from seq order by stat DESC, SeqKind,AcceptTime_seq, SampleName";
    }else{
        $query="select * from $table_name order by AcceptTime_lib,SampleName";
    }
if($table_name == 'complete'){
$query="select * from $table_name order by CompleteTime DESC,Lane, SampleName";
}
$conn->query("SET NAMES UTF8");
$result=$conn->query($query);
if(!$result){
return false;
}
return $result;
}
*/
function get_titles($Category){
  $conn=db_connect();
  $query="select * from Term_Description where Category like '".$Category."'";
#  $query="select * from Term_Description";

  $conn->query("SET NAMES UTF8");
  $result=$conn->query($query);
  if(!$result){
    return false;
  }else{
    return $result;
  }
}
/*
function get_term($Category,$Title){
  $conn=db_connect();
  $query="select * from Term_Description where Category like '%".$Category."%' and Title like '%".$Title."%'";
#  $query="select * from Term_Description";

  $conn->query("SET NAMES UTF8");
  $result=$conn->query($query);
  if(!$result){
    return false;
  }
  while($rows = $result->fetch_assoc()){
    $genefactor = str_replace("：","：<br>",$rows["Gen_F"]);
    $genefactor = str_replace("；","；<br>",$genefactor);
    $envfactor = str_replace("：","：<br>",$rows["Env_F"]);
    $envfactor = str_replace("；","；<br>",$envfactor);
    echo "<tr><td class='col1'>项目描述</td><td>".$rows["Description"]."</td></tr><tr>
              <td class='col1'>遗传因素</td><td>".$genefactor."</td></tr><tr>
              <td class='col1'>外界因素</td><td>".$envfactor."</td></tr>";
  }
}
*/
function get_danger_level($Category,$Title){
  $conn=db_connect();
  $query="select * from Solution where Category like '".$Category."' and Title like '".$Title."'";
#  echo $query;
#  $query="select * from Term_Description";
  $conn->query("SET NAMES UTF8");
  $result=$conn->query($query);
  if(!$result){
    return false;
  }
  $levels = array();
  while ($rows = $result->fetch_assoc()) {
    $levels[$rows["Score"]]=$rows["Phenotype"];
  }
  return $levels;

/*  while($rows = $result->fetch_assoc()){
    #echo "<tr><td class='col1'>食物护理</td><td>".$rows["Food"]."</td></tr>";
    $food = explode("：", $rows["Food"]);
    echo "<tr><td class='col1'>食物护理</td><td>".$food[0]."</td></tr>";
    display_food($rows["Food"]);
    echo "<tr><td class='col1'>内服建议</td><td>".$rows["Oral"]."</td></tr><tr>
              <td class='col1'>护肤建议</td><td>".$rows["Pro"]."</td></tr><tr>
              <td class='col1'>医疗措施</td><td>".$rows["Top"]."</td></tr>";
  }
*/
}

function get_solution($Category,$Title,$Score){
  $conn=db_connect();
  $query="select * from Solution where Category like '".$Category."' and Title like '".$Title."' and Score = ".$Score;
#  echo $query;
#  $query="select * from Term_Description";
  $conn->query("SET NAMES UTF8");
  $result=$conn->query($query);
  if(!$result){
    return false;
  }else{
#    echo "gggg";
    return $result;
  }
/*  while($rows = $result->fetch_assoc()){
    #echo "<tr><td class='col1'>食物护理</td><td>".$rows["Food"]."</td></tr>";
    $food = explode("：", $rows["Food"]);
    echo "<tr><td class='col1'>食物护理</td><td>".$food[0]."</td></tr>";
    display_food($rows["Food"]);
    echo "<tr><td class='col1'>内服建议</td><td>".$rows["Oral"]."</td></tr><tr>
              <td class='col1'>护肤建议</td><td>".$rows["Pro"]."</td></tr><tr>
              <td class='col1'>医疗措施</td><td>".$rows["Top"]."</td></tr>";
  }
*/
}
function get_advices(){
  $conn=db_connect();
  $query='select * from Solution where Score = -1 and Advice !="" limit 5';
#  echo $query;
#  $query="select * from Term_Description";
  $conn->query("SET NAMES UTF8");
  $result=$conn->query($query);
  if(!$result){
    return false;
  }else{
    return $result;
  }
}

function display_brand($term,$title){
	$conn=db_connect();
	$conn->query("SET NAMES UTF8");
	$query="select * from Category_Function where Category like '".$term."' and Title like '".$title."'";
	$result=$conn->query($query);
	$rows = mysqli_fetch_array($result);
	$functions = explode(";", $rows["Function"]);
	$brands=array();
	foreach ($functions as $function) {
		$query="select * from Function_Brand where Function like '".$function."' ORDER BY RAND() limit 1";
		$result=$conn->query($query);
		$rows = mysqli_fetch_array($result);
		$brand = $rows["Brand"];
		$brands[]=$brand;
#		array_push($brands, $brand);
	}
	$brand_name=array();
	$brand_url=array();
	$brand_price= array();
	$brand_score= array();
	foreach ($brands as $brand) {
		$brand_name[]=$brand;
		$query="select * from Brand where Brand like '".$brand."' limit 1";
		$result=$conn->query($query);
		$brand = mysqli_fetch_array($result);
		$brand_url[]=$brand["Img_url"];
		$brand_price[]=$brand["Price"];
		$brand_score[]=$brand["Score"];
#		echo "<td style='width:16%'><img src='".$brand["Img_url"]."' width='100%' style='display: block;' /></td>";
	}
	echo "<tr><td class='col1'></td><td><table><tr>";
	#echo "<button type='button' class='btn btn-lg btn-danger bd-popover' data-toggle='popover' title='Popover title' data-content='And here's some amazing content. It's very engaging. Right?'>Click to toggle popover</button>";
	#echo "<a tabindex='0' class='btn btn-lg btn-danger bd-popover' role='button' data-toggle='popover' data-trigger='focus' title='Dismissible popover' data-content='And here is some amazing content. It is very engaging. Right?'>Dismissible popover</a>";
    for ($i=0; $i < 4; $i++) {
	    if(!empty($brand_name[$i])){
	      echo "<td style='width:23%'><img src='".$brand_url[$i]."' width='100%' style='display: block;' /></td>";
	    }else{
	      echo "<td></td>";
	    } 
	}
	echo "</tr><tr>";
	for ($i=0; $i < 4; $i++) {
	    if(!empty($brand_name[$i])){
	      #echo "<td style='text-align: center;'>".mb_substr($brand_name[$i], 0, 6,"utf-8")."...</td>";
	      echo "<td style='text-align: center;'><a tabindex='0' class='bd-popover' data-placement='auto' data-html='true' data-toggle='popover' data-trigger='focus' title='".$brand_name[$i]."' data-content='市场价格：".$brand_price[$i]."元<br />用户评分：".$brand_score[$i]."'>".mb_substr($brand_name[$i], 0, 6,"utf-8")."...</a></td>";
	    }else{
	      echo "<td></td>";
	    } 
	}	
	echo "</tr></table></td></tr>";
 /*$food = str_replace('。',"",$food[1]);
  $food = str_replace('等',"",$food);
  $foods = explode("、",$food);
  echo "<tr><td class='col1'></td><td><table><tr>";
  for ($i=0; $i < 6; $i++) {
    if($foods[$i]){
      echo "<td style='width:16%'><img src='../icon/".get_food_id($foods[$i]).".gif' width='100%' style='display: block;' /></td>";
    }else{
      echo "<td></td>";
    } 
  }
  echo "</tr><tr>";
  for ($i=0; $i < 6; $i++) {
    if($foods[$i]){
      echo "<td style='text-align: center;'>".$foods[$i]."</td>";
    }else{
      echo "<td></td>";
    } 
  }
  echo "</tr></table></td></tr>";*/
}
function display_food($food){
  $food = explode("：", $food);
  $food = str_replace('。',"",$food[1]);
  $food = str_replace('等',"",$food);
  $foods = explode("、",$food);
  echo "<tr><td class='col1'></td><td><table><tr>";
  for ($i=0; $i < 6; $i++) {
    if(!empty($foods[$i])){
      echo "<td style='width:16%'><img src='../icon/".get_food_id($foods[$i]).".gif' width='100%' style='display: block;' /></td>";
    }else{
      echo "<td></td>";
    } 
  }
  echo "</tr><tr>";
  for ($i=0; $i < 6; $i++) {
    if(!empty($foods[$i])){
      echo "<td style='text-align: center;'>".$foods[$i]."</td>";
    }else{
      echo "<td></td>";
    } 
  }

/*  foreach ($foods as $value) {
    echo "<td style='width:16%'><img src='../icon/".get_food_id($value).".gif' width='100%' style='display: block;' /></td>";
  }
  echo "</tr><tr>";
  foreach ($foods as $value) {
    echo "<td style='text-align: center;'>".$value."</td>";
  }
  */
  echo "</tr></table></td></tr>";
}
function get_food_id($food){
  $conn=db_connect();
  $query="select * from Icon where NAME like '".$food."'";
  $conn->query("SET NAMES UTF8");
  $result=$conn->query($query);
  while($rows = $result->fetch_assoc()){
    return $rows["ID"];
  }
}

function get_score($term,$title,$ID){
  $conn=db_connect();
  $score=0;
  $query="select * from Site_Info where Category like '".$term."' and Title like '".$title."'";
  $conn->query("SET NAMES UTF8");
  $result=$conn->query($query);
  if(!$result){
    echo "query error";
  }
  $rsset=array();
  while($rows = $result->fetch_assoc()){
    array_push($rsset, $rows["RSID"]);
  }
  $rsset=array_unique($rsset);
  $rscount=0;
  foreach ($rsset as $rs) {
    $genotype=get_rs_genotype($rs,$ID);
    if(!$genotype){
      continue;
    }
    $rscount=$rscount+1;
    $query="select * from Site_Info where Category like '".$term."' and Title like '".$title."' and Genotype like '".$genotype."' and RSID like '".$rs."'";
    $result=$conn->query($query);
    while($rows = $result->fetch_assoc()){
      $score=$score+$rows["Score"];
    }
  }
  if($rscount>0){
    $score=$score/$rscount;
    return $score;
  }else{
    return false;
  }
}
function get_term_score($term,$ID){
  $conn=db_connect();
  $score=0;
  $query="select * from Site_Info where Category like '".$term."'";
  $conn->query("SET NAMES UTF8");
  $result=$conn->query($query);
  if(!$result){
    echo "query error";
  }
  $titles=array();
  while($rows = $result->fetch_assoc()){
    array_push($titles, $rows["Title"]);
  }
  $num=0;
  $titles=array_unique($titles);
  foreach ($titles as $key ) {
    $tscore=get_score($term,$key,$ID);
    if(is_nan($tscore)){
      continue;
    }
    $num=$num+1;
    $score = $score+$tscore+1;
  }
  if($num>0){
    $score = ceil(100*$score/2/$num);
    return $score;
  }else{
    return false;
  }
}
function get_rs_genotype($rs,$ID){
  $conn=db_connect();
  $query="select * from User_Data where ID like '".$ID."' and RSID like '".$rs."'";
  $conn->query("SET NAMES UTF8");
  $result=$conn->query($query);
  if(!$result){
    return false;
  }else{
    while($rows = $result->fetch_assoc()){
      return $rows["Genotype"];
    }
  }
}
?>
