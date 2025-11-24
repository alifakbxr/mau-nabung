<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Category;

class CategoryController {
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $categoryModel = new Category();
        $categories = $categoryModel->getByUser($_SESSION['user_id']);

        View::render('categories/index', ['categories' => $categories]);
    }

    public function store() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $data = [
            'user_id' => $_SESSION['user_id'],
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'color' => $_POST['color']
        ];

        $categoryModel = new Category();
        $categoryModel->create($data);
        
        $_SESSION['success'] = 'Kategori berhasil ditambahkan';
        View::redirect('/categories');
    }

    public function delete() {
        if (!isset($_SESSION['user_id'])) {
            View::redirect('/login');
        }

        $id = $_POST['id'];
        $categoryModel = new Category();
        $categoryModel->deleteForUser($id, $_SESSION['user_id']);

        $_SESSION['success'] = 'Kategori berhasil dihapus';
        View::redirect('/categories');
    }
}
