<?php

require_once __DIR__ . '/BaseModel.php';

class McsModel extends BaseModel
{
    protected $table = 'tb_mcs';
    protected $primaryKey = 'mcs_id';
    protected $fillable = [
        'mcs_plant',
        'cust_id',
        'so_id',
        'mcs_no',
        'mcs_date',
        'mcs_reason',
        'mcs_status',
        'mcs_id_record',
        'mcs_remark',
        'mcs_user_input',
        'mcs_date_input',
    ];

    public function getAll()
    {
        $sql = "SELECT m.*, c.cust_name, c.cust_initial
                FROM tb_mcs m
                LEFT JOIN tb_cust c ON m.cust_id = c.cust_id
                ORDER BY m.mcs_id DESC";

        return $this->db->query($sql)->fetchAll();
    }
}
