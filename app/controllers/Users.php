<?php
class Users extends Controller
{
    private $userModel;  
    private $teamModel;  
    private $projectModel; 

    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->teamModel = $this->model('Team');
        $this->projectModel = $this->model('Project');
    }

    public function index()
    {
        $data = [
            'title' => 'LogIn'
        ];
        $this->view('users/index', $data);
    }
    public function signupPage()
    {
        $this->view('users/signup');
    }
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
            ];

            if ($this->userModel->findUserByEmail($data['email'])) {

                $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                if ($loggedInUser) {
                    $this->createUserSession($loggedInUser);
                    if($loggedInUser->role === 0){
                        $this->memberDashboard($loggedInUser);
                    }
                } else {
                    echo '<script>alert("Incorrect Password")</script>';

                    $this->view('users/index', $data);
                }

            } else {
                echo '<script>alert("No user found")</script>';
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
            ];

            $this->view('users/index', $data);
        }
    }
    public function signup(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'fname' => trim($_POST['fname']),
                'lname' => trim($_POST['lname']),
                'email' => trim($_POST['email']),
                'service' => trim($_POST['service']),
                'tel' => trim($_POST['tel']),
                'password' =>  base64_encode(trim($_POST['password'])),
            ];

            $this->userModel->insertData($data['fname'], $data['lname'], $data['email'], $data['service'], $data['tel'], $data['password']);
            $loggedInUser = $this->userModel->getUser($data['email']);

            $this->createUserSession($loggedInUser);

        }
    }
    public function createUserSession($user)
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
    }

    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        redirect('users/index');
    }

    public function memberDashboard($user){
        $teamDetails = [];
        $userAteam = $this->userModel->getUserAndTeamInfoByEmail($user->email);
        $userTeams = $this->userModel->getUserTeamsById($userAteam->id);
        foreach ($userTeams as $userTeam) {
            array_push($teamDetails, $this->teamModel->getTeamDetailsById($userTeam->team_id));
        }
        $projects = $this->projectModel->getProjectsByUserId($user->id);
        foreach ($projects as $project) {
            $productOwner = $this->projectModel->getProductOwnerById($project->productOwner);
        }

        $data = [
            'profile'=> $user,
            'user'=> $userAteam,
            'teamDetails'=> $teamDetails,
            'projects'=> $projects,
            'productOwner'=> $productOwner
        ];

        $this->view('users/dashboardMember', $data);
    }
    public function modifyUser()
    {
            $id = $_POST["id"];
            $fname = $_POST["fname"];
            $lname = $_POST["lname"];
            $email = $_POST["email"];
            $birthdate = $_POST["birthdate"];
            $tel = $_POST["tel"];
            $adress = $_POST["adress"];
            $service = $_POST["service"];
            $pswd = $_POST["pswd"];

            $this->userModel->updateUser($id, $fname, $lname, $birthdate, $service, $adress, $tel, $email, $pswd);

            $this->view('users/dashboardMember.php');
    }
}
