<?php
namespace App\Models;

use CodeIgniter\Model;

class ImageModel extends Model
{
    protected $table         = 'images';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['user_id', 'filename', 'title', 'category', 'created_at'];
    protected $useTimestamps = false;

    public function getByUser(int $userId, ?string $category = null): array
    {
        $builder = $this->where('user_id', $userId)
                        ->orderBy('created_at', 'DESC');

        if ($category !== null && $category !== '') {
            $builder->where('category', $category);
        }

        return $builder->findAll();
    }

    public function getUserCategories(int $userId): array
    {
        return $this->distinct()          // <- AQUÍ
                    ->select('category')   // <- Y AQUÍ
                    ->where('user_id', $userId)
                    ->where('category IS NOT NULL', null, false)
                    ->orderBy('category', 'ASC')
                    ->findAll();
    }
}

