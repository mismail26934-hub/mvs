<?php

class CrudHandler
{
    /** @var BaseModel */
    private $model;

    public function __construct(BaseModel $model)
    {
        $this->model = $model;
    }

    public function handle($method, $id, array $input)
    {
        $pk = $this->model->getPrimaryKey();

        switch ($method) {
            case 'GET':
                if ($id > 0) {
                    $row = $this->model->getById($id);
                    if (!$row) {
                        jsonError('Data tidak ditemukan', 404);
                    }
                    jsonSuccess($row);
                }
                jsonSuccess($this->model->getAll());
                break;

            case 'POST':
                if (empty($input)) {
                    jsonError('Request body JSON wajib diisi', 422);
                }
                $newId = $this->model->create($input);
                jsonSuccess([$pk => $newId], 'Data berhasil dibuat', 201);
                break;

            case 'PUT':
                if ($id <= 0) {
                    jsonError('ID wajib diisi', 400);
                }
                if (!$this->model->getById($id)) {
                    jsonError('Data tidak ditemukan', 404);
                }
                if (empty($input)) {
                    jsonError('Request body JSON wajib diisi', 422);
                }
                $this->model->update($id, $input);
                jsonSuccess(null, 'Data berhasil diupdate');
                break;

            case 'DELETE':
                if ($id <= 0) {
                    jsonError('ID wajib diisi', 400);
                }
                if (!$this->model->getById($id)) {
                    jsonError('Data tidak ditemukan', 404);
                }
                $this->model->delete($id);
                jsonSuccess(null, 'Data berhasil dihapus');
                break;

            default:
                jsonError('Method tidak diizinkan', 405);
        }
    }
}
