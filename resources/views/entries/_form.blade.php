@if (isset($entry))
<form action="{{ route('entries.update', compact('entry')) }}" method="POST">
  @method('PUT')
@else
<form action="{{ route('entries.store') }}" method="POST">
@endif

  @csrf

  <div class="field">
    <label class="label" for="entry_date">Entry Date</label>
    <div class="control">
      <input id="entry_date" name="entry_date" type="text"
        value="{{ old('entry_date', isset($entry->entry_date) ? $entry->entry_date->format('m/d/Y') : '') }}"
        class="input @error('entry_date') is-danger @enderror">
    </div>
    @error('entry_date')
        <p class="help is-danger">{{ $message }}</p>
    @enderror
  </div>

  <div class="field">
    <label class="label" for="weight_lbs">Weight</label>
    <div class="control">
      <input id="weight_lbs" name="weight_lbs" type="text"
        value="{{ old('weight_lbs', $entry->weight_lbs ?? '') }}"
        class="input @error('weight_lbs') is-danger @enderror">
    </div>
    @error('weight_lbs')
        <p class="help is-danger">{{ $message }}</p>
    @enderror
  </div>

  <div class="field">
    <label class="label" for="chest_circ_in">Chest Circumference</label>
    <div class="control">
      <input id="chest_circ_in" name="chest_circ_in" type="text"
        value="{{ old('chest_circ_in', $entry->chest_circ_in ?? '') }}"
        class="input @error('chest_circ_in') is-danger @enderror">
    </div>
    @error('chest_circ_in')
        <p class="help is-danger">{{ $message }}</p>
    @enderror
  </div>

  <div class="field">
    <label class="label" for="waist_circ_in">Waist Circumference</label>
    <div class="control">
      <input id="waist_circ_in" name="waist_circ_in" type="text"
        value="{{ old('waist_circ_in', $entry->waist_circ_in ?? '') }}"
        class="input @error('waist_circ_in') is-danger @enderror">
    </div>
    @error('waist_circ_in')
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
    @if (isset($entry))
    <div class="control">
      <a href="#" id="open-modal" class="button is-danger is-light is-small">
        <span class="icon is-small">
          <i class="fas fa-trash"></i>
        </span>
        <span>Delete</span>
      </a>
    </div>

    <div class="modal" id="confirm-delete-modal">
      <div class="modal-background"></div>
      <div class="modal-content">
        <article class="message is-danger">
          <div class="message-header">
            <p>Warning!</p>
          </div>
          <div class="message-body">
            Are you sure you want to <strong>permanently delete</strong> this record?
            <p>&nbsp;</p>

            <div class="buttons">
              <form action="{{ route('entries.destroy', compact('entry')) }}" method="POST">
                  @method('DELETE')
                  @csrf
                  <button id="open-modal" class="button is-danger">
                    <span class="icon is-small">
                      <i class="fas fa-trash"></i>
                    </span>
                    <span>Yes, i am ready to delete</span>
                  </button>
              </form>

                <button class="button is-inverted modal-cancel">
                  <span class="icon is-small">
                    <i class="fas fa-times"></i>
                  </span>
                  <span>No, get me out of here!</span>
                </button>

            </div>
          </div>




        </article>
      </div>
    </div>

    @endif
  </div>

</form>
