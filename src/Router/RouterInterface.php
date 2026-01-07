<?php

declare(strict_types=1);
namespace Myonxmvc\Router;

interface RouterInterface
{
    /**
     * Add a route to the router
     *
     * @param string $method HTTP method (GET, POST, etc.)
     * @param array $params Route parameters
     * @return void 
     * 
     */
    public function addRoute(string $method, array $params): void;
    
    

    /**
     * Dispatch the request to the appropriate route and create associated controlller object
     *
     * @param string $method HTTP method (GET, POST, etc.)
     * @param string $url The requested URL
     * @return void 
     * 
     */

        
    public function dispatch(string $method, string $url): void;
    
    
    
}