<x-jet-form-section submit="generateApiKey">
    <x-slot name="title">
        {{ __('API Keys') }}
    </x-slot>
    <x-slot name="description">
        {{ __('API keys for use with our services') }}
    </x-slot>
    <x-slot name="form">
        <div class="col-span-4">
            <x-jet-input type="text" id="new_token_name" wire:model.defer="newTokenName"/>
            <x-jet-input-error for="new_token_name" class="mt-2"/>
        </div>

        <div class="col-span-4">
            <div class="mt-4 max-w-xl text-sm text-gray-600 bg-white">
                @foreach($this->state['tokens'] as $token)
                    <div class="p-2">
                        <div x-data="{open: false}">
                            <label for="{{$token['name']}}" class="font-semibold">
                                {{ __($token['name']) }}
                            </label>
                            @if($token['plainTextToken'] ?? false)
                                <input id="{{$token['name']}}" type="text" value="{{$token['plainTextToken']}}"
                                       readonly/>
                                <button
                                    x-on:click="(open = copyToClipboard('{{$token['name']}}')) && setTimeout(() => open = false, 3000)">
                                    Copy
                                </button>
                                <div x-show="open">
                                    Token copied!
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-slot>


    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="key-added">
            {{ __("Key generated. Be sure to copy it now because you will only see it once!") }}
        </x-jet-action-message>

        <x-jet-button>
            {{ _('Generate New Key') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>


<script>
    function copyToClipboard(id) {
        document.getElementById(id).select();
        document.execCommand('copy');

        return true
    }
</script>
