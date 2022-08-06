<label class="m-checkbox-label d-line">
    <input type="checkbox" class="m-checkbox"
           id="m-checkbox-{{ $id !== null ? $id : 'all' }}"
           @if (!is_null($id)) name="id[]" @endif
           @if (!is_null($id)) value="{{ $id }}" @endif
    >
    <span class="m-checkmark"></span>
</label>
