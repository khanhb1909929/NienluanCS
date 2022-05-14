<?php
$filepath = realpath(__FILE__);
  include_once "../../lib/session.php";
  include_once "../../lib/database.php";
  include_once "../../helpers/format.php";
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
    public function login_admin($adminUser, $adminPass){
      $adminUser = $this->fm->validation($adminUser);
      $adminPass = $this->fm->validation($adminPass);

      $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
      $adminPass = mysqli_real_escape_string($this->db->link, $adminPass);

      if(empty($adminUser) || empty($adminPass)){
        $alert = "User and Pass must not be empty";
        return $alert;
      }else{
        $query = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' AND adminPass = '$adminPass' LIMIT 1";
        $result = $this->db->select($query);

        if($result != false){
          $value = $result->fetch_assoc();
          Session::set('adminLogin', true);
          Session::set('adminId', $value['adminId']);
          Session::set('adminUser', $value['adminUser']);
          Session::set('adminName', $value['adminName']);
          header("location:index.php");
        }else{
          $alert = "User and Pass not match";
          return $alert;
        }
      }
    }
  }
?>