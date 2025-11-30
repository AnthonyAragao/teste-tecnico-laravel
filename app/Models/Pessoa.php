<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pessoa extends Model
{
    use SoftDeletes;

    protected $table = 'pessoas';

    protected $fillable = [
        'nome',
        'email',
        'avatar'
    ];

    protected $dates = ['deleted_at'];

    public function contatos(): HasMany
    {
        return $this->hasMany(Contato::class);
    }
}
