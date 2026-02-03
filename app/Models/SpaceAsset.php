<?php

namespace Modules\SpaceOps\Models;

use Illuminate\Database\Eloquent\Model;

class SpaceAsset extends Model
{
  protected $table = 'databases_space_asset';
  protected $guarded = [];

  public function space() { return $this->belongsTo(Space::class, 'space_id'); }
}
