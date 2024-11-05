<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Teacher') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">
                    <div class="text-end mb-2">
                        <a href="{{route('teacher.add')}}" class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'>
                            Add Teacher
                        </a>
                    </div>

                    @if (count($teachers) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($teachers as $teacher)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{$teacher->name}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$teacher->email}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{$teacher->mobile}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{route('teacher.edit',['id' => $teacher->id])}}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <a href="{{route('teacher.delete',['id' => $teacher->id])}}" class="text-red-600 hover:text-red-900">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div>
                            {{ $teachers->links() }}
                        </div>
                    @else
                        <p class="text-center">No record found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
