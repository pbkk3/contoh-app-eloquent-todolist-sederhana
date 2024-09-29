<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;

class UserController extends Controller
{
    private UserService $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(): Response
    {
        return response()
            ->view("user.register", [
                "title" => "Register"
            ]);
    }

    public function doRegister(Request $request): Response|RedirectResponse
    {
        try {

            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');

            // validate input
            if (empty($email) || empty($password) || empty($name)) {
                return response()->view("user.register", [
                    "title" => "Register",
                    "error" => "Name, email and password is required"
                ]);
            }

            $this->userService->register($name, $email, $password);
            return redirect("/login");
        } catch (Exception $e) {
            return response()->view("user.register", [
                "title" => "Register",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function login(): Response
    {
        return response()
            ->view("user.login", [
                "title" => "Login"
            ]);
    }

    public function doLogin(Request $request): Response|RedirectResponse
    {
        try {
            $email = $request->input('email');
            $password = $request->input('password');

            // validate input
            if (empty($email) || empty($password)) {
                return response()->view("user.login", [
                    "title" => "Login",
                    "error" => "User and password is required"
                ]);
            }

            $this->userService->login($email, $password);

            $userId = $this->userService->getUserId($email);

            $request->session()->put("user", $userId);
            return redirect("/todolist");
        } catch (Exception $e) {
            return response()->view("user.login", [
                "title" => "Login",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function updateProfile(Request $request): Response
    {
        return response()
            ->view("user.update", [
                "title" => "Update Profile"
            ]);
    }

    public function doUpdateProfile(Request $request): Response|RedirectResponse
    {
        try {
            // validate input
            if ($request->input('name') && $request->input('email')) {
                return response()->view("user.update", [
                    "title" => "Update Profile",
                    "error" => "Name or email is required"
                ]);
            }

            if (!$request->input('name') == null) {
                $name = $request->input('name');
            } else {
                $name = null;
            }

            if (!$request->input('email') == null) {
                $email = $request->input('email');
            } else {
                $email = null;
            }


            $userId = $request->session()->get("user");
            $this->userService->updateUser($userId, $name, $email);
            return redirect("/todolist");
        } catch (Exception $e) {
            return response()->view("user.update", [
                "title" => "Update Profile",
                "error" => $e->getMessage()
            ]);
        }
    }

    public function doLogout(Request $request): RedirectResponse
    {
        $request->session()->forget("user");
        return redirect("/");
    }
}
