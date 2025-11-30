<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contato extends Model
{
    protected $table = 'contatos';

    protected $fillable = [
        'pessoa_id',
        'country_code',
        'number'
    ];

    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(Pessoa::class);
    }
}
