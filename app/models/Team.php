<?php
// session_start();

class Team
{
    private $conn;

    public function __construct()
    {
        $this->conn = new Database();
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
        $query = "SELECT * FROM teams WHERE scrumMaster = :id";
        $this->conn->query($query);
        $this->conn->bind(':id', $scrumMasterId, PDO::PARAM_STR);
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

    //Product Owner Dashboard Members
    public function getTeamsWithoutScrumMasterByUserId($userId)
    {
        $query = "SELECT teams.*
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

?>