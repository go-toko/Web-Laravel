<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="col-md-8">
        <select wire:model.lazy="role_id" class="form-select">
            @foreach ($roles as $item)
                <option value="{{ $item->id }}" @if ($item->id == $role_id) selected @endif>{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
</div>