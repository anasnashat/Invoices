<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_name', 'description','user_id' ,'section_id','deleted_at'];



    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoices::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }



}
