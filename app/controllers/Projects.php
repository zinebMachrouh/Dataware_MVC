<?php
require 'Users.php';

class Projects extends Controller
{
    private $userController;
    private $projectModel;
    private $userModel;
    public function __construct()
    {
        $this->userController = new Users();
        $this->projectModel = $this->userController->getProjectModel();
        $this->userModel = $this->userController->getUserModel();
    }

    public function createProject()
    {
        $name = $_POST['name'];
        $dateStart = $_POST['date_start'];
        $dateEnd = $_POST['date_end'];
        $status = $_POST['status'];
        $description = $_POST['description'];
        $productOwner = $_SESSION['user_id'];

        $this->projectModel->insertData($name, $dateStart, $dateEnd, $status, $description, $productOwner);

        redirect('users/dashboard');
    }

    public function addProject()
    {
        $this->view('projects/addProject');
    }

    public function deleteProject($id)
    {
        $this->projectModel->deleteOne($id);
        redirect('users/dashboard');
    }

    public function modifyPage($id)
    {
        $project = $this->projectModel->getProject($id);
        $data = [
            'project' => $project
        ];

        $this->view('projects/modifyProject', $data);
    }

    public function updateProject($id)
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $newData = [
            'name' => $_POST['name'],
            'date_start' => $_POST['date_start'],
            'date_end' => $_POST['date_end'],
            'status' => $_POST['status'],
            'description' => $_POST['description']

        ];

        $this->projectModel->modifyData($id, $newData);

        redirect('users/dashboard');
    }

    public function setScrumMaster()
    {
        $teamId = $_POST['teamId'];
        $newSM = $_POST['newSM'];

        $this->projectModel->setScrumMaster($teamId, $newSM);
        redirect('users/dashboard');
    }

    public function projects()
    {
        $projects = $this->projectModel->getProjectsByProductOwner();
        $productOwners = $this->userModel->getProductOwners();

        $data = [
            'projects' => $projects,
            'productOwners' => $productOwners
        ];
        $this->view('projects/projects', $data);
    }

    public function updateProductOwner()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $projectId = $_POST['projectId'];
        $productOwner = $_POST['productOwner'];

        $this->projectModel->updateProductOwner($projectId, $productOwner);
        redirect('projects/projects');

    }
}
