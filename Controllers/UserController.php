<?php
    namespace Controllers;

    use Models\Student as Student;
    use DAO\StudentDAO as StudentDAO;
    use Exception;

class UserController
    {
        public function ShowLoginView ($message = '')
        {
            require_once (VIEWS_PATH . 'login.php');
        }

        public function Login ($formUser)
        {
            $loginUser = new Student();
            $loginUser->setEmail($formUser);
            $studentDAO = new StudentDAO();
            $logSucces = 0;
            
            try
            {
                if ($loginUser->getEmail() == 'root')
                {
                    session_start();
                    $_SESSION['loggedUser'] = 'admin';
                    $logSucces = 1;

                    $homeController = new HomeController();
                    $homeController->ShowAdminView();
                }

                elseif ($logSucces == 0)
                {
                    foreach($studentDAO as $student)
                    {
                        if($student->getEmail() == $loginUser->getEmail())
                        {
                            $logSucces = 1;
                            $loginUser->setStudentId($student->getStudentId());
                            $loginUser->setFirstName($student->getFirstName());
                            $loginUser->setLastName($student->getLastName());
                        }
                    }

                    if ($logSucces == 1)
                    {
                        session_start();
                        $_SESSION['loggedUser'] = $loginUser;

                        $homeController = new HomeController();
                        $homeController->ShowStudentView();
                    }
                }
            }

            catch (Exception $ex)
            {
                $message = 'Ocurrió un error!';
                $this->ShowLoginView($message);
            }
        }
    }