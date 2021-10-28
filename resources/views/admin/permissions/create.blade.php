<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Add Role')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('roles.store')}}" method="post">
                        @csrf
                    {{--   Role Name  --}}
                        <div class="form-control">
                            <label for="name" class="label">
                                <span class="label-text">Name</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="Role Name"
                                   value="{{old('name')}}"
                                   id="name"
                                   name="name">
                        </div>
                        <div class="form-control">
                            <label for="permissions" class="label">
                                <span class="label-text">
                                    Role Permissions
                                </span>
                            </label>
                            <select name="permissions[]" id="permissions[]">
                                <option disabled value="0"></option>
                            </select>
                        </div>

                        <div class="py-6">
                            <button
                                class="btn btn-sm btn-primary text-gray-50"
                                type="submit">
                                Save Playlist
                            </button>
                            <a href="{{route('playlists.index')}}"
                               class="btn btn-sm btn-secondary text-gray-50">
                                Back To Playlists
                            </a>
                            <button class="btn btn-sm btn-accent" type="reset">Reset</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- TODO: Update permission/create.blade file -->
