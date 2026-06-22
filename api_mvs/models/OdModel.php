<?php

require_once __DIR__ . '/BaseModel.php';

class OdModel extends BaseModel
{
    protected $table = 'tb_od';
    protected $primaryKey = 'od_id';
    protected $fillable = [
        'so_id',
        'od_no',
        'od_pn',
        'od_item',
        'od_qty',
        'od_qty_supply',
        'od_date',
        'od_gi_date',
        'od_user_update',
        'od_date_input',
    ];

    public function getAll()
    {
        $sql = "SELECT o.*, s.so_no
                FROM tb_od o
                LEFT JOIN tb_so s ON o.so_id = s.so_id
                ORDER BY o.od_id DESC";

        return $this->db->query($sql)->fetchAll();
    }
}
