@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">SpaceOps Dashboard</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
          <li class="breadcrumb-item active">SpaceOps</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ $stats['active_rooming'] }}</h3>
            <p>Active Rooming</p>
          </div>
          <div class="icon"><i class="fas fa-bed"></i></div>
          <a href="{{ route('spaceops.rooming') }}" class="small-box-footer">
            View <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ $stats['vacant_beds'] }}</h3>
            <p>Vacant Beds</p>
          </div>
          <div class="icon"><i class="fas fa-door-open"></i></div>
          <a href="{{ route('spaceops.rooming.vacant') }}" class="small-box-footer">
            View <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ $stats['assets_in'] }}</h3>
            <p>Assets (IN)</p>
          </div>
          <div class="icon"><i class="fas fa-boxes"></i></div>
          <a href="{{ route('spaceops.assets') }}" class="small-box-footer">
            View <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-secondary">
          <div class="inner">
            <h3>{{ $stats['spaces_total'] }}</h3>
            <p>Total Spaces</p>
          </div>
          <div class="icon"><i class="fas fa-building"></i></div>
          <a href="{{ route('spaceops.spaces') }}" class="small-box-footer">
            View <i class="fas fa-arrow-circle-right"></i>
          </a>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Spaces by Area</h3>
      </div>
      <div class="card-body">
        <table class="table table-sm table-bordered">
          <thead>
            <tr><th>Area</th><th>Total Spaces</th></tr>
          </thead>
          <tbody>
            @foreach($byArea as $r)
              <tr>
                <td><span class="badge badge-primary">{{ $r->area_code }}</span></td>
                <td>{{ $r->total_spaces }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</section>
@endsection
