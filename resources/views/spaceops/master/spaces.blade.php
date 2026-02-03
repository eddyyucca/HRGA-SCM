@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">Master Spaces</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('spaceops.dashboard') }}">SpaceOps</a></li>
          <li class="breadcrumb-item active">Spaces</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Filter</h3>
      </div>
      <div class="card-body">
        <form class="form-row">
          <div class="col-md-2 mb-2">
            <input class="form-control" name="area_code" placeholder="Area (MESS/OFFICE)" value="{{ request('area_code') }}">
          </div>
          <div class="col-md-2 mb-2">
            <input class="form-control" name="building_code" placeholder="Building (FP11/BA)" value="{{ request('building_code') }}">
          </div>
          <div class="col-md-2 mb-2">
            <input class="form-control" name="space_no" placeholder="Space No (A1)" value="{{ request('space_no') }}">
          </div>
          <div class="col-md-2 mb-2">
            <button class="btn btn-primary btn-block">Apply</button>
          </div>
          <div class="col-md-2 mb-2">
            <a href="{{ route('spaceops.spaces') }}" class="btn btn-secondary btn-block">Reset</a>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Spaces List</h3>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-sm">
          <thead>
            <tr>
              <th>Area</th>
              <th>Building</th>
              <th>Space No</th>
              <th>Name</th>
              <th>Kind</th>
              <th>Capacity Bed</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $r)
              <tr>
                <td><span class="badge badge-primary">{{ $r->area_code }}</span></td>
                <td><span class="badge badge-info">{{ $r->building_code }}</span> - {{ $r->building_name }}</td>
                <td><b>{{ $r->space_no }}</b></td>
                <td>{{ $r->space_name }}</td>
                <td>
                  @if($r->space_kind=='MESS')
                    <span class="badge badge-success">MESS</span>
                  @elseif($r->space_kind=='OFFICE')
                    <span class="badge badge-warning">OFFICE</span>
                  @else
                    <span class="badge badge-secondary">OTHER</span>
                  @endif
                </td>
                <td>{{ $r->capacity_bed }}</td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center text-muted">No data</td></tr>
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
