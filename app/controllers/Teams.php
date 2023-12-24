<?php
require 'Users.php';

class Teams extends Controller
{
    private $userController;
    private $projectModel;
    private $teamModel;

    private $userModel;
    public function __construct()
    {
        $this->userController = new Users();
        $this->projectModel = $this->userController->getProjectModel();
        $this->userModel = $this->userController->getUserModel();
        $this->teamModel = $this->userController->getTeamModel();
    }

    public function createTeam()
    {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $projectId = $_POST['newP'];
        $scrumMaster = $_POST['scrumMaster'];

        $this->teamModel->addTeam($name, $description, $projectId, $scrumMaster);

        redirect('users/dashboard');
    }
    public function deleteTeam($id)
    {
        $this->teamModel->deleteOne($id);
        redirect('users/dashboard');
    }
    public function modifyTeam($id)
    {
        $team = $this->teamModel->getTeam($id);
        $projects = $this->projectModel->getProjectsNotInTeams();
        $user = $this->userModel->getUser($_SESSION['user_email']);
        $data = [
            'team' => $team,
            'projects' => $projects,
            'user' => $user
        ];

        $this->view('teams/modifyTeam', $data);
    }

    public function updateTeam($id)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $newData = [
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'projectId' => $_POST['projectId'],
        ];

        $this->teamModel->modifyTeam($id, $newData);

        redirect('users/dashboard');
    }

    public function members($teamId)
    {
        $team = $this->teamModel->getTeam($teamId);
        $user = $this->userModel->getUser($_SESSION['user_email']);

        $users = $this->teamModel->getMembers($_SESSION['user_id'], $teamId);
        $members = $this->teamModel->getTeamUser();

        $data = [
            'team' => $team,
            'users' => $users,
            'members' => $members,
            'user' => $user
        ];

        $this->view('teams/members', $data);
    }
    public function deleteTeamUser($userId, $teamId)
    {
        $this->teamModel->deleteTeamUser($userId, $teamId);

        redirect('teams/members/' . $teamId);
    }

    public function insertTeamUser($teamId)
    {
        $member = $_POST['member'];
        $this->teamModel->insertTeamUser($member, $teamId);
        redirect('teams/members/' . $teamId);

    }
}
