@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">Vacant Beds</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('spaceops.dashboard') }}">SpaceOps</a></li>
          <li class="breadcrumb-item active">Vacant</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header"><h3 class="card-title">Filter</h3></div>
      <div class="card-body">
        <form class="form-row">
          <div class="col-md-2 mb-2">
            <input class="form-control" name="area_code" placeholder="Area" value="{{ request('area_code') }}">
          </div>
          <div class="col-md-2 mb-2">
            <input class="form-control" name="building_code" placeholder="Building" value="{{ request('building_code') }}">
          </div>
          <div class="col-md-2 mb-2">
            <select class="form-control" name="bed_type">
              <option value="">Bed Type (All)</option>
              <option value="FIXED"  {{ request('bed_type')=='FIXED'?'selected':'' }}>FIXED</option>
              <option value="HOTBED" {{ request('bed_type')=='HOTBED'?'selected':'' }}>HOTBED</option>
            </select>
          </div>
          <div class="col-md-2 mb-2">
            <button class="btn btn-primary btn-block">Apply</button>
          </div>
          <div class="col-md-2 mb-2">
            <a href="{{ route('spaceops.rooming.vacant') }}" class="btn btn-secondary btn-block">Reset</a>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3 class="card-title">Available Beds</h3></div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-sm">
          <thead>
            <tr>
              <th>Area</th><th>Building</th><th>Space</th><th>Bed No</th><th>Bed Type</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $r)
            <tr>
              <td><span class="badge badge-primary">{{ $r->area_code }}</span></td>
              <td><span class="badge badge-info">{{ $r->building_code }}</span></td>
              <td><b>{{ $r->space_no }}</b> - {{ $r->space_name }}</td>
              <td>{{ $r->bed_no }}</td>
              <td>
                @if($r->bed_type=='HOTBED')
                  <span class="badge badge-warning">HOTBED</span>
                @else
                  <span class="badge badge-success">FIXED</span>
                @endif
              </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted">No data</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        {{ $rows->withQueryString()->links() }}
      </div>
    </div>

  </div>
</section>
@endsection
