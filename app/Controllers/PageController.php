<?php

namespace App\Controllers;

use App\Core\View;

class PageController {
    public function features() {
        View::render('pages/features');
    }

    public function about() {
        View::render('pages/about');
    }

    public function howItWorks() {
        View::render('pages/how_it_works');
    }

    public function contact() {
        View::render('pages/contact');
    }

    public function compare() {
        View::render('pages/compare');
    }

    public function terms() {
        View::render('pages/terms');
    }

    public function privacy() {
        View::render('pages/privacy');
    }

    public function cookiePolicy() {
        View::render('pages/cookie');
    }

    public function faq() {
        View::render('pages/faq');
    }
}
