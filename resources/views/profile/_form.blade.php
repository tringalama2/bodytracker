@if (isset($profile))
<form action="{{ route('profile.update') }}" method="POST">
  @method('PUT')
@else
<form action="{{ route('profile.store') }}" method="POST">
@endif

  @csrf

  <div class="field">
    <label class="label" for="gender">Gender</label>
      <div class="control">
        <label class="radio @error('gender') is-danger @enderror">
          <input type="radio" name="gender" value="m"
          @if (old('gender', $profile->gender ?? '')=='m') checked @endif
          >
          Male
        </label>
        <label class="radio @error('gender') is-danger @enderror">
          <input type="radio" name="gender" value="f"
          @if (old('gender', $profile->gender ?? '')=='f') checked @endif
          >
          Female
        </label>
      </div>
    @error('gender')
        <p class="help is-danger">{{ $message }}</p>
    @enderror
  </div>

  <div class="field">
    <label class="label" for="height_in">Height</label>
    <div class="field has-addons">
        <div class="control is-expanded">
          <input id="height_in" name="height_in" type="text"
            value="{{ old('height_in', $profile->height ?? '') }}"
            class="input @error('height_in') is-danger @enderror">
        </div>
        <div class="control">
          <a class="button is-static">
            <!-- User Units -->
            {{ auth()->user()->preference->prefersMetric() ? 'cm' : 'in' }}
          </a>
        </div>
      </div>
    @error('height_in')
        <p class="help is-danger">{{ $message }}</p>
    @enderror
  </div>

  <div class="field">
    <label class="label" for="start_weight_lbs">Starting Weight</label>
    <div class="field has-addons">
      <div class="control is-expanded">
        <input id="start_weight_lbs" name="start_weight_lbs" type="text"
          value="{{ old('start_weight_lbs', $profile->startWeight ?? '') }}"
          class="input @error('start_weight_lbs') is-danger @enderror">
      </div>
      <div class="control">
        <a class="button is-static">
        {{ auth()->user()->preference->prefersMetric() ? 'kg' : 'lb' }}
        </a>
      </div>
    </div>
    @error('start_weight_lbs')
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
