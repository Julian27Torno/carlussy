<?php

namespace App\Controllers;

use App\Models\User;

class LoginController extends BaseController
{ 
    public function loginForm() {
        $this->initializeSession();
        return $this->renderView('login-form', []);
    }

    public function login() {
        $this->initializeSession();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                return $this->renderView('login-form', [
                    'errors' => ["Email and password are required."]
                ]);
            }

            $user = new User();
            if ($user->verifyAccess($email, $password)) {
                $this->onSuccessfulLogin($email);
            } else {
                return $this->renderView('login-form', [
                    'errors' => ["Invalid email or password."]
                ]);
            }
        } else {
            return $this->loginForm();
        }
    }

    private function onSuccessfulLogin($email) {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['email'] = $email;
    
        // Fetch the user's ID and first name from the database and store in session
        $user = new User();
        $userData = $user->getUserID($email); // Assuming getUserID now returns both ID and first name
        $_SESSION['user_id'] = $userData['id'];
        $_SESSION['firstname'] = $userData['first_name']; // Store first name in session
    
        // Redirect to home page after successful login
        header("Location: /");
        exit;
    }
    public function logout() {
        $this->initializeSession();
        session_destroy();
        header("Location: /");
        exit;
    }

    private function renderView($template, $data = []) {
        return $this->render($template, $data);
    }
}
