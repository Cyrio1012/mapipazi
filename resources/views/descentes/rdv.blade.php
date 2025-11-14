@extends('layouts.app')
@section('title', 'rdv')
@section('content')

<div class="container py-4">
  <!-- Section Fandraisana manaraka -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-bottom-0 pb-2">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="fw-semibold text-primary mb-0">
          <i class="fas fa-clock me-2"></i>Fandraisana manaraka
        </h5>
        <span class="badge bg-primary bg-opacity-10 text-primary">{{ $rdvEnAttente->total() }}</span>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="border-0 ps-4">Num PV</th>
              <th class="border-0">Ny voambara</th>
              <th class="border-0">adresy</th>
              <th class="border-0">Lah.tarobia</th>
              <th class="border-0 pe-4">Fotoana nifanomezina</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rdvEnAttente as $rdv)
              <tr class="border-bottom">
                <td class="ps-4 fw-medium text-muted">{{ str_pad($rdv->num_pv, 3, '0', STR_PAD_LEFT) }}</td>
                <td class="fw-semibold">{{ $rdv->pers_verb }}</td>
                <td class="text-muted">{{ $rdv->adresse }}</td>
                <td>
                  <span class="badge bg-light text-dark border">{{ $rdv->contact }}</span>
                </td>
                <td class="pe-4">
                  <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2">
                    <i class="far fa-calendar me-1"></i>
                    {{ $rdv->date?->format('d/m/Y') }} a {{ $rdv->heure?->format('H:i') }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="far fa-folder-open fa-2x mb-2 d-block"></i>
                  Aucun rdv en attente.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @if($rdvEnAttente->hasPages())
    <div class="card-footer bg-transparent border-top-0 pt-3">
      {{ $rdvEnAttente->links() }}
    </div>
    @endif
  </div>

  <!-- Section FT Voarakitra -->
  <div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-transparent border-bottom-0 pb-2">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="fw-semibold text-success mb-0">
          <i class="fas fa-check-circle me-2"></i>FT Voarakitra
        </h5>
        <span class="badge bg-success bg-opacity-10 text-success">{{ $rdvFait->total() }}</span>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="border-0 ps-4">Num PV</th>
              <th class="border-0">Ny voambara</th>
              <th class="border-0">adresy</th>
              <th class="border-0">Lah.tarobia</th>
              <th class="border-0 pe-4">Fotoana nifanomezina</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rdvFait as $rdv)
              <tr class="border-bottom">
                <td class="ps-4 fw-medium text-muted">{{ str_pad($rdv->num_pv, 3, '0', STR_PAD_LEFT) }}</td>
                <td class="fw-semibold">{{ $rdv->pers_verb }}</td>
                <td class="text-muted">{{ $rdv->adresse }}</td>
                <td>
                  <span class="badge bg-light text-dark border">{{ $rdv->contact }}</span>
                </td>
                <td class="pe-4">
                  <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2">
                    <i class="far fa-calendar-check me-1"></i>
                    {{ $rdv->date?->format('d/m/Y') }} a {{ $rdv->heure?->format('H:i') }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="far fa-folder-open fa-2x mb-2 d-block"></i>
                  Aucun rdv effectué.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @if($rdvFait->hasPages())
    <div class="card-footer bg-transparent border-top-0 pt-3">
      {{ $rdvFait->links() }}
    </div>
    @endif
  </div>

  <!-- Section Tsy Tonga natsoina -->
  <div class="card border-0 shadow-sm">
    <div class="card-header bg-transparent border-bottom-0 pb-2">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="fw-semibold text-danger mb-0">
          <i class="fas fa-times-circle me-2"></i>Tsy Tonga natsoina
        </h5>
        <span class="badge bg-danger bg-opacity-10 text-danger">{{ $rdvRate->total() }}</span>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th class="border-0 ps-4">Num PV</th>
              <th class="border-0">Ny voambara</th>
              <th class="border-0">adresy</th>
              <th class="border-0">Lah.tarobia</th>
              <th class="border-0 pe-4">Fotoana nifanomezina</th>
              <th class="border-0 pe-4">Fepetramanaraka</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($rdvRate as $rdv)
              <tr class="border-bottom">
                <td class="ps-4 fw-medium text-muted">{{ str_pad($rdv->num_pv, 3, '0', STR_PAD_LEFT) }}</td>
                <td class="fw-semibold">{{ $rdv->pers_verb }}</td>
                <td class="text-muted">{{ $rdv->adresse }}</td>
                <td>
                  <span class="badge bg-light text-dark border">{{ $rdv->contact }}</span>
                </td>
                <td class="pe-4">
                  <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-3 py-2">
                    <i class="far fa-calendar-times me-1"></i>
                    {{ $rdv->date?->format('d/m/Y') }} a {{ $rdv->heure?->format('H:i') }}
                  </span>
                </td>
                <td class="text-muted">
                  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Fiantsoana manaraka
                  </button>
                </td>
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">

                        <form action="{{ route('descente.rdvmaj', $rdv )}}" method="post">
                          @csrf
                          <div class="mb-3">
                            <label for="date_rdv_ft" class="form-label">Date du RDV</label>
                            <input type="date" class="form-control" id="date_rdv_ft" name="date_rdv_ft" required>
                          </div>
                          <div class="mb-3">
                            <label for="heure_rdv_ft" class="form-label">Heure du RDV</label>
                            <input type="time" class="form-control" id="heure_rdv_ft" name="heure_rdv_ft" required>
                          </div>
                          <button type="submit" class="btn btn-primary">Enregistrer le RDV</button>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Understood</button>
                      </div>
                    </div>
                  </div>
                </div>

              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-4">
                  <i class="far fa-folder-open fa-2x mb-2 d-block"></i>
                  Aucun rdv raté.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
    @if($rdvRate->hasPages())
    <div class="card-footer bg-transparent border-top-0 pt-3">
      {{ $rdvRate->links() }}
    </div>
    @endif
  </div>
</div>





<style>
.card {
  border-radius: 12px;
}
.table th {
  font-weight: 500;
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.badge {
  font-weight: 500;
  border-radius: 8px;
}
</style>

@endsection