<?php
// session_start();

class Project
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }
    //Member Dashboard Methods

    public function getProjectsByUserId($userId)
    {
        $query = "SELECT projects.*
                FROM users
                JOIN team_user ON users.id = team_user.user_id
                JOIN teams ON team_user.team_id = teams.id
                JOIN projects ON teams.projectId = projects.id
                WHERE users.id = :userId";

        $this->conn->query($query);
        $this->conn->bind(':userId', $userId, PDO::PARAM_INT);
        $this->conn->execute();

        return $this->conn->resultSet(PDO::FETCH_ASSOC);
    }

    public function getProductOwnerById($poId)
    {
        $queryPO = "SELECT DISTINCT * FROM users WHERE id = :poId";
        $this->conn->query($queryPO);
        $this->conn->bind(':poId', $poId, PDO::PARAM_INT);
        $this->conn->execute();

        return $this->conn->single(PDO::FETCH_ASSOC);
    }
    //Product Owner Dashboard Methods
    public function getProjectsByProductOwnerId($productOwnerId)
    {
        $query = "SELECT * FROM projects WHERE productOwner = :id";
        $this->conn->query($query);
        $this->conn->bind(':id', $productOwnerId, PDO::PARAM_STR);
        $this->conn->execute();

        return $this->conn->resultSet(PDO::FETCH_ASSOC);
    }

    public function getProjectById($projectId)
    {
        $query = "SELECT * FROM projects WHERE id = :projectId";
        $this->conn->query($query);
        $this->conn->bind(':projectId', $projectId, PDO::PARAM_INT);
        $this->conn->execute();

        return $this->conn->single(PDO::FETCH_ASSOC);
    }
}
