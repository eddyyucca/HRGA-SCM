@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">Space Assets</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('spaceops.dashboard') }}">SpaceOps</a></li>
          <li class="breadcrumb-item active">Assets</li>
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
          <div class="col-md-2 mb-2"><input class="form-control" name="area_code" placeholder="Area" value="{{ request('area_code') }}"></div>
          <div class="col-md-2 mb-2"><input class="form-control" name="building_code" placeholder="Building" value="{{ request('building_code') }}"></div>
          <div class="col-md-2 mb-2"><input class="form-control" name="space_no" placeholder="Space No" value="{{ request('space_no') }}"></div>

          <div class="col-md-2 mb-2">
            <select class="form-control" name="condition_status">
              <option value="">Condition (All)</option>
              <option value="BAIK" {{ request('condition_status')=='BAIK'?'selected':'' }}>BAIK</option>
              <option value="RUSAK" {{ request('condition_status')=='RUSAK'?'selected':'' }}>RUSAK</option>
              <option value="SERVICE" {{ request('condition_status')=='SERVICE'?'selected':'' }}>SERVICE</option>
              <option value="HILANG" {{ request('condition_status')=='HILANG'?'selected':'' }}>HILANG</option>
            </select>
          </div>

          <div class="col-md-2 mb-2">
            <select class="form-control" name="inout_status">
              <option value="">IN/OUT (All)</option>
              <option value="IN" {{ request('inout_status')=='IN'?'selected':'' }}>IN</option>
              <option value="OUT" {{ request('inout_status')=='OUT'?'selected':'' }}>OUT</option>
            </select>
          </div>

          <div class="col-md-2 mb-2">
            <button class="btn btn-primary btn-block">Apply</button>
          </div>
          <div class="col-md-2 mb-2">
            <a href="{{ route('spaceops.assets') }}" class="btn btn-secondary btn-block">Reset</a>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3 class="card-title">Assets List</h3></div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-sm">
          <thead>
            <tr>
              <th>Location</th>
              <th>Item</th>
              <th>Tag</th>
              <th>Qty</th>
              <th>Condition</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $r)
              <tr>
                <td style="min-width:220px;">
                  <div>
                    <span class="badge badge-primary">{{ $r->area_code }}</span>
                    <span class="badge badge-info">{{ $r->building_code }}</span>
                  </div>
                  <div><b>{{ $r->space_no }}</b> - {{ $r->space_name }}</div>
                </td>
                <td>{{ $r->asset_name_snapshot }}</td>
                <td>{{ $r->asset_tag_snapshot }}</td>
                <td>{{ $r->qty }}</td>
                <td>
                  @if($r->condition_status=='BAIK') <span class="badge badge-success">BAIK</span>
                  @elseif($r->condition_status=='RUSAK') <span class="badge badge-danger">RUSAK</span>
                  @elseif($r->condition_status=='SERVICE') <span class="badge badge-warning">SERVICE</span>
                  @else <span class="badge badge-secondary">HILANG</span>
                  @endif
                </td>
                <td>
                  @if($r->inout_status=='IN') <span class="badge badge-primary">IN</span>
                  @else <span class="badge badge-dark">OUT</span>
                  @endif
                </td>
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
