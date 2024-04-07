<?php

namespace App\Models;

use CodeIgniter\Model;

class KomikModel extends Model
{
    protected $table      = 'komik';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    //membuat method detail
    public function getKomik($slug =false)
    {
        //Jika Slug kosong yang eksekusi(generate) code ini
        if ($slug == false) {
            return $this->findAll();
        }

        //Jika Slug nya ada yang eksekusi(generate) code ini
        return $this->where(['slug' => $slug])->first();
    }
}