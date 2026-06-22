<?php

require_once __DIR__ . '/BaseModel.php';

class WaiverModel extends BaseModel
{
    protected $table = 'tb_waiver';
    protected $primaryKey = 'waiver_id';
    protected $fillable = [
        'mcs_id',
        'waiver_date_approve',
        'waiver_case_id',
        'waiver_start_date',
        'waiver_end_date',
        'waiver_user_update',
        'waiver_date_update',
    ];

    public function getAll()
    {
        $sql = "SELECT w.*, m.mcs_no
                FROM tb_waiver w
                LEFT JOIN tb_mcs m ON w.mcs_id = m.mcs_id
                ORDER BY w.waiver_id DESC";

        return $this->db->query($sql)->fetchAll();
    }
}
