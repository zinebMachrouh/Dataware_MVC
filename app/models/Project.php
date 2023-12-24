<?php
// session_start();

class Project
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }
    public function insertData($name, $dateStart, $dateEnd, $status, $description, $productOwner)
    {
        $query = "INSERT INTO projects (name, date_start, date_end, description, status, productOwner) 
            VALUES (:name, :date_start, :date_end, :description, :status, :productOwner)";

        $this->conn->query($query);
        $this->conn->bind(':name', $name);
        $this->conn->bind(':date_start', $dateStart);
        $this->conn->bind(':description', $description);
        $this->conn->bind(':date_end', $dateEnd);
        $this->conn->bind(':status', $status);
        $this->conn->bind(':productOwner', $productOwner);

        $this->conn->execute();
    }

    public function deleteOne($id)
    {
        $query = "DELETE from projects where id = :id";
        $this->conn->query($query);
        $this->conn->bind(':id', $id, PDO::PARAM_INT);
        $this->conn->execute();
    }

    public function getProject($id)
    {
        $query = "SELECT * FROM projects WHERE id = :id";
        $this->conn->query($query);
        $this->conn->bind(':id', $id, PDO::PARAM_STR);
        $this->conn->execute();
        return $this->conn->single();
    }

    public function modifyData($id, $newData)
    {

        $query = "UPDATE projects SET name = :name, date_start = :date_start, date_end = :date_end, status = :status, description = :description WHERE id = :id";
        $this->conn->query($query);

        $this->conn->bind(':id', $id);
        $this->conn->bind(':name', $newData['name']);
        $this->conn->bind(':date_start', $newData['date_start']);
        $this->conn->bind(':date_end', $newData['date_end']);
        $this->conn->bind(':status', $newData['status']);
        $this->conn->bind(':description', $newData['description']);

        $this->conn->execute();
    }


    public function getProjectsByProductOwner()
    {
        $query = "SELECT * FROM projects where productOwner IS NULL";
        $this->conn->query($query);
        $this->conn->execute();
        return $this->conn->resultSet();
    }

    public function getProjectsNotInTeams()
    {
        $query = "SELECT * FROM projects WHERE NOT EXISTS ( SELECT * FROM teams WHERE teams.projectId = projects.id)";
        $this->conn->query($query);
        $this->conn->execute();

        return $this->conn->resultSet(PDO::FETCH_ASSOC);
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

    public function setScrumMaster($teamId, $newSM)
    {
        $this->conn->query("UPDATE teams SET scrumMaster = :newSM WHERE id = :teamId");
        $this->conn->bind(':teamId', $teamId, PDO::PARAM_INT);
        $this->conn->bind(':newSM', $newSM, PDO::PARAM_INT);
        $this->conn->execute();
    }

    public function updateProductOwner($projectId, $productOwner)
    {
        $this->conn->query("UPDATE projects SET productOwner = :productOwner WHERE id = :projectId");
        $this->conn->bind(':productOwner', $productOwner);
        $this->conn->bind(':projectId', $projectId);
        $this->conn->execute();
    }
}
