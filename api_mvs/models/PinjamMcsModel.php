<?php

require_once __DIR__ . '/BaseModel.php';

class PinjamMcsModel extends BaseModel
{
    protected $table = 'tb_pinjam_mcs';
    protected $primaryKey = 'pinjam_id';
    protected $fillable = [
        'mcs_id',
        'pinjam_date',
        'pinjam_date_kembali',
        'pinjam_user_id_update',
        'pinjam_user_update',
    ];

    public function getAll()
    {
        $sql = "SELECT p.*, m.mcs_no
                FROM tb_pinjam_mcs p
                LEFT JOIN tb_mcs m ON p.mcs_id = m.mcs_id
                ORDER BY p.pinjam_id DESC";

        return $this->db->query($sql)->fetchAll();
    }
}
