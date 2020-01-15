<?php


namespace Koj\Base;


interface RouterInterface
{
    /**
     * @return mixed
     */
    public function run();

    /**
     * @param string $route
     * @param array $matches
     * @return bool
     */
    public function isCurrent(string $route, array &$matches): bool;

    /**
     * @param string $rule
     * @param array $params
     * @return mixed
     */
    public function runControllerAction(string $rule, array $params = []);

    /**
     * @return mixed
     */
    public function loadRoutes();
}