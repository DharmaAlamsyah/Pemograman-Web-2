<?php namespace App\Controllers;
class Pages extends BaseController {
    
    public function home()
    {
        $data = [
            'title' => 'Home | Unipdu Press' 
            //'tes' => ['satu' , 'dua' , 'tiga']
        ];
        return view('pages/home', $data);
        
    }
    public function about()
    {
        $data = [
            'title' => 'Home | Unipdu Press'
        ];
        return view('pages/about', $data);
    }
    public function contact()
    {
        $data = [
            'title' => 'Home | Unipdu Press',
            'alamat' => [
                'tipe' => 'Rumah',
                'alamat' => 'Desa Peterongan no.28',
                'kota' => 'Jombang'
            ],
            'alamat1' => [
                'tipe' => 'Kantor',
                'alamat' => 'Kompleks Ponpes Darul Ulum Peterongan',
                'kota' => 'Jombang'
            ]
        ];
        return view('pages/contact', $data);
    }
}