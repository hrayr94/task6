<?php

namespace App\Http\Controllers;

use App\Models\AdminAuth;
use App\Models\Database;
use App\RMVC\Route\Route;
use App\RMVC\View\View;

class AuthController extends Controller
{
    private AdminAuth $adminAuth;

    public function __construct()
    {
        $db = Database::getInstance()->getConnection();
        $this->adminAuth = new AdminAuth($db);
    }

    public function showLoginForm()
    {
        return View::view('login');
    }

    public function login() : string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $admin = $this->adminAuth->login($username, $password);

            if ($admin) {
                $_SESSION['user'] = [
                    'id' => $admin['id'],
                    'username' => $admin['username'],
                ];
                Route::redirect('/products');
            } else {
                $message = "Invalid credentials. Please try again.";
            }
        }
        return View::view('login', ['message' => $message]);
    }

    public function logout()
    {
        $this->adminAuth->logout();
        Route::redirect('/login');
    }

}

