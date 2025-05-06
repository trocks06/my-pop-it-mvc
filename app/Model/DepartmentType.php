<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepartmentType extends Model
{
    use HasFactory;
    protected $table = 'department_type';
    public $timestamps = false;
    protected $fillable = [
        'type_name',
    ];

    protected static function booted()
    {
        static::created(function ($department_type) {
            $department_type->save();
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
}