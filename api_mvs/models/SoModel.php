<?php

require_once __DIR__ . '/BaseModel.php';

class SoModel extends BaseModel
{
    protected $table = 'tb_so';
    protected $primaryKey = 'so_id';
    protected $fillable = [
        'mcs_id',
        'so_no',
        'so_po',
        'so_item',
        'so_date',
        'so_pn',
        'so_qty',
        'so_pn_desc',
        'so_pn_price',
        'so_note',
        'so_remark',
        'so_id_input',
        'so_date_update',
    ];

    public function getAll()
    {
        $sql = "SELECT s.*, m.mcs_no
                FROM tb_so s
                LEFT JOIN tb_mcs m ON s.mcs_id = m.mcs_id
                ORDER BY s.so_id DESC";

        return $this->db->query($sql)->fetchAll();
    }
}
