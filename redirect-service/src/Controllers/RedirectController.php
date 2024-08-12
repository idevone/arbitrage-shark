<?php

class RedirectController {
    public function redirect($id) {
        // Логика обработки перенаправления
        echo "Redirecting ID: " . htmlspecialchars($id);
    }

    public function index() {
        echo "Welcome to the index page!";
    }
}
