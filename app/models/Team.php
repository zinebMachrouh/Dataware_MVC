<?php
// session_start();

class Team
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
    }

    public function addTeam($name, $description, $projectId, $scrumMaster)
    {
        $query = "INSERT INTO teams (name, description, projectId, scrumMaster)
        VALUES (:name, :description, :projectId, :scrumMaster)";

        $this->conn->query($query);
        $this->conn->bind(':name', $name);
        $this->conn->bind(':description', $description);
        $this->conn->bind(':projectId', $projectId);
        $this->conn->bind(':scrumMaster', $scrumMaster);

        $this->conn->execute();
    }

    public function deleteOne($teamId)
    {
        $query = "DELETE FROM teams WHERE id = :id";
        $this->conn->query($query);
        $this->conn->bind(':id', $teamId);
        $this->conn->execute();
    }

    public function modifyTeam($teamId, $newData)
    {
        $query = "UPDATE teams 
            SET name = :name, description = :description, 
            projectId = :projectId
            WHERE id = :id";

        $this->conn->query($query);
        $this->conn->bind(':name', $newData['name']);
        $this->conn->bind(':description', $newData['description']);
        $this->conn->bind(':projectId', $newData['projectId']);
        $this->conn->bind(':id', $teamId);
        $this->conn->execute();
    }
    public function getTeam($id)
    {
        $query = "SELECT * FROM teams WHERE id = :id";
        $this->conn->query($query);
        $this->conn->bind(':id', $id, PDO::PARAM_STR);
        $this->conn->execute();
        return $this->conn->single();
    }
    //Members Dashboard Methods
    public function getTeamDetailsById($teamId)
    {
        $queryTeam = "SELECT * FROM teams WHERE id = :teamId";
        $this->conn->query($queryTeam);
        $this->conn->bind(':teamId', $teamId, PDO::PARAM_INT);
        $this->conn->execute();
        $team = $this->conn->single(PDO::FETCH_ASSOC);

        if ($team) {
            $teamProjectId = $team->projectId;
            $project = $this->getProjectDetailsById($teamProjectId);

            $scrumMasterId = $team->scrumMaster;
            $sm = $this->getUserDetailsById($scrumMasterId);

            return ['team' => $team, 'project' => $project, 'scrumMaster' => $sm];
        }

        return null;
    }

    private function getProjectDetailsById($projectId)
    {
        $queryProject = "SELECT * FROM projects WHERE id = :projectId";
        $this->conn->query($queryProject);
        $this->conn->bind(':projectId', $projectId, PDO::PARAM_INT);
        $this->conn->execute();
        return $this->conn->single(PDO::FETCH_ASSOC);
    }

    private function getUserDetailsById($userId)
    {
        $queryUser = "SELECT * FROM users WHERE id = :userId";
        $this->conn->query($queryUser);
        $this->conn->bind(':userId', $userId, PDO::PARAM_INT);
        $this->conn->execute();
        return $this->conn->single(PDO::FETCH_ASSOC);
    }

    //Scrum Master Dashboard Members
    public function getTeamsByScrumMasterId($scrumMasterId)
    {
        $query = "SELECT teams.*, projects.name as projectName FROM teams JOIN projects on teams.projectId = projects.id WHERE scrumMaster = :id";
        $this->conn->query($query);
        $this->conn->bind(':id', $scrumMasterId, PDO::PARAM_STR);
        $this->conn->execute();

        return $this->conn->resultSet(PDO::FETCH_ASSOC);
    }
    public function getMembers($id, $teamId)
    {
        $query = "SELECT DISTINCT users.*
            FROM users
            INNER JOIN team_user ON users.id = team_user.user_id
            INNER JOIN teams ON team_user.team_id = :teamId
            WHERE teams.scrumMaster = :id";

        $this->conn->query($query);
        $this->conn->bind(':id', $id, PDO::PARAM_INT);
        $this->conn->bind(':teamId', $teamId, PDO::PARAM_INT);
        $this->conn->execute();
        return $this->conn->resultSet(PDO::FETCH_ASSOC);
    }

    public function getTeamUser()
    {
        $query = "SELECT users.* FROM users LEFT JOIN team_user ON users.id = team_user.user_id WHERE users.role = 0 AND team_user.team_id IS NULL";
        $this->conn->query($query);
        $this->conn->execute();

        return $this->conn->resultSet(PDO::FETCH_ASSOC);
    }

    public function deleteTeamUser($userId , $teamId){
        $query = "DELETE FROM team_user WHERE user_id = :user_id AND team_id = :team_id";
        $this->conn->query($query);
        $this->conn->bind(':user_id', $userId, PDO::PARAM_INT);
        $this->conn->bind(':team_id', $teamId, PDO::PARAM_INT);
        $this->conn->execute();
    }

    public function insertTeamUser($member, $teamId)
    {
        $query = "INSERT INTO team_user (user_id, team_id) VALUES (:user_id, :team_id)";

        $this->conn->query($query);
        $this->conn->bind(':user_id', $member);
        $this->conn->bind(':team_id', $teamId);

        $this->conn->execute();
    }
    //Product Owner Dashboard Members
    public function getTeamsWithoutScrumMasterByUserId($userId)
    {
        $query = "SELECT teams.* ,projects.name as projectName
                FROM teams
                JOIN projects ON teams.projectId = projects.id
                JOIN users ON projects.productOwner = users.id
                WHERE teams.scrumMaster IS NULL
                AND users.id = :id";

        $this->conn->query($query);
        $this->conn->bind(':id', $userId, PDO::PARAM_INT);
        $this->conn->execute();

        return $this->conn->resultSet(PDO::FETCH_ASSOC);
    }
}
