@extends('layouts.app')
@section('content')
<div class="container-fluid">
  <h4 class="mb-3">Space Assets (by Area/Building/Space)</h4>

  <form class="row g-2 mb-3">
    <div class="col-md-2"><input class="form-control" name="area_code" placeholder="Area (OFFICE/MESS)" value="{{ request('area_code') }}"></div>
    <div class="col-md-2"><input class="form-control" name="building_code" placeholder="Building" value="{{ request('building_code') }}"></div>
    <div class="col-md-2"><input class="form-control" name="space_no" placeholder="Space No" value="{{ request('space_no') }}"></div>
    <div class="col-md-2"><button class="btn btn-primary">Filter</button></div>
  </form>

  <div class="card">
    <div class="card-body table-responsive">
      <table class="table table-sm">
        <thead>
          <tr>
            <th>Location</th><th>Item</th><th>Tag</th><th>Qty</th><th>Condition</th><th>Status</th>
          </tr>
        </thead>
        <tbody>
          @foreach($rows as $r)
          <tr>
            <td>
              <div><b>{{ $r->area_code }}</b> / {{ $r->building_code }}</div>
              <div>{{ $r->space_no }} - {{ $r->space_name }}</div>
            </td>
            <td>{{ $r->asset_name_snapshot }}</td>
            <td>{{ $r->asset_tag_snapshot }}</td>
            <td>{{ $r->qty }}</td>
            <td>{{ $r->condition_status }}</td>
            <td>{{ $r->inout_status }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>

      {{ $rows->withQueryString()->links() }}
    </div>
  </div>
</div>
@endsection
