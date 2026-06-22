<?php

require_once __DIR__ . '/BaseModel.php';

class RcvModel extends BaseModel
{
    protected $table = 'tb_rcv';
    protected $primaryKey = 'rcv_id';
    protected $fillable = [
        'mcs_id',
        'rcv_by',
        'rcv_date',
        'rcv_user_update',
        'rcv_date_update',
        'rcv_remark',
    ];

    public function getAll()
    {
        $sql = "SELECT r.*, m.mcs_no
                FROM tb_rcv r
                LEFT JOIN tb_mcs m ON r.mcs_id = m.mcs_id
                ORDER BY r.rcv_id DESC";

        return $this->db->query($sql)->fetchAll();
    }
}
