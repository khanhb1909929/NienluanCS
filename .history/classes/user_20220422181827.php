<?php
$filepath = realpath(dirname(__FILE__));
  include_once ($filepath."../../lib/session.php");
  include_once ($filepath."../../lib/database.php");
  include_once ($filepath."../../helpers/format.php");
?>
<?php
  class user
  {
    private $db;
    private $fm;

    public function __construct()
    {
      $this->db = new Database();
      $this->fm = new Format();
    }
    public function add_user($email, $pass) {
      $email = $this->fm->validation($email);
      $pass = $this->fm->validation($pass);
      $email = mysqli_real_escape_string($this->db->link, $email);
      $pass = mysqli_real_escape_string($this->db->link, $pass);
      if($email=='' || $pass =='') {
        $alert = "Dang ki that bai";
        return $alert;
      } else {

        $checkEmail = "SELECT * FROM tbl_user WHERE email='$email' LIMIT 1";
        $result_check = $this->db->select($checkEmail);
        if($result_check) {
          $alert = "Dang ki that bai";
          return $alert;
        } else {
          $query = "INSERT INTO tbl_user(Email,password) VALUE('$email','$pass') ";
          $result = $this->db->insert($query);
        if($result) {
          $alert = "Thêm tai khoan thành công";
          return $alert;
        } else {
          $alert = "Thêm tai khoan mới không thành công";
          return $alert;
        }
        }
      }
    }
    // public function login_admin($adminUser, $adminPass){
    //   $adminUser = $this->fm->validation($adminUser);
    //   $adminPass = $this->fm->validation($adminPass);

    //   $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
    //   $adminPass = mysqli_real_escape_string($this->db->link, $adminPass);

    //   if(empty($adminUser) || empty($adminPass)){
    //     $alert = "User and Pass must not be empty";
    //     return $alert;
    //   }else{
    //     $query = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' AND adminPass = '$adminPass' LIMIT 1";
    //     $result = $this->db->select($query);

    //     if($result != false){
    //       $value = $result->fetch_assoc();
    //       Session::set('adminLogin', true);
    //       Session::set('adminId', $value['adminId']);
    //       Session::set('adminUser', $value['adminUser']);
    //       Session::set('adminName', $value['adminName']);
    //       header("location:index.php");
    //     }else{
    //       $alert = "User and Pass not match";
    //       return $alert;
    //     }
    //   }
    // }
  }
?>