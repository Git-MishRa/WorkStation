<?php
ob_start();
$action = $_GET['action'];
include './actionClass.php';
$crud = new Actions();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'signup'){
	$signup = $crud->signup();
	if($signup)
		echo $signup;
}
if($action == 'fetch_user'){
	$online = $crud->onlineUsers();
	if($online)
		echo $online;
}
if($action == 'create_room'){
	$croom = $crud->create_room();
	if($croom)
	echo $croom;
}
if($action == 'message'){
	$mess = $crud->message();
	if($mess)
	echo $mess;
}
if($action == 'fetch_message'){
	$fmess = $crud->fetch_message();
	if($fmess)
	echo $fmess;
}
if($action == 'delete_user'){
	$del = $crud->delete_user();
	if($del)
		echo $del;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'save_folder'){
	$save = $crud->save_folder();
	if($save)
		echo $save;
}
if($action == 'delete_folder'){
	$delete = $crud->delete_folder();
	if($delete)
		echo $delete;
}
if($action == 'delete_file'){
	$delete = $crud->delete_file();
	if($delete)
		echo $delete;
}
if($action == 'save_files'){
	$save = $crud->save_files();
	if($save)
		echo $save;
}
if($action == 'file_rename'){
	$save = $crud->file_rename();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}