<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    protected $table = 'department';
    public $timestamps = false;
    protected $fillable = [
        'room_name',
        'department_id',
        'room_type_id',
    ];

    protected static function booted()
    {
        static::created(function ($room) {
            $room->save();
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