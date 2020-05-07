@if (isset($preference))
<form action="{{ route('preference.update') }}" method="POST">
  @method('PUT')
@else
<form action="{{ route('preference.store') }}" method="POST">
@endif

  @csrf

  <div class="field">
    <label class="label" for="unit_dipslay_preference_id">Unit Display</label>
      <div class="control">
        <label class="radio @error('unit_dipslay_preference_id') is-danger @enderror">
          <input type="radio" name="unit_dipslay_preference_id" value="1"
          @if (old('unit_dipslay_preference_id', $preference->unit_dipslay_preference_id ?? '1')==1) checked @endif
          >
          Imperial (lb, in)
        </label>
        <label class="radio @error('unit_dipslay_preference_id') is-danger @enderror">
          <input type="radio" name="unit_dipslay_preference_id" value="2"
          @if (old('unit_dipslay_preference_id', $preference->unit_dipslay_preference_id ?? '')==2) checked @endif
          >
          Metric (kg, cm)
        </label>
      </div>
    @error('unit_dipslay_preference_id')
        <p class="help is-danger">{{ $message }}</p>
    @enderror
  </div>


  <div class="field is-grouped buttons">
    <div class="control">
      <button type="submit" class="button is-link">
        <span class="icon is-small">
      <i class="fas fa-check"></i>
    </span>
    <span>Save</span>
  </button>
    </div>
    <div class="control">
      <a href="{{ url()->previous() }}" class="button is-link is-light">
        <span class="icon is-small">
          <i class="fas fa-times"></i>
        </span>
        <span>Cancel</span>
      </a>
    </div>

  </div>

</form>
