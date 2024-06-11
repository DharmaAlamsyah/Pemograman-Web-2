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

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Edit Data Komik',
            'validation' => session()->getFlashdata('validation') ?? \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];

        return view('komik/edit', $data);
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
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => '{field} komik harus di isi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} komik harus di isi'
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} komik harus di isi'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,2048]|mime_in[sampul,image/png,image/jpeg]|is_image[sampul]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar (maksimal 2MB)',
                    'mime_in' => 'Ekstensi gambar tidak valid (jpg, jpeg, png)',
                    'is_image' => 'Yang Anda unggah bukan gambar'
                ]
            ]
        ])) {
            session()->setFlashdata('validation', \Config\Services::validation());
            return redirect()->to('/books/create')->withInput();


            $fileSampul = $this->request->getFile('sampul');
            $namaSampul = $fileSampul->getRandomName();
            $fileSampul->move('img', $namaSampul);

            $slug = url_title($this->request->getVar('judul'), '-', true);
            $this->komikModel->save([
                'judul' => $this->request->getVar('judul'),
                'slug' => $slug,
                'penulis' => $this->request->getVar('penulis'),
                'penerbit' => $this->request->getVar('penerbit'),
                'sampul' => $namaSampul
            ]);

            session()->setFlashdata('pesan', 'Data berhasil ditambahkan');

            return redirect()->to('/komik');
        }
    }

    public function delete($id)
    {
        // cari nama gambar berdasarkan id
        $komik = $this->komikModel->find($id);

        // cek jika file gambar default
        if ($komik['sampul'] != 'default.png') {

            // hapus gambar
            unlink('img/' . $komik['sampul']);
        }

        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus');
        return redirect()->to('/komik');
    }

    public function update($id)
    {
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        //validasi
        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus di isi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'penulis' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus di isi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'penerbit' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => '{field} komik harus di isi',
                    'is_unique' => '{field} komik sudah terdaftar'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,2048]|mime_in[sampul,image/png,image/jpeg]|is_image[sampul]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar (maksimal 2MB)',
                    'mime_in' => 'Ekstensi gambar tidak valid (jpg, jpeg, png)',
                    'is_image' => 'Yang Anda unggah bukan gambar'
                ]
            ]
        ])) {
            session()->setFlashdata('validation', \Config\Services::validation());
            return redirect()->to('/books/edit/' . $this->request->getVar('slug'))->withInput();
        }


        $fileSampul = $this->request->getFile('sampul');

        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            $namaSampul = $fileSampul->getRandomName();
            $fileSampul->move('img', $namaSampul);
            if ($this->request->getVar('sampulLama') != 'default.png') {
                unlink('img/' . $this->request->getVar('sampulLama'));
            }
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah');

        return redirect()->to('/komik');
    }
}