<div>
    {{-- Be like water. --}}
    <div class="form-check form-switch me-2">
        <input class="form-check-input" type="checkbox" id="check-form" wire:model.lazy="value"
            @if ($value) checked @endif>
    </div>
</div>
