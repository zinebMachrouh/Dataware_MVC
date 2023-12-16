<?php
session_start();

class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    function getData()
    {
    }

    public function insertData($fname,$lname,$email,$service,$tel,$password)
    {
        try {
            $query = "INSERT INTO users (fname, lname, email, service, tel, password) VALUES (:fname, :lname, :email, :service, :tel, :password)";
            $stmt = $this->conn->prepare($query);

            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':lname', $lname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':service', $service);
            $stmt->bindParam(':tel', $tel);
            $stmt->bindParam(':password', $password);

            $stmt->execute();
            header("Location: dashboard.php");
            $_SESSION['email'] = $email;
        } catch (PDOException $e) {
            echo '<script> alert("' . $e->getMessage() . '")</script>';
        }
    }

    public function storeSession()
    {
    }

    public function modifyData()
    {
    }

    public function deleteData()
    {
    }
}
