<?php

require_once __DIR__ . '/BaseModel.php';

class ScanMcsModel extends BaseModel
{
    protected $table = 'tb_scan_mcs';
    protected $primaryKey = 'scan_id';
    protected $fillable = [
        'scan_file',
        'scan_id_update',
        'scan_date_update',
    ];
}
