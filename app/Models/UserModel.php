<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class UserModel extends Model
{
    protected $DBGroup              = 'default';
    protected $table                = 'users';
    protected $primaryKey           = 'user_id';
    protected $useAutoIncrement     = true;
    protected $insertID             = 0;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $protectFields        = false;
    protected $allowedFields        = [];

    // Dates
    protected $useTimestamps        = true;
    protected $dateFormat           = 'datetime';
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks       = true;
    protected $beforeInsert         = ['beforeInsert'];
    protected $afterInsert          = [];
    protected $beforeUpdate         = ['beforeUpdate'];
    protected $afterUpdate          = [];
    protected $beforeFind           = [];
    protected $afterFind            = [];
    protected $beforeDelete         = [];
    protected $afterDelete          = [];

    protected function beforeInsert(array $data): array
    {
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    protected function beforeUpdate(array $data): array
    {
        return $this->getUpdatedDataWithHashedPassword($data);
    }

    private function getUpdatedDataWithHashedPassword(array $data): array
    {
        if (isset($data['data']['password'])) {
            $plaintextPassword = $data['data']['password'];
            $data['data']['password'] = $this->hashPassword($plaintextPassword);
        }
        return $data;
    }

    private function hashPassword(string $plaintextPassword): string
    {
        return password_hash($plaintextPassword, PASSWORD_BCRYPT);
    }

    public function findUserByEmailAddress(string $emailAddress)
    {
        $user = $this
            ->where(['email' => $emailAddress, 'active' => 1])
            ->first();

        if (!$user)
            throw new Exception(lang("App.errorLogin"));

        return $user;
    }

    public function findUser($id)
    {
        $this->select("{$this->table}.*, p.provinsi, k.nama_kabupaten");
        $this->join("provinsi p", "p.provinsi_id = {$this->table}.provinsi_id", "left");
        $this->join("kabupaten k", "k.kabupaten_id = {$this->table}.kabupaten_id", "left");
        $this->where("{$this->table}.user_id", $id);
        $query = $this->first();
        return $query;
    }
}
