<div {{ $attributes->merge([
    'id' => "table-modal-loading",
    "class" => "fixed inset-0"
    ]) }}>
    <div class="absolute inset-0 flex items-center justify-center bg-black/5 backdrop-blur-sm">
        <div>
            <x-filament::loading-indicator @class([ "w-10 h-10 block mx-auto" ]) />
            <div>
                Mohon Tunggu...
            </div>
        </div>
    </div>
</div>