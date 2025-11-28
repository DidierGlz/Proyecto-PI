<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ImageModel;
use App\Models\UserModel;

class Images extends BaseController
{
    private string $uploadDir = 'uploads/images'; // relativo a public/

    private function isAdmin(): bool
    {
        $user = session('user');
        return isset($user['role']) && $user['role'] === 'admin';
    }

    public function index()
    {
        $user = session('user');
        if (!$user) return redirect()->to('/login');

        $category = $this->request->getGet('category');
        $selectedUserId = $user['id'];

        if ($this->isAdmin()) {
            // Admin puede elegir ver otra galería por ?user_id=
            $selectedUserId = (int) ($this->request->getGet('user_id') ?: $user['id']);
        }

        $imageModel = model(ImageModel::class);
        $images     = $imageModel->getByUser($selectedUserId, $category);
        $categories = $imageModel->getUserCategories($selectedUserId);

        $usersList = [];
        if ($this->isAdmin()) {
            $usersList = model(UserModel::class)->orderBy('name','ASC')->findAll();
        }

        return view('layout/header')
             . view('images/index', [
                 'images'          => $images,
                 'categories'      => $categories,
                 'currentCategory' => $category,
                 'currentUserId'   => $selectedUserId,
                 'usersList'       => $usersList,
             ])
             . view('layout/footer');
    }

    public function upload()
    {
        $user = session('user');
        if (!$user) return redirect()->to('/login');

        $rules = [
            'title'   => 'required|min_length[3]',
            'image'   => 'uploaded[image]|is_image[image]|max_size[image,4096]|mime_in[image,image/jpg,image/jpeg,image/png,image/gif,image/webp]',
            'category'=> 'permit_empty|max_length[100]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $file     = $this->request->getFile('image');
        $title    = trim((string)$this->request->getPost('title'));
        $category = trim((string)$this->request->getPost('category'));

        if ($file->isValid() && !$file->hasMoved()) {
            $targetDir = FCPATH . $this->uploadDir;
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0775, true);
            }

            $newName = $file->getRandomName();
            $file->move($targetDir, $newName);

            model(ImageModel::class)->insert([
                'user_id'   => $user['id'],
                'filename'  => $newName,
                'title'     => $title,
                'category'  => $category ?: null,
                'created_at'=> date('Y-m-d H:i:s'),
            ]);

            return redirect()->to('/images')->with('msg', 'Imagen subida correctamente.');
        }

        return redirect()->back()->with('errors', ['No se pudo subir la imagen.']);
    }

    public function delete($id)
    {
        $user = session('user');
        if (!$user) return redirect()->to('/login');

        $imageModel = model(ImageModel::class);
        $image      = $imageModel->find($id);

        if (!$image) {
            return redirect()->to('/images')->with('errors', ['Imagen no encontrada.']);
        }

        // Si NO es admin, solo puede borrar sus propias imágenes
        if (! $this->isAdmin() && (int)$image['user_id'] !== (int)$user['id']) {
            return redirect()->to('/images')->with('errors', ['No puedes borrar imágenes de otros usuarios.']);
        }

        $filePath = FCPATH . $this->uploadDir . '/' . $image['filename'];
        if (is_file($filePath)) {
            @unlink($filePath);
        }

        $imageModel->delete($id);

        return redirect()->to('/images')->with('msg', 'Imagen eliminada.');
    }
}


