<?php
ob_start();
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if ($action == 'login') {
    $login = $crud->login();
    echo $login; // Ensure this correctly returns 1 (success) or 3 (failure)
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'save_page_img'){
	$save = $crud->save_page_img();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'delete_message'){
	$save = $crud->delete_message();
	if($save)
		echo $save;
}
if($action == "save_categories"){
	$save = $crud->save_categories();
	if($save)
		echo $save;
}
if($action == 'delete_categories'){
	$save = $crud->delete_categories();
	if($save)
		echo $save;
}
if($action == "save_survey"){
	$save = $crud->save_survey();
	if($save)
		echo $save;
}
if($action == "delete_survey"){
	$delete = $crud->delete_survey();
	if($delete)
		echo $delete;
}
if($action == "save_question"){
	$save = $crud->save_question();
	if($save)
		echo $save;
}
if($action == "delete_question"){
	$delsete = $crud->delete_question();
	if($delsete)
		echo $delsete;
}

if($action == "action_update_qsort"){
	$save = $crud->action_update_qsort();
	if($save)
		echo $save;
}
if($action == "save_answer"){
	$save = $crud->save_answer();
	if($save)
		echo $save;
}
if($action == "update_user"){
	$save = $crud->update_user();
	if($save)
		echo $save;
}

ob_end_flush();
?>
