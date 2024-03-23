<?php namespace App\Controllers;
class Pages extends BaseController {
    
    public function home()
    {
        $data = [
            'title' => 'Home | Unipdu Press' , 
            'tes' => ['satu' , 'dua' , 'tiga']
        ];
        echo view('layout/header', $data);
        echo view('pages/home');
        echo view('layout/footer');
    }
    public function about()
    {
        $data = [
            'title' => 'Tentang | Unipdu Press'
        ];
        echo view('layout/header', $data);
        echo view('pages/about');
        echo view('layout/footer');
    }
}