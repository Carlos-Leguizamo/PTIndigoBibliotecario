<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Prestamo extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id','isbn','identificacionUsuario','tipoUsuario','fechaMaximaDevolucion'];

    protected static function booted()
    {
        static::creating(function($model){
            if (empty($model->id)) $model->id = (string) Str::uuid();
        });
    }
}
