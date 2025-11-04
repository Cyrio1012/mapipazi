<div class="row g-3">
  <div class="col-md-6">
    <label class="form-label">ID Descent</label>
    <input type="number" name="id_descent" value="{{ old('id_descent', $matro->id_descent) }}" class="form-control" required>
  </div>

  <div class="col-md-6">
    <label class="form-label">Désignation</label>
    <input type="text" name="designation" value="{{ old('designation', $matro->designation) }}" class="form-control" required>
  </div>

  <div class="col-md-6">
    <label class="form-label">Marque</label>
    <input type="text" name="marque" value="{{ old('marque', $matro->marque) }}" class="form-control">
  </div>

  <div class="col-md-6">
    <label class="form-label">Type</label>
    <input type="text" name="type" value="{{ old('type', $matro->type) }}" class="form-control">
  </div>

  <div class="col-md-6">
    <label class="form-label">IMM</label>
    <input type="text" name="imm" value="{{ old('imm', $matro->imm) }}" class="form-control">
  </div>

  <div class="col-md-6">
    <label class="form-label">Volume</label>
    <input type="text" name="volume" value="{{ old('volume', $matro->volume) }}" class="form-control">
  </div>

  <div class="col-12 text-end mt-3">
    <button type="submit" class="btn btn-outline-dark px-4 rounded-pill">💾 Enregistrer</button>
  </div>
</div>
