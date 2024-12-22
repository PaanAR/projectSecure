<?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'db_connect.php';
    
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

	function login() {
		extract($_POST);
	
		// Debug the inputs
		error_log("Email: $email, Password: $password");
	
		$stmt = $this->db->prepare("SELECT *, CONCAT(fullname) as name FROM users WHERE email = ? AND password = ?");
		$hashed_password = md5($password); // Ensure the database password uses md5
		$stmt->bind_param('ss', $email, $hashed_password);
		$stmt->execute();
		$qry = $stmt->get_result();
	
		if ($qry->num_rows > 0) {
			$row = $qry->fetch_assoc();
			foreach ($row as $key => $value) {
				if ($key != 'password' && !is_numeric($key)) {
					$_SESSION['login_' . $key] = $value;
					error_log("Session set: login_$key = $value"); // Debug session variables
				}
			}
			return 1; // Login successful
		} else {
			// Debugging for failed login
			error_log("Login failed for email: $email");
			return 3; // Login failed
		}
	}
	
	
	function logout() {
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        header("location:login.php");
    }

	function save_user() {
        extract($_POST);
        $data = [];
        foreach ($_POST as $key => $value) {
            if (!in_array($key, ['id', 'cpass']) && !is_numeric($key)) {
                $data[$key] = $key === 'password' ? md5($value) : $value; // Replace md5 with password_hash() for better security
            }
        }

        if (empty($id)) {
            $stmt = $this->db->prepare("INSERT INTO users SET fullname = ?, email = ?, password = ?, type = ?");
            $stmt->bind_param('ssss', $data['fullname'], $data['email'], $data['password'], $data['type']);
        } else {
            $stmt = $this->db->prepare("UPDATE users SET fullname = ?, email = ?, password = ?, type = ? WHERE id = ?");
            $stmt->bind_param('ssssi', $data['fullname'], $data['email'], $data['password'], $data['type'], $id);
        }

        return $stmt->execute() ? 1 : 0;
    }
	function update_user(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k => $v){
			if(!in_array($k, array('id','cpass','table')) && !is_numeric($k)){
				if($k =='password')
					$v = md5($v);
				if(empty($data)){
					$data .= " $k='$v' ";
				}else{
					$data .= ", $k='$v' ";
				}
			}
		}
		$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
		if($check > 0){
			return 2;
			exit;
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO users set $data");
		}else{
			$save = $this->db->query("UPDATE users set $data where id = $id");
		}

		if($save){
			foreach ($_POST as $key => $value) {
				if($key != 'password' && !is_numeric($key))
					$_SESSION['login_'.$key] = $value;
			}
			return 1;
		}
	}
	function delete_user() {
        extract($_POST);
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute() ? 1 : 0;
    }
	function delete_message(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM contact where ID = ".$id);
		if($delete)
			return 1;
	}
	function delete_categories() {
        extract($_POST);
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute() ? 1 : 0;
    }
	function save_page_img(){
		extract($_POST);
		if($_FILES['img']['tmp_name'] != ''){
				$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'],'assets/uploads/'. $fname);
				if($move){
					$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
					$hostName = $_SERVER['HTTP_HOST'];
						$path =explode('/',$_SERVER['PHP_SELF']);
						$currentPath = '/'.$path[1]; 
   						 // $pathInfo = pathinfo($currentPath); 

					return json_encode(array('link'=>$protocol.'://'.$hostName.$currentPath.'/admin/assets/uploads/'.$fname));

				}
		}
	}
	function save_categories() {
        extract($_POST);
        $data = [];
        foreach ($_POST as $key => $value) {
            if (!in_array($key, ['id']) && !is_numeric($key)) {
                $data[$key] = $value;
            }
        }

        if (empty($id)) {
            $stmt = $this->db->prepare("INSERT INTO categories SET name = ?");
            $stmt->bind_param('s', $data['name']);
        } else {
            $stmt = $this->db->prepare("UPDATE categories SET name = ? WHERE id = ?");
            $stmt->bind_param('si', $data['name'], $id);
        }

        return $stmt->execute() ? 1 : 0;
    }

	function save_survey() {
        extract($_POST);
        $respondent_list = implode(',', $respondent);
        $data = "respondent='$respondent_list', ";
        foreach ($_POST as $k => $v) {
            if (!in_array($k, ['id', 'respondent']) && !is_numeric($k)) {
                $data .= "$k='$v', ";
            }
        }
        $data = rtrim($data, ', ');

        if (empty($id)) {
            $stmt = $this->db->prepare("INSERT INTO survey_set SET $data");
        } else {
            $stmt = $this->db->prepare("UPDATE survey_set SET $data WHERE id = ?");
            $stmt->bind_param('i', $id);
        }

        return $stmt->execute() ? 1 : 0;
    }
	  
	  function delete_survey() {
        extract($_POST);
        $stmt = $this->db->prepare("DELETE FROM survey_set WHERE id = ?");
        $stmt->bind_param('i', $id);
        return $stmt->execute() ? 1 : 0;
    }
	
	function save_question(){
		extract($_POST);
			$data = " survey_id=$sid ";
			$data .= ", question='$question' ";
			$data .= ", instruction='$instruction' ";
			$data .= ", type='$type' ";
			if($type != 'textfield_s'){
				$arr = array();
				foreach ($label as $k => $v) {
					$i = 0 ;
					while($i == 0){
						$k = substr(str_shuffle(str_repeat($x='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(5/strlen($x)) )),1,5);
						if(!isset($arr[$k]))
							$i = 1;
					}
					$arr[$k] = $v;
				}
			$data .= ", frm_option='".json_encode($arr)."' ";
			}else{
			$data .= ", frm_option='' ";
			}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO questions set $data");
		}else{
			$save = $this->db->query("UPDATE questions set $data where id = $id");
		}

		if($save)
			return 1;
	}
	function delete_question(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM questions where id = ".$id);
		if($delete){
			return 1;
		}
	}
	function action_update_qsort(){
		extract($_POST);
		$i = 0;
		foreach($qid as $k => $v){
			$i++;
			$update[] = $this->db->query("UPDATE questions set order_by = $i where id = $v");
		}
		if(isset($update))
			return 1;
	}
	function save_answer() {
        extract($_POST);
        foreach ($qid as $k => $v) {
            $data = [
                'survey_id' => $survey_id,
                'question_id' => $qid[$k],
                'user_id' => $_SESSION['login_id'],
                'answer' => is_array($answer[$k]) ? implode(',', $answer[$k]) : $answer[$k],
            ];

            $stmt = $this->db->prepare("INSERT INTO answers (survey_id, question_id, user_id, answer) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('iiis', $data['survey_id'], $data['question_id'], $data['user_id'], $data['answer']);
            $stmt->execute();
        }

        return 1;
    }
	function delete_comment(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM comments where id = ".$id);
		if($delete){
			return 1;
		}
	}
}