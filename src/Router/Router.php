<?php
/**
 * 
* 
* Package: Myonxmvc
* 
* Author:  Dave Thornton
* 
* Filename: Router.php
*  
* Description:    Router class file for Myonxmvc framework
* 
* Version:  1.0.0
* 
* License: MIT
 */

declare(strict_types=1);

namespace Myonxmvc\Router;

use Myonxmvc\Router\RouterInterface;

class Router implements RouterInterface
{
    /**
     * @var array $routes The array of routes
     */
    protected array $routes = [];

    /**
     * 
     * @var array $params The array of route parameters
     */
    protected array $params = [];
    /**
     * @var string $controller The suffix for the Controller object name
     */

    protected string $controller = 'Controller  ';

    /**
     * @inheritDoc
     */

    public function addRoute(string $method, array $params): void
    {
        $this->routes[$method][] = $params;
    }

    /**
     * @inheritDoc
     */

    public function dispatch(string $url): void
    {
            if($this->match($url))
            {
                $controllerString = $this->params['controller'] ;
                $controllerString = $this->transformUpperCamelCase($controllerString);
                $controllerString = $this->getNamespace($controllerString);
                if(class_exists($controllerString))
                {

                 
                    $controllerObject=new $controllerString();
                    $action = $this->params['action'];
                    $action = $this->transformCamelCase($action);

                   if(is_callable([$controllerObject, $action])){
                        $controllerObject->$action();
                   } 
                   else
                    {
                    throw new Exception("No method found");
                   }
                }
                else
                {
                    throw new Exception("No Object found for method");
                }
            
            
            {
                throw new Exception("No Route Matched", 404);
            }
            

            }
    }


    public function transformCamelCase(string $string): string
    {
        return lcfirst(this->transformUpperCamelCase($string));

    }

    public function transformUpperCamelCase(string $string): string
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    private function match(string $url) :bool
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $url,$matches)) { //preg_match
                foreach ($matches as $key => $param){

                    if (is_string($key)) {
                        $params[$key] = $param;
                    }
                }

                    $this->params = $params;
                    return true;
                }
            }
        
        return false;
    }

    /**
     * Get the namespace for the controller class
     */
    public function getNamespace(string $controller ): string
    {
        if(array_key_exists('namespace', $this->params)){
            $namespace .= $this->params['namespace'] . '\\';
            return $namespace;
    }
        
    }
}