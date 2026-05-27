<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Template_webpage extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'content',
        'picture_1',
        'picture_2',
    ];

    // Accessor methods for picture paths
    public function getPicture1Attribute($value)
    {
        return $value ? Storage::url('websitepictures/' . basename($value)) : null;
    }

    public function getPicture2Attribute($value)
    {
        return $value ? Storage::url('websitepictures/' . basename($value)) : null;
    }


    /**
     * Zoekfunctionaliteit: doorzoek alle kolommen van de tabel */

    public function scopeSearchColumns($query, $search = '%', $columns = [])
    {
        if (empty($columns)) {
            // If no specific columns are provided, use fillable columns
            $columns = $this->fillable;
        }

        return $query->where(function ($query) use ($search, $columns) {
            foreach ($columns as $column) {
                $query->orWhere($column, 'like', "%{$search}%");
            }
        });
    }

}
