<?php
session_start();
class User
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    function getData($email)
    {
        try {
            $query = "SELECT * FROM users WHERE email = :email";
            $this->conn->query($query);
            $this->conn->bind(':email', $email);
            return $this->conn->single();
        } catch (PDOException $e) {
            echo '<script> alert("' . $e->getMessage() . '")</script>';
            return null;
        }
    }
    public function insertData($fname, $lname, $email, $service, $tel, $password)
    {
        try {
            $query = "INSERT INTO users (fname, lname, email, service, tel, password) VALUES (:fname, :lname, :email, :service, :tel, :password)";
            $this->conn->query($query);

            $this->conn->bind(':fname', $fname);
            $this->conn->bind(':lname', $lname);
            $this->conn->bind(':email', $email);
            $this->conn->bind(':service', $service);
            $this->conn->bind(':tel', $tel);
            $this->conn->bind(':password', $password);

            $this->conn->execute();
        } catch (PDOException $e) {
            echo '<script> alert("' . $e->getMessage() . '")</script>';
        }
    }

    public function storeSession($email)
    {
        $_SESSION['email'] = $email;
    }

    public function modifyData($id, $newData)
    {
        try {
            $query = "UPDATE users SET fname = :fname, lname = :lname, service = :service, tel = :tel WHERE email = :id";
            $this->conn->query($query);

            $this->conn->bind(':id', $id);
            $this->conn->bind(':fname', $newData['fname']);
            $this->conn->bind(':lname', $newData['lname']);
            $this->conn->bind(':service', $newData['service']);
            $this->conn->bind(':tel', $newData['tel']);

            $this->conn->execute();
            header("Location: dashboard.php");
        } catch (PDOException $e) {
            echo '<script> alert("' . $e->getMessage() . '")</script>';
        }
    }

    public function login($email, $password)
    {
        $this->conn->bind(':email', $email);

        $row = $this->conn->single();

        if ($row && property_exists($row, 'password')) {
            $stored_password = base64_decode($row->password);

            if ($password === $stored_password) {
                return $row;
            }
        }

        return false;

    }

    public function findUserByEmail($email)
    {
        $this->conn->query('SELECT * FROM users WHERE email = :email');
        $this->conn->bind(':email', $email);

        $this->conn->execute();

        if ($this->conn->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
