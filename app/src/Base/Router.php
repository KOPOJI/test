<?php


namespace Koj\Base;

use RuntimeException;

class Router implements RouterInterface
{
    const ROUTES_FILENAME = 'routes.php';
    const ROUTE_RULE_DELIMITER = '@';

    private $requestUri = null;
    private $routes = [];

    /**
     * Router constructor.
     * @param null $requestUri
     */
    public function __construct($requestUri = null)
    {
        $this->requestUri = $requestUri;
        $this->loadRoutes();
    }

    /**
     * @return mixed
     * @throws HttpNotFoundException
     * @throws \ReflectionException
     */
    public function run()
    {
        foreach($this->routes as $route => $to) {
            $matches = [];
            if($this->isCurrent($route, $matches)) {
                return $this->runControllerAction($to, $matches);
            }
        }

        throw new HttpNotFoundException('Route is not found');
    }

    /**
     * @param string $route
     * @param array $matches
     * @return bool
     */
    public function isCurrent(string $route, array &$matches): bool
    {
        return (bool) preg_match('~^' . $route . '$~ui', $this->requestUri, $matches);
    }

    /**
     * @param string $rule
     * @param array $params
     * @return mixed
     * @throws \ReflectionException
     */
    public function runControllerAction($rule, array $params = [])
    {
        list($controller, $action) = explode(static::ROUTE_RULE_DELIMITER, $rule);

        $this->checkClassMethod($controller, $action);

        $reflectionMethod = new \ReflectionMethod($controller, $action);

        if(isset($params[0]))
            unset($params[0]);

        if($reflectionMethod->getNumberOfRequiredParameters() > count($params))
            throw new \LogicException('Too few required arguments for method "' . $controller . '::' . $action . '"');

        return $reflectionMethod->invokeArgs(new $controller(), $params);
    }

    /**
     *
     */
    public function loadRoutes()
    {
        $this->routes = Config::getConfig(static::ROUTES_FILENAME);
    }


    /**
     * @param string $className
     */
    public function checkClass(string $className)
    {
        if(!class_exists($className))
            throw new RuntimeException('Class "' . $className . '" is not found.');
    }

    /**
     * @param string $className
     * @param string $methodName
     */
    public function checkClassMethod(string $className, string $methodName)
    {
        $this->checkClass($className);

        if(!method_exists($className, $methodName))
            throw new RuntimeException('Method "' . $methodName . '" is not found in class "' . $className . '".');
    }
}