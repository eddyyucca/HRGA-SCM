<?php

namespace Modules\SpaceOps\Models;

use Illuminate\Database\Eloquent\Model;

class Rooming extends Model
{
  protected $table = 'databases_rooming';
  protected $guarded = [];

  public function space() { return $this->belongsTo(Space::class, 'space_id'); }
  public function bed() { return $this->belongsTo(Bed::class, 'bed_id'); }
}
