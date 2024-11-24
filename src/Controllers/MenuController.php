<?php 

namespace App\Controllers;

class MenuController extends BaseController
{
    public function index()
    {
        // Initialize the session (if required)
        $this->initializeSession();

        // Add any specific logic for the order page here
        // For example: preparing data for the form, handling user state, etc.

        // Render the order form view
        return $this->render('menu');
    }
}
