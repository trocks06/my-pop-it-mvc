<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $table = 'department';
    public $timestamps = false;
    protected $fillable = [
        'department_name',
        'department_type_id',
    ];

    protected static function booted()
    {
        static::created(function ($department) {
            $department->save();
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
    public function departmentType()
    {
        return $this->belongsTo(DepartmentType::class, 'department_type_id');
    }
}