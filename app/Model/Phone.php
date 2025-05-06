<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;
    protected $table = 'phone';
    public $timestamps = false;
    protected $fillable = [
        'phone_number',
        'subscriber_id',
        'room_id',
    ];

    protected static function booted()
    {
        static::created(function ($phone) {
            $phone->save();
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

    public function phones()
    {
        return $this->hasMany(Phone::class);
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class, 'subscriber_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}