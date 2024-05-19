<?php 

namespace App\Controllers;

use App\Models\KomikModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Komik extends BaseController 
{
    protected $komikModel;
    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }
    
    public function index()
    {
        // karena sudah membuat method sendiri buat menampilkan,
        // code ini dihapus atau di buat komentar
        // $komik = $this->komikModel->findAll();

        $data = [
            'title' => 'Daftar Komik',
            //Di panggil menggunakan ini dan tanpa parameter
            'komik' => $this->komikModel->getKomik()
        ];
        // $komikModel = new \App\Models\KomikModel();

        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik',
            'komik' => $this->komikModel->getKomik($slug)
        ];

        //jika komik tidak ada ditabel
        if (empty($data['komik'])) {
            throw new PageNotFoundException('Judul komik ' . $slug . ' tidak ditemukan');
        }

        return view('komik/detail', $data);
    }
    
    public function create()
    {
        $data = [
            'title' => 'Form Tambah Data Komik',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        // validasi input
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[books.judul]',
                'errors' => [
                    'required' => '{field} komik harus di isi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'penulis' => [
                'rules' => 'required|is_unique[books.penulis]',
                'errors' => [
                    'required' => '{field} komik harus di isi',
                    'is_unique' => '{field} komik harus diisi'
                ]
            ],
            'penerbit' => [
                'rules' => 'required|is_unique[books.penerbit]',
                'errors' => [
                    'required' => '{field} komik harus diisi',
                ]
            ],
            'sampul' => [
                'rules' => 'required|is_unique[books.sampul]',
                'errors' => [
                    'required' => '{field} komik harus diisi',
                ]
            ]
        ])){
            session()->setFlashdata('validation', \Config\Services::validation());
            return redirect()->to('/komik/create')->withInput();
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $this->request->getVar('sampul')

        ]);

        session()->setFlashdata('pesan', 'Data Berhasil Ditambahkan');

        return redirect()->to('/komik');
    }
}