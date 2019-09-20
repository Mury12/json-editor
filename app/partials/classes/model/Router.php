<?php 

namespace Model;

class Router
{
    private $base_url = "/";
    private $_routes = Array();

    function new_route($route_data = Array())
    {
        $this->_routes = $route_data;
    }

    function getRoutes()
    {
        print_r($this->_routes);
    }

    function getPage($slug = null)
    {
        $slug = substr($_SERVER['REQUEST_URI'],1);
        $slug = explode('?', $slug)[0];
        if(array_key_exists($slug, $this->_routes) && $slug != "blog"){
            return $this->_routes[$slug];
        }else{
            $this->setErrorCode(404, 'Page not found.');
            return $this->_routes['error/404'];
        }
    }

    function setErrorCode($code, $message){
        header('HTTP/1.0 '.$code.' '.$message);
    }


}