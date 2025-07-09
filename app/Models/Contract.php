<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date', 'end_date'];

    public function users()
    {
        return $this->belongsToMany(
            User::class,              // The related model
            'contract_user',        // The pivot table name
            'contract_id',            // Foreign key on the pivot table for the Contract model
            'user_id'                 // Foreign key on the pivot table for the User model
        );
    }
}
