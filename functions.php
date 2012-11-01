<?php




// ECHO HTML FUNCTIONS


function echo_html_box($title, $body, $bars=1, $footer=0){
				
	echo "					<table class=box cellspacing=0 cellpadding=0><tr>\n";
	echo "						<td class=tl_corner>";
	if($bars)
		echo "<div class=bars1><div class=bars2><img class=bars_img src=\"img/bars.png\" /></div></div>\n						";
	echo "<img class=corner_img src=\"img/corner2.gif\" /></td>\n";
	echo "						<td".($footer?" id=footer":"")." class=t_border".($bars||$footer?"_wt":"")." rowspan=2>".($footer?"":"<div><span>").($bars||$footer?$title:"&nbsp;").($footer?"":"</span></div>")."</td>\n";
	echo "						<td class=tr_corner><img class=corner_img src=\"img/corner3.gif\" /></td>\n";
	echo "					</tr><tr>\n";
	echo "						<td class=l_border>&nbsp;</td>\n";
	echo "						<td class=r_border>&nbsp;</td>\n";
	echo "					</tr><tr>\n";
	echo "						<td class=l_border>&nbsp;</td>\n";
	echo "						<td".($footer?" id=footer":"")." class=box_center".($bars?"_wi":"").">".$body."</td>\n";
	echo "						<td class=r_border>&nbsp;</td>\n";
	echo "					</tr><tr>\n";
	echo "						<td class=bl_corner><img class=corner_img src=\"img/corner4.gif\" /></td>\n";
	echo "						<td class=b_border>&nbsp;</td>\n";
	echo "						<td class=br_corner><img class=corner_img src=\"img/corner5.gif\" /></td>\n";
	echo "					</tr></table>\n";

}





// GENERATE HTML FUNCTIONS


function generate_html_tree($conn, $top_id=null, $f=999999){
	if($f<1) $f=1;
	$gen="";
	$top_text="Home";
	$tree=Array();
	$trs=sql_query(query_select_all_menu_items(),$conn);
	while($tr=sql_fetch_array($trs)) {
		if($top_id==$tr["id"])
			$top_text=$tr["name"];
		$tree[count($tree)]=$tr;
	}
	$gen="<table class=map_tbl cellspacing=0 cellpadding=0><tr><td width=16><img class=icon_img src=\"img/".($top_id===null?"home":"folder").".png\"></td><td>".generate_html_node_link(Array("name"=>$top_text,"id"=>$top_id))."</td></tr></table>".generate_html_tree_sub($tree,$top_id,$f);
	return $gen;
}
function generate_html_tree_sub($tree,$parent,$f){
	$gen="<table id=tb_".$parent." class=map_ch cellspacing=0 cellpadding=0".($f>0?"":" style=\"display:none;\"").">";
	for($i=0;$i<count($tree);$i++){
		if($tree[$i]["parent"]==$parent){
			$temp1=generate_html_tree_sub($tree,$tree[$i]["id"],$f-1);
			if(!$temp1)
				$temp2="";
			else
				$temp2="<a onclick='if(tb_".$tree[$i]["id"].".style.display==\"none\"){tb_".$tree[$i]["id"].".style.display=\"inline\";this.getElementsByTagName(\"img\")[0].src=\"img/minus.png\"}else{tb_".$tree[$i]["id"].".style.display=\"none\";this.getElementsByTagName(\"img\")[0].src=\"img/plus.png\"}'><img class=icon_img src=\"img/".($f>1?"minus":"plus").".png\"></a>";
			$gen.="<tr><td width=16>".$temp2."</td><td><table class=map_tbl cellspacing=0 cellpadding=0><tr><td width=16><img class=icon_img src=\"img/".($tree[$i]["file_id"]===null?($tree[$i]["page_id"]===null?"folder":"page"):"file").".png\"></td><td>".generate_html_node_link($tree[$i])."</td></tr></table>".$temp1."</td></tr>";
		}
	}
	$gen.="</table>";
	if(strpos($gen,"<tr>")===false) // operator === is needed coz == will change the 2 operands to the same type before comparison and then 0 would be like false
		return "";
	return $gen;
}
function generate_html_node_link($arr,$sub="",$more=""){
	//return "<a href=\"".($arr[$sub."href"]?$arr[$sub."href"]:("topic.php?categ=".$arr[$sub."id"]))."\"".($arr[$sub."target"]?(" target=\"".$arr[$sub."target"]."\""):"").($more===""?"":(" ".$more)).">".$arr[$sub."name"]."</a>";
	return "<a href=\"topic.php?categ=".$arr[$sub."id"]."\" ".$more.">".$arr[$sub."name"]."</a>";
}


function generate_html_tree_manage($conn, $top_id=null, $f=999999){
	if($f<1) $f=1;
	$gen="";
	$top_text="Home";
	$tree=Array();
	$trs=sql_query(query_select_all_menu_items(),$conn);
	while($tr=sql_fetch_array($trs)) {
		if($top_id==$tr["id"])
			$top_text=$tr["name"];
		$tree[count($tree)]=$tr;
	}
	$gen="<table class=map_tbl cellspacing=0 cellpadding=0><tr><td width=16><img class=icon_img src=\"img/".($top_id===null?"home":"folder").".png\"></td><td>".generate_html_node_link(Array("name"=>$top_text,"id"=>$top_id))."</td><td class=r_btn_td>".($top_id===null?"":gen_btn($top_id,1))."</td></tr></table>".generate_html_tree_manage_sub($tree,$top_id,$f);
	return $gen;
}
function generate_html_tree_manage_sub($tree,$parent,$f){
	$gen="<table id=tb_".$parent." class=map_ch cellspacing=0 cellpadding=0".($f>0?"":" style=\"display:none;\"").">";
	for($i=0;$i<count($tree);$i++){
		if($tree[$i]["parent"]==$parent){
			$temp1=generate_html_tree_manage_sub($tree,$tree[$i]["id"],$f-1);
			if(!$temp1)
				$temp2="";
			else
				$temp2="<a onclick='if(tb_".$tree[$i]["id"].".style.display==\"none\"){tb_".$tree[$i]["id"].".style.display=\"inline\";this.getElementsByTagName(\"img\")[0].src=\"img/minus.png\"}else{tb_".$tree[$i]["id"].".style.display=\"none\";this.getElementsByTagName(\"img\")[0].src=\"img/plus.png\"}'><img class=icon_img src=\"img/".($f>1?"minus":"plus").".png\"></a>";
			$gen.="<tr><td width=16>".$temp2."</td><td><table class=map_tbl cellspacing=0 cellpadding=0><tr><td width=16><img class=icon_img src=\"img/".($tree[$i]["file_id"]===null?($tree[$i]["page_id"]===null?"folder":"page"):"file").".png\"></td><td>".generate_html_node_link($tree[$i])."</td><td class=r_btn_td>".($tree[$i]["page_id"]===null?($tree[$i]["file_id"]===null?(gen_btn($tree[$i]["id"],1).($temp2?"":(" ".gen_btn($tree[$i]["id"],2)." ".gen_btn($tree[$i]["id"],3)))):gen_btn($tree[$i]["id"],4)):"")."</td></tr></table>".$temp1."</td></tr>";
		}
	}
	$gen.="</table>";
	if(strpos($gen,"<tr>")===false) // operator === is needed coz == will change the 2 operands to the same type before comparison and then 0 would be like false
		return "";
	return $gen;
}
function gen_btn($id,$num){
	if($num==1)
		return "<a href=\"javascript: mng_create_child($id)\"><img class=icon_img alt=\"create child\" src=\"img/folder_add.png\"></a>";
	elseif($num==2)
		return "<a href=\"javascript: mng_attach_file($id)\"><img class=icon_img alt=\"attach file\" src=\"img/file_add.png\"></a>";
	elseif($num==3)
		return "<a href=\"javascript: mng_delete_node($id)\"><img class=icon_img alt=\"delete node\" src=\"img/folder_delete.png\"></a>";
	elseif($num==4)
		return "<a href=\"javascript: mng_delete_file($id)\"><img class=icon_img alt=\"delete attached file\" src=\"img/file_delete.png\"></a>";

	elseif($num==11)
		return "<a href=\"javascript: frm_delete_field($id)\"><img class=icon_img alt=\"delete field\" src=\"img/file_delete.png\"></a>";
	elseif($num==12)
		return "<a href=\"javascript: frm_delete_form($id)\"><img class=icon_img alt=\"delete form\" src=\"img/folder_delete.png\"></a>";
	elseif($num==13)
		return "<a href=\"javascript: frm_add_field($id)\"><img class=icon_img alt=\"add field\" src=\"img/file_add.png\"></a>";
	elseif($num==14)
		return "<a href=\"javascript: frm_add_form()\"><img class=icon_img alt=\"add form\" src=\"img/folder_add.png\"></a>";
}






// DATABSE FUNCTIONS

$DB_FUNC_PREFIX="my";

function sql_connect(){
	$t=func_get_args();
	global $DB_FUNC_PREFIX;
	return call_user_func_array($DB_FUNC_PREFIX.__FUNCTION__, $t);
}
function sql_data_seek(){
	$t=func_get_args();
	global $DB_FUNC_PREFIX;
	return call_user_func_array($DB_FUNC_PREFIX.__FUNCTION__, $t);
}
function sql_fetch_array(){
	$t=func_get_args();
	global $DB_FUNC_PREFIX;
	return call_user_func_array($DB_FUNC_PREFIX.__FUNCTION__, $t);
}
function sql_fetch_field(){
	$t=func_get_args();
	global $DB_FUNC_PREFIX;
	return call_user_func_array($DB_FUNC_PREFIX.__FUNCTION__, $t);
}
function sql_insert_id(){
	$t=func_get_args();
	global $DB_FUNC_PREFIX;
	if($DB_FUNC_PREFIX=="ms"){
		$ins_id=sql_fetch_array(sql_query("SELECT SCOPE_IDENTITY() AS id;",func_get_arg(0)));
		return $ins_id["id"];
	}
	return call_user_func_array($DB_FUNC_PREFIX.__FUNCTION__, $t);
}
function sql_num_fields(){
	$t=func_get_args();
	global $DB_FUNC_PREFIX;
	return call_user_func_array($DB_FUNC_PREFIX.__FUNCTION__, $t);
}
function sql_num_rows(){
	$t=func_get_args();
	global $DB_FUNC_PREFIX;
	return call_user_func_array($DB_FUNC_PREFIX.__FUNCTION__, $t);
}
function sql_query(){
	$t=func_get_args();
	global $DB_FUNC_PREFIX;
	return call_user_func_array($DB_FUNC_PREFIX.__FUNCTION__, $t);
}
function sql_real_escape_string(){
	$t=func_get_args();
	global $DB_FUNC_PREFIX;
	if($DB_FUNC_PREFIX=="ms"){
		return str_replace("'", "''", func_get_arg(0));
	}
	return call_user_func_array($DB_FUNC_PREFIX.__FUNCTION__, $t);
}
function sql_select_db(){
	$t=func_get_args();
	global $DB_FUNC_PREFIX;
	return call_user_func_array($DB_FUNC_PREFIX.__FUNCTION__, $t);
}


// DATABSE QUERIES

//TODO make them injection proof
//     use sql_real_escape_string
//TODO make them cross database compatible
//     quoting for mssql: []
//     quoting for mysql: ``



function query_insert_image($p, $t, $f) {
	$p = sql_real_escape_string($p);
	$t = sql_real_escape_string($t);
	$f = sql_real_escape_string($f);
	return "INSERT INTO  `images` ( `path` , `t` , `f` ) VALUES ( '$p',  '$t',  '$f' );";
}
function query_insert_user_epfl($f, $l, $e, $o, $g, $s) {
	$f = sql_real_escape_string($f);
	$l = sql_real_escape_string($l);
	$e = sql_real_escape_string($e);
	$o = sql_real_escape_string($o);
	$g = sql_real_escape_string($g);
	$s = sql_real_escape_string($s);
	return "INSERT INTO  `users` (`firstname` ,`lastname` ,`email` ,`org` ,`gaspar` ,`sciper` ) VALUES ( '$f',  '$l',  '$e',  '$o',  '$g',  '$s');";
}
function query_insert_user_guest($s, $a, $e, $o, $r) {
	$s = sql_real_escape_string($s);
	$a = sql_real_escape_string($a);
	$e = sql_real_escape_string($e);
	$o = sql_real_escape_string($o);
	$r = sql_real_escape_string($r);
	return "INSERT INTO  `users` ( `sex` , `age` , `education` , `ocountry` , `rcountry` ) VALUES ( '$s' ,  '$a' ,  '$e' ,  '$o' ,  '$r' );";
}
function query_insert_answer($u, $i, $r, $t) {
	$u = sql_real_escape_string($u);
	$i = sql_real_escape_string($i);
	$r = sql_real_escape_string($r);
	$t = sql_real_escape_string($t);
	return "INSERT INTO  `answers` ( `userid` ,`imageid` ,`result` ,`reaction` ) VALUES ( '$u',  '$i',  '$r',  '$t' );";
}
function query_select_all_images() {
	return "select * from (select id, path, rand() as r from images where id in (select id from images group by f, t) union select id, path, rand() as r from images) as b order by r";
	//return "SELECT id, path, RAND() AS R FROM `images`, (SELECT 1 UNION SELECT 2) AS T ORDER BY R;";
	//return "SELECT id, path, RAND() AS R FROM `images` ORDER BY R;";
}
function query_compute_stats($userid) {
	$userid = sql_real_escape_string($userid);
	return "SELECT discr, AVG( reaction ) /1000 AS reaction, SUM( CASE WHEN result =  'f' THEN 1 ELSE 0 END ) AS f , SUM( CASE WHEN result =  't' THEN 1 ELSE 0 END ) AS t FROM answers, images WHERE imageid = id AND userid = '$userid' GROUP BY discr;";
}
function query_select_all_stats() {
	return "select id, progress, consistency, sex, age, education, ocountry, rcountry, timestamp  from (SELECT userid as userid1, round(count(*) / 95 * 100) as progress  FROM answers group by userid) a, (SELECT userid as userid2, round(sum(CASE WHEN min = max THEN 1 ELSE 0 END) / count(*) * 100) as consistency FROM (SELECT userid, min(result) as min,   max(result) as max  FROM `answers` group by imageid, userid) as T GROUP BY userid) b, users Where userid1 = id and  userid2 = id";
}
function query_select_all_stats_with_filter_arr($arr) {
	$query = "select id, progress, consistency, sex, age, education, ocountry, rcountry, timestamp  from " .
			"(SELECT userid as userid1, round(count(*) / 95 * 100) as progress  FROM answers group by userid) a, " .
			"(SELECT userid as userid2, round(sum(CASE WHEN min = max THEN 1 ELSE 0 END) / count(*) * 100) as consistency FROM (SELECT userid, min(result) as min,   max(result) as max  FROM `answers` group by imageid, userid) as T GROUP BY userid) b, " .
			"users " .
			"where userid1 = id and  userid2 = id ";
	if(!empty($arr["p"])) {
		$query .= "and (" . str_replace("$", " `progress` ", $arr["p"]) . ")";
	}
	if(!empty($arr["c"])) {
		$query .= "and (" . str_replace("$", " `consistency` ", $arr["c"]) . ")";
	}
	if(!empty($arr["s"])) {
		$query .= "and (" . str_replace("$", " `sex` ", $arr["s"]) . ")";
	}
	if(!empty($arr["a"])) {
		$query .= "and (" . str_replace("$", " `age` ", $arr["a"]) . ")";
	}
	if(!empty($arr["e"])) {
		$query .= "and (" . str_replace("$", " `education` ", $arr["e"]) . ")";
	}
	if(!empty($arr["o"])) {
		$query .= "and (" . str_replace("$", " `ocountry` ", $arr["o"]) . ")";
	}
	if(!empty($arr["r"])) {
		$query .= "and (" . str_replace("$", " `rcountry` ", $arr["r"]) . ")";
	}
	if(!empty($arr["t"])) {
		$query .= "and (" . str_replace("$", " `timestamp` ", $arr["t"]) . ")";
	}
	return $query;
}
function query_select_stats_by_image($order) {
	$query = "select lo.cue as cue,  lo.path as lo_path, lo.lying as lo_lying , lo.nlying as lo_nlying , hi.nlying as hi_nlying , hi.lying as hi_lying , hi.path as hi_path     , lo.lying/lo.nlying as olo , hi.lying/hi.nlying as ohi " .
			"from " .
			"(select imageid,path,cue, SUM(CASE WHEN result =  'f' THEN 1 ELSE 0 END) as lying , SUM(CASE WHEN result =  't' THEN 1 ELSE 0 END) as nlying  from answers, images where id = imageid and discr = 50  group by imageid) as lo, " .
			"(select imageid,path,cue, SUM(CASE WHEN result =  'f' THEN 1 ELSE 0 END) as lying , SUM(CASE WHEN result =  't' THEN 1 ELSE 0 END) as nlying  from answers, images where id = imageid and discr = 100 group by imageid) as hi " .
			"where lo.cue = hi.cue ";
	if(!empty($order)) {
		$query .= "order by $order ";
	}
	return $query;
}
function query_select_stats_by_image_filtered($uids, $order) {
	$query = "select lo.cue as cue,  lo.path as lo_path, lo.lying as lo_lying , lo.nlying as lo_nlying , hi.nlying as hi_nlying , hi.lying as hi_lying , hi.path as hi_path     , lo.lying/lo.nlying as olo , hi.lying/hi.nlying as ohi " .
			"from " .
			"(select imageid,path,cue, SUM(CASE WHEN result =  'f' THEN 1 ELSE 0 END) as lying , SUM(CASE WHEN result =  't' THEN 1 ELSE 0 END) as nlying  from answers, images where id = imageid and userid IN ($uids) and discr = 50  group by imageid) as lo, " .
			"(select imageid,path,cue, SUM(CASE WHEN result =  'f' THEN 1 ELSE 0 END) as lying , SUM(CASE WHEN result =  't' THEN 1 ELSE 0 END) as nlying  from answers, images where id = imageid and userid IN ($uids) and discr = 100 group by imageid) as hi " .
			"where lo.cue = hi.cue ";
	if(!empty($order)) {
		$query .= "order by $order ";
	}
	return $query;
}
function query_select_stats_by_image_category_filtered($uids) {
	//$query = "select t,f, SUM(CASE WHEN result =  'f' THEN 1 ELSE 0 END) as lying , SUM(CASE WHEN result =  't' THEN 1 ELSE 0 END) as nlying , avg(reaction) as reaction from answers, images where id = imageid " . (empty($uids) ? "" : " and userid IN ($uids) ")." group by t,f order by t,f;";
	$query = "select t,f, round(avg((reaction - min ) / (max-min))*100,0) as reaction, sum(lying) as lying, sum(nlying) as nlying " .
			"from  " .
			"(select userid,t,f, avg(reaction) as reaction,  SUM(CASE WHEN result =  'f' THEN 1 ELSE 0 END) as lying , SUM(CASE WHEN result =  't' THEN 1 ELSE 0 END) as nlying from answers, images where id = imageid " . (empty($uids) ? "" : " and userid IN ($uids) ")." group by userid,t,f) as a, " .
			"( " .
			"    select userid, min(reaction) as min, max(reaction) as max " .
			"    from " .
			"    (select userid, avg(reaction) as reaction from answers, images where id = imageid " . (empty($uids) ? "" : " and userid IN ($uids) ")." group by userid,t,f) as a " .
			"    group by userid " .
			") as b " .
			"where a.userid = b.userid " .
			"group by t,f ";
	return $query;
}
function query_delete_participant_answers($userid) {
	$userid = sql_real_escape_string($userid);
	return "DELETE FROM `answers` where userid = '$userid';";
}
function query_delete_participant($userid) {
	$userid = sql_real_escape_string($userid);
	return "DELETE FROM `users` where id = '$userid';";
}




#######
# mysql_ affected_ rows
# mysql_ change_ user
# mysql_ client_ encoding
# mysql_ close
# mysql_ connect
# mysql_ create_ db
# mysql_ data_ seek
# mysql_ db_ name
# mysql_ db_ query
# mysql_ drop_ db
# mysql_ errno
# mysql_ error
# mysql_ escape_ string
# mysql_ fetch_ array
# mysql_ fetch_ assoc
# mysql_ fetch_ field
# mysql_ fetch_ lengths
# mysql_ fetch_ object
# mysql_ fetch_ row
# mysql_ field_ flags
# mysql_ field_ len
# mysql_ field_ name
# mysql_ field_ seek
# mysql_ field_ table
# mysql_ field_ type
# mysql_ free_ result
# mysql_ get_ client_ info
# mysql_ get_ host_ info
# mysql_ get_ proto_ info
# mysql_ get_ server_ info
# mysql_ info
# mysql_ insert_ id
# mysql_ list_ dbs
# mysql_ list_ fields
# mysql_ list_ processes
# mysql_ list_ tables
# mysql_ num_ fields
# mysql_ num_ rows
# mysql_ pconnect
# mysql_ ping
# mysql_ query
# mysql_ real_ escape_ string
# mysql_ result
# mysql_ select_ db
# mysql_ set_ charset
# mysql_ stat
# mysql_ tablename
# mysql_ thread_ id
# mysql_ unbuffered_ query
#######
# mssql_ bind
# mssql_ close
# mssql_ connect
# mssql_ data_ seek
# mssql_ execute
# mssql_ fetch_ array
# mssql_ fetch_ assoc
# mssql_ fetch_ batch
# mssql_ fetch_ field
# mssql_ fetch_ object
# mssql_ fetch_ row
# mssql_ field_ length
# mssql_ field_ name
# mssql_ field_ seek
# mssql_ field_ type
# mssql_ free_ result
# mssql_ free_ statement
# mssql_ get_ last_ message
# mssql_ guid_ string
# mssql_ init
# mssql_ min_ error_ severity
# mssql_ min_ message_ severity
# mssql_ next_ result
# mssql_ num_ fields
# mssql_ num_ rows
# mssql_ pconnect
# mssql_ query
# mssql_ result
# mssql_ rows_ affected
# mssql_ select_ db
#######



function connect_to_db($db_name){
	global $DB_FUNC_PREFIX;
	if($_SERVER["SERVER_ADDR"]=="127.0.0.1"){ // IF MY PC
		if($DB_FUNC_PREFIX=="ms"){ // IF SQL
			$Connection = sql_connect("XXXXXXXXXX","XXXXXXXXXX","XXXXXXXXXX");
			sql_select_db($db_name,$Connection) or die("ERROR: NO SUCH DATABASE");
		}else{ // IF MYSQL
			$Connection = sql_connect("XXXXXXXXXX","XXXXXXXXXX","XXXXXXXXXX");
			sql_select_db($db_name,$Connection) or die("ERROR: NO SUCH DATABASE");
		}
	}else{ // IF LIVE SERVER
		if($DB_FUNC_PREFIX=="ms"){ // IF SQL
			$Connection = sql_connect("XXXXXXXXXX","XXXXXXXXXX","XXXXXXXXXX");
			sql_select_db($db_name,$Connection) or die("ERROR: NO SUCH DATABASE");
		}else{ // IF MYSQL
			$Connection = sql_connect("XXXXXXXXXX","XXXXXXXXXX","XXXXXXXXXX");
			sql_select_db($db_name,$Connection) or die("ERROR: NO SUCH DATABASE");
		}
	}
	sql_query("set time_zone = '+1:00';", $Connection);
	return $Connection;
}








// BUSINESS LOGIC FUNCTIONS

// permissions functions WITHOUT recursion
function check_file_permission($conn,$user_hrid,$file_id){
	$t_perms=sql_query(query_check_file_permission($user_hrid,$file_id),$conn);
	$t_perm=sql_fetch_array($t_perms);
	if($t_perm)
		return true;
	return false;
}
function check_page_permission($conn,$user_hrid,$page_id){
	$t_perms=sql_query(query_check_page_permission($user_hrid,$page_id),$conn);
	$t_perm=sql_fetch_array($t_perms);
	if($t_perm)
		return true;
	return false;
}
// permissions functions WITH recursion
function check_file_permission_rec($conn,$user_hrid,$file_id){
	$t_perms=sql_query(query_check_file_permission_rec($user_hrid,$file_id),$conn);
	$t_perm=sql_fetch_array($t_perms);
	$parent_id=$t_perm["parent_id"];
	$t_perm=sql_fetch_array($t_perms);
	if($t_perm)
		return true;
	if($parent_id)
		return check_page_permission_rec($conn,$user_hrid,$parent_id); // check parent page (user must make sure there is no circular references)
	return false;
}
function check_page_permission_rec($conn,$user_hrid,$page_id){
	$t_perms=sql_query(query_check_page_permission_rec($user_hrid,$page_id),$conn);
	$t_perm=sql_fetch_array($t_perms);
	$parent_id=$t_perm["parent"];
	$t_perm=sql_fetch_array($t_perms);
	if($t_perm)
		return true;
	if($parent_id)
		return check_page_permission_rec($conn,$user_hrid,$parent_id); // check parent page (user must make sure there is no circular references)
	return false;
}



















// OTHER
function mkdir_rec($pathname){
	is_dir(dirname($pathname)) || mkdir_rec(dirname($pathname));
	return is_dir($pathname) || @mkdir($pathname);
}









?>
