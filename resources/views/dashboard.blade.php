<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden">
                <div class="text-center">
                    @foreach(auth()->user()->image_hashes()->orderBy('created_at')->limit(100)->get() as $image_hash)
                        <div class="bg-white p-4 m-4 rounded-md shadow-md">
                            <div
                                class="grid grid-cols-2 place-content-center">
                                <div>
                                    <div class="p-4">
                                        <div class="flex flex-col items-start">
                                            <div>
                                                UUID:
                                                <span class="text-gray-400">
                                                    {{$image_hash->urlHash}}
                                                </span>
                                            </div>
                                            <div>
                                                Created:
                                                <span class="text-gray-400">
                                                    {{$image_hash->created_at->toDateTimeString()}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex place-content-center h-full">
                                        <div id="{{$image_hash->urlHash}}" class="blurhash"></div>
                                    </div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function () {
                                            window.decodeBlurHash('{{$image_hash->urlHash}}', '{{$image_hash->imageHash}}')
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


