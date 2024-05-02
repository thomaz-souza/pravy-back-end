<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Address extends Model
{

    use HasFactory;

    // Definindo a tabela associada ao modelo
    protected $table = 'addresses';

    // Definindo os atributos que podem ser atribuídos em massa
    protected $fillable = [
        'user_id',
        'street',
        'city',
        'state',
        'country',
        'zip'
    ];

    // Definindo a relação com o modelo User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
