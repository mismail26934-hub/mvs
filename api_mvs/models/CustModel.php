<?php

require_once __DIR__ . '/BaseModel.php';

class CustModel extends BaseModel
{
    protected $table = 'tb_cust';
    protected $primaryKey = 'cust_id';
    protected $fillable = [
        'cust_name',
        'cust_initial',
        'cust_id_update',
        'cust_date_update',
    ];
}
