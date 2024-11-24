<?php 

namespace App\Controllers;

use App\Models\User;

class RegisterController extends BaseController
{   
    public function registrationForm()
    {
        $this->initializeSession();

        return $this->render('registration-form');
    }

    public function register()
    {   
        $this->initializeSession();
        $data = $_POST;
    
        $userObj = new User();
        $user_id = $userObj->save($data);
    
        session_destroy();
    
        // Save the registration to session
        $_SESSION['user_id'] = $user_id; // Store user ID after registration
        $_SESSION['firstname'] = $data['first_name']; // Save first name from form
        $_SESSION['lastname'] = $data['last_name'];  // Save last name from form
        $_SESSION['email'] = $data['email']; // Save email
    
        // Redirect to login page after registration
        header("Location: /login");
    }
}