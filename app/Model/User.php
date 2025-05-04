<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface
{
    use HasFactory;
    protected $table = 'user';
    public $timestamps = false;
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'login',
        'password',
        'avatar',
        'role_id',
    ];

    protected static function booted()
    {
        static::created(function ($user) {
            $user->password = md5($user->password);
            $user->save();
        });
    }

    //Выборка пользователя по первичному ключу
    public function findIdentity(int $id)
    {
        return self::where('id', $id)->first();
    }

    //Возврат первичного ключа
    public function getId(): int
    {
        return $this->id;
    }

    //Возврат аутентифицированного пользователя
    public function attemptIdentity(array $credentials)
    {
        return self::where(['login' => $credentials['login'],
            'password' => md5($credentials['password'])])->first();
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function uploadAvatar(array $file): ?string
    {
        if ($file['name'] == "") {
            return 'public/uploads/avatars/default_avatar.jpg';
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $fileTmpPath = $file['tmp_name'];
        $fileName = $file['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($fileExtension, $allowedExtensions)) {
            return null;
        }
        $fullPath = 'uploads/avatars/' . $newFileName;
        move_uploaded_file($fileTmpPath, $fullPath);
        return 'public/' . $fullPath;
    }

}