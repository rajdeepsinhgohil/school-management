<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(count($unreadAnnouncements) > 0)
                        @foreach($unreadAnnouncements as $unreadAnnouncement)
                            <div class="flex justify-between items-center bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-2" role="alert">
                                <div>
                                    <p class="text-sm">{{ $unreadAnnouncement->title }}</p>
                                    <p class="text-sm">{{ $unreadAnnouncement->content }}</p>
                                </div>
                                <a href="{{route('mark-read', [$unreadAnnouncement->id])}}">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center">No announcement found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
