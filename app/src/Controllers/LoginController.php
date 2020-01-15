<?php


namespace Koj\Controllers;


use Koj\Base\Controller;
use Koj\Base\UserHelper;
use Koj\Base\View;
use Koj\User;
use LogicException;

class LoginController extends Controller
{
    /**
     * @return string|void
     * @throws LogicException
     */
    public function login()
    {
        $this->checkIsAlreadyAuthed();

        $user = new User();

        $status = null;

        if(!empty($_POST)) {
            $user = UserHelper::login($_POST);
            if(!UserHelper::isGuest())
                $status = true;
        }

        $errors = $user->getErrors();

        return View::render('site/login', compact('status', 'errors'));
    }

    /**
     * @throws LogicException
     */
    public function logout()
    {
        $this->checkIsGuest();

        UserHelper::logout();
    }

    /**
     * @throws LogicException
     */
    private function checkIsAlreadyAuthed()
    {
        if(!UserHelper::isGuest())
            throw new LogicException('Вы уже авторизованы.');
    }

    /**
     * @throws LogicException
     */
    private function checkIsGuest()
    {
        if(UserHelper::isGuest())
            throw new LogicException('Вы еще не авторизованы.');
    }
}