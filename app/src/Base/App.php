<?php


namespace Koj\Base;


class App implements AppInterface
{
    private $router;

    /**
     * @return mixed|void
     */
    public function run()
    {
        $this->router = new Router(preg_replace('~\\?.*$~u', '', $_SERVER['REQUEST_URI']));
        $this->router->run();
    }

    /**
     * @return DbInterface
     */
    public static function getDb()
    {
        return new PdoDb();
    }

    /**
     * @return array|mixed
     */
    public static function getValidators()
    {
        return array(
            'required' => '\\Koj\\Forms\\Validators\\EmptyValidator',
            'email' => '\\Koj\\Forms\\Validators\\EmailValidator',
        );
    }
}