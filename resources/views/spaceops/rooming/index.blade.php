@extends('layouts.app')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6"><h1 class="m-0">Rooming (Active)</h1></div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('spaceops.dashboard') }}">SpaceOps</a></li>
          <li class="breadcrumb-item active">Rooming</li>
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
        <div class="card-tools">
          <a href="{{ route('spaceops.rooming.vacant') }}" class="btn btn-success btn-sm">
            <i class="fas fa-door-open"></i> Vacant Beds
          </a>
        </div>
      </div>
      <div class="card-body">
        <form class="form-row">
          <div class="col-md-2 mb-2">
            <input class="form-control" name="area_code" placeholder="Area" value="{{ request('area_code') }}">
          </div>
          <div class="col-md-2 mb-2">
            <input class="form-control" name="building_code" placeholder="Building" value="{{ request('building_code') }}">
          </div>
          <div class="col-md-2 mb-2">
            <input class="form-control" name="space_no" placeholder="Space No" value="{{ request('space_no') }}">
          </div>
          <div class="col-md-2 mb-2">
            <select class="form-control" name="stay_type">
              <option value="">Stay Type (All)</option>
              <option value="FIXED"  {{ request('stay_type')=='FIXED'?'selected':'' }}>FIXED</option>
              <option value="HOTBED" {{ request('stay_type')=='HOTBED'?'selected':'' }}>HOTBED</option>
              <option value="VISITOR"{{ request('stay_type')=='VISITOR'?'selected':'' }}>VISITOR</option>
            </select>
          </div>
          <div class="col-md-2 mb-2">
            <button class="btn btn-primary btn-block">Apply</button>
          </div>
          <div class="col-md-2 mb-2">
            <a href="{{ route('spaceops.rooming') }}" class="btn btn-secondary btn-block">Reset</a>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Active Occupancy + Assets</h3>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover table-sm">
          <thead>
            <tr>
              <th>Location</th>
              <th>Occupant</th>
              <th>Stay</th>
              <th>Onsite</th>
              <th>Offsite</th>
              <th>Assets (IN)</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $r)
              @php $key = $r->area_code.'|'.$r->building_code.'|'.$r->space_no; @endphp
              <tr>
                <td style="min-width:220px;">
                  <div>
                    <span class="badge badge-primary">{{ $r->area_code }}</span>
                    <span class="badge badge-info">{{ $r->building_code }}</span>
                  </div>
                  <div><b>{{ $r->space_no }}</b> - {{ $r->space_name }}</div>
                </td>

                <td style="min-width:240px;">
                  <div><b>{{ $r->manpower_name_snapshot }}</b></div>
                  <div class="text-muted">{{ $r->position_snapshot }} | {{ $r->company_snapshot }}</div>
                </td>

                <td>
                  @if($r->stay_type=='FIXED')
                    <span class="badge badge-success">FIXED</span>
                  @elseif($r->stay_type=='HOTBED')
                    <span class="badge badge-warning">HOTBED</span>
                  @else
                    <span class="badge badge-secondary">VISITOR</span>
                  @endif
                </td>

                <td>{{ $r->tgl_onsite }}</td>
                <td>{{ $r->tgl_offsite }}</td>

                <td style="min-width:320px;">
                  @if(isset($assetsBySpace[$key]))
                    <ul class="mb-0 pl-3">
                      @foreach($assetsBySpace[$key] as $a)
                        <li>{{ $a->asset_name_snapshot }} ({{ $a->qty }})
                          <span class="badge badge-light">{{ $a->condition_status }}</span>
                        </li>
                      @endforeach
                    </ul>
                  @else
                    <span class="text-muted">-</span>
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
