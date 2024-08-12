<?php

class Router {
    private $routes = [];

    public function add($path, $callback) {
        $this->routes[$path] = $callback;
    }

    public function dispatch() {
        $urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $path => $callback) {
            if (preg_match("#^$path$#", $urlPath, $matches)) {
                array_shift($matches); // Удаляем первый элемент массива, так как это полное совпадение
                return call_user_func_array($callback, $matches);
            }
        }

        http_response_code(404);
        echo "Page not found";
    }
}
