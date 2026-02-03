<?php

namespace Modules\SpaceOps\Models;

use Illuminate\Database\Eloquent\Model;

class Space extends Model
{
  protected $table = 'databases_space';
  protected $guarded = [];

  public function building() { return $this->belongsTo(Building::class, 'building_id'); }
  public function beds() { return $this->hasMany(Bed::class, 'space_id'); }
}
