<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VillageAsset extends Model
{
    protected $table = 'village_assets';

    protected $fillable = [
        'asset_code', 'name', 'category', 'description', 'acquisition_date',
        'acquisition_value', 'current_condition', 'location', 'quantity',
        'unit', 'photo_path', 'source_fund', 'responsible_person',
        'notes', 'depreciation_value', 'disposal_date',
    ];

    protected $casts = [
        'acquisition_date' => 'date',
        'disposal_date' => 'date',
        'acquisition_value' => 'decimal:2',
        'depreciation_value' => 'decimal:2',
    ];
}
