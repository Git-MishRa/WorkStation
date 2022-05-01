<?php
    session_start();
    class Actions{
        private $con;
        public function __construct(){
            ob_start();
            include './dbCon.php';
            $this->con=$conn;
        }
        function __destruct(){
            $this->con->close();
            ob_end_flush();
        }
        function signup()
	{
		extract($_POST);
		$pass=password_hash($password,PASSWORD_BCRYPT);
		$data = " username ='" . $username . "' ";
		$data .= ", name ='" . $name . "' ";
		$data .= ", password ='" . $pass . "' ";
		$result= $this->con->query("INSERT into users set ".$data);
		if($result){
			return 1;
		}
		else{
			return 2;
		}
	}
        function login(){
            extract($_POST);
            $qry = $this->con->query("SELECT * FROM users where username = '" . $username . "'");
            $result=$qry->fetch_array();
            $enkey=$result['password'];
            if(password_verify($password,$enkey)){
                $qry1= $this->con->query("UPDATE users set online=1 where username = '" . $username . "'");
                if ($qry->num_rows > 0) {
                    foreach ($result as $key => $value) {
                        if ($key != 'password' && !is_numeric($key))
                            $_SESSION['login_' . $key] = $value;
                            $_SESSION['usern']=$username;
                        }
                    return 1;
                } 
                else {
                    return 2;
                }
            }
        }
    function logout()
	{
		$usern=$_SESSION['usern'];
		$qry2= $this->con->query("UPDATE users set online=0 where username = '" . $usern . "'");
		session_destroy();
		foreach ($_SESSION as $key => $value) {
			unset($_SESSION[$key]);
		}
		header("location:../login.php");
	}

	function onlineUsers(){
		$qry2 = $this->con->query("SELECT username FROM users where online = 1");
		$html_content="";
		if(mysqli_num_rows($qry2)>0){
			while($row=mysqli_fetch_assoc($qry2)){
				$user=$row['username'];
				$html_content=$html_content . '<div>'."$user".'  	<i class="fa fa-circle"></i></div>';
			}
			return $html_content;
		}
		else{
			return "<i>No User Online<i>";
		}
	}
    function save_folder()
	{
		extract($_POST);
		$data = " name ='" . $name . "' ";
		$data .= ", parent_id ='" . $parent_id . "' ";
		if (empty($id)) {
			$data .= ", user_id ='" . $_SESSION['login_id'] . "' ";

			$check = $this->con->query("SELECT * FROM folders where user_id ='" . $_SESSION['login_id'] . "' and name  ='" . $name . "'")->num_rows;
			if ($check > 0) {
				return json_encode(array('status' => 2, 'msg' => 'Folder name already exist'));
			} else {
				$save = $this->con->query("INSERT INTO folders set " . $data);
				if ($save)
					return json_encode(array('status' => 1));
			}
		} else {
			$check = $this->con->query("SELECT * FROM folders where user_id ='" . $_SESSION['login_id'] . "' and name  ='" . $name . "' and id !=" . $id)->num_rows;
			if ($check > 0) {
				return json_encode(array('status' => 2, 'msg' => 'Folder name already exist'));
			} else {
				$save = $this->con->query("UPDATE folders set " . $data . " where id =" . $id);
				if ($save)
					return json_encode(array('status' => 1));
			}
		}
	}

	function delete_folder()
	{
		extract($_POST);
		$delete = $this->con->query("DELETE FROM folders where id =" . $id);
		if ($delete)
			echo 1;
	}
	function delete_file()
	{
		extract($_POST);
		$path = $this->con->query("SELECT file_path from files where id=" . $id)->fetch_array()['file_path'];
		$delete = $this->con->query("DELETE FROM files where id =" . $id);
		if ($delete) {
			unlink('../resources/repo/' . $path);
			return 1;
		}
	}

	function save_files()
	{
		extract($_POST);
		if (empty($id)) {
			if ($_FILES['upload']['tmp_name'] != '') {
				$fname = strtotime(date('y-m-d H:i')) . '_' . $_FILES['upload']['name'];
				$move = move_uploaded_file($_FILES['upload']['tmp_name'], '../resources/repo/' . $fname);

				if ($move) {
					$file = $_FILES['upload']['name'];
					$file = explode('.', $file);
					$chk = $this->con->query("SELECT * FROM files where SUBSTRING_INDEX(name,' ||',1) = '" . $file[0] . "' and folder_id = '" . $folder_id . "' and file_type='" . $file[1] . "' ");
					if ($chk->num_rows > 0) {
						$file[0] = $file[0] . ' ||' . ($chk->num_rows);
					}
					$data = " name = '" . $file[0] . "' ";
					$data .= ", folder_id = '" . $folder_id . "' ";
					$data .= ", description = '" . $description . "' ";
					$data .= ", user_id = '" . $_SESSION['login_id'] . "' ";
					$data .= ", file_type = '" . $file[1] . "' ";
					$data .= ", file_path = '" . $fname . "' ";
					if (isset($is_public) && $is_public == 'on')
						$data .= ", is_public = 1 ";
					else
						$data .= ", is_public = 0 ";

					$save = $this->con->query("INSERT INTO files set " . $data);
					if ($save)
						return json_encode(array('status' => 1));
				}
			}
		} else {
			$data = " description = '" . $description . "' ";
			if (isset($is_public) && $is_public == 'on')
				$data .= ", is_public = 1 ";
			else
				$data .= ", is_public = 0 ";
			$save = $this->con->query("UPDATE files set " . $data . " where id=" . $id);
			if ($save)
				return json_encode(array('status' => 1));
		}
	}
	function file_rename()
	{
		extract($_POST);
		$file[0] = $name;
		$file[1] = $type;
		$chk = $this->con->query("SELECT * FROM files where SUBSTRING_INDEX(name,' ||',1) = '" . $file[0] . "' and folder_id = '" . $folder_id . "' and file_type='" . $file[1] . "' and id != " . $id);
		if ($chk->num_rows > 0) {
			$file[0] = $file[0] . ' ||' . ($chk->num_rows);
		}
		$save = $this->con->query("UPDATE files set name = '" . $name . "' where id=" . $id);
		if ($save) {
			return json_encode(array('status' => 1, 'new_name' => $file[0] . '.' . $file[1]));
		}
	}
	function save_user()
	{
		extract($_POST);
		$pass=password_hash($password,PASSWORD_BCRYPT);
		$data = " name = '$name' ";
		$data .= ", username = '$username' ";
		$data .= ", password = '$pass' ";
		$data .= ", type = '$type' ";
		if (empty($id)) {
			$save = $this->con->query("INSERT INTO users set " . $data);
		} else {
			$save = $this->con->query("UPDATE users set " . $data . " where id = " . $id);
		}
		if ($save) {
			return 1;
		}
	}
	function delete_user()
	{
		extract($_GET);
		if (empty($id)) {
			return 0;
		} else {
			$save = $this->con->query("DELETE FROM users WHERE id=" . $id);
		}
		if ($save) {
			return 1;
		}
	}





    function create_room()
	{
		$room=$_POST['room'];
		if (strlen($room) > 20 or strlen($room) < 3) {
			$message = "Please choose a name between 3 to 20 characters";
		}else if (!ctype_alnum($room)) {
			$message = "Please choose an alphanumeric name";
		}else{
			$save = $this->con->query("SELECT * FROM rooms WHERE roomname='$room'");
			if($save){
				if(mysqli_num_rows($save)>0){
					$message="Please choose a different Room Name. This Room is already claimed";
				}else{
					$result=$this->con->query("INSERT INTO `rooms` (`roomname`, `createtime`) VALUES ('$room', 'current_timestamp()');");
					if($result){
						$message="Your room is ready!";
					}
					else{
						$message="error";
					}
				}
			}
		}
		return $message;
	}
	function message()
	{
		$user=$_POST['user'];
		$message=$_POST['message'];
		$room=$_POST['room'];
					$result=$this->con->query("INSERT INTO `messages` (`user`, `message`, `room`, `mtime`) VALUES ('$user', '$message', '$room', current_timestamp());
					");
					if($result){
						$message="Message Sent";
					}
					else{
						$message="error";
					}
		return $message;
	}
	function fetch_message(){
		$room=$_POST['room'];
		$user=$_POST['user'];
		$html_content="";
		$result=$this->con->query("SELECT `user`, `message`, `mtime` FROM `messages` WHERE room='$room'");
		if(mysqli_num_rows($result)>0){
			while($row=mysqli_fetch_assoc($result)){
				$time=($user==$row['user'])? 'time-left text-white': 'time-right';
				$bold=($user==$row['user'])? 'right': '';
				$name=($user==$row['user'])? 'Me': $row["user"];
				$success=($user==$row['user'])? 'sent':'recieved';
				$html_content=$html_content . '<div class="'.$success.'Chat">
				<div class="'.$success.'ChatImg">
				 <span><i class="fa fa-user"></i></span>
				</div>
				<div class="'.$success.'Message">
				  <div class="'.$success.'MessageInbox">
					<p>'.$row["message"].'</p>
					<span class="timeStamp">'.$row["mtime"].' ~'.$row['user'].'</span>
				  </div>
				</div>
			  </div>';
			}
			return $html_content;
		}
		else{
			return "<i>Please choose a room to chat<i>";
		}

	}
    }
?>
