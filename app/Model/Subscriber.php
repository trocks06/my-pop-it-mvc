<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $table = 'subscriber';
    public $timestamps = false;
    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'birth_date',
        'department_id',
    ];

    protected static function booted()
    {
        static::created(function ($subscriber) {
            $subscriber->save();
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

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function phones()
    {
        return $this->hasMany(Phone::class);
    }
}