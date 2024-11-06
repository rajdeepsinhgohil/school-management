<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Teacher') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="container mx-auto">
                    <form method="post" action="{{ route('student.save') }}" class="mt-6 space-y-6">
                        @csrf
                        @if($user->role == \App\Models\User::ROLE_ADMIN)
                            <div>
                                <label>
                                    <select name="teacher" class="'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm'">
                                        <option value="">Select a Teacher</option>
                                        @foreach($teachers as $teacher)
                                            <option {{old('teacher') == $teacher->id ? 'selected' : ''}} value="{{$teacher->id}}">{{$teacher->name}}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <x-input-error class="mt-2" :messages="$errors->get('teacher')" />
                            </div>
                        @endif
                        <div>
                            <label>
                                <select name="parent" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select a Parent</option>
                                    @foreach($parents as $parent)
                                        <option {{old('parent') == $parent->id ? 'selected' : ''}} value="{{$parent->id}}">{{$parent->name}}</option>
                                    @endforeach
                                </select>
                            </label>
                            <x-input-error class="mt-2" :messages="$errors->get('parent')" />
                        </div>
                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" autocomplete="email" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>
                        <div>
                            <label>
                                <select name="standard" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="">Select a Standard</option>
                                    @foreach(range(1, 12) as $item)
                                        <option {{old('standard') == $item ? 'selected' : ''}} value="{{$item}}">{{$item}}</option>
                                    @endforeach
                                </select>
                            </label>
                            <x-input-error class="mt-2" :messages="$errors->get('standard')" />
                        </div>
                        <div class="text-end">
                            <a href="{{route('student.list')}}" class='inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150'>
                                Back
                            </a>
                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
