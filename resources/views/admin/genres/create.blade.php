<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Add Genre')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                                     role="alert">
                                    <strong>{{$error}}</strong>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{route('genres.store')}}" method="post">
                        @csrf
                        <div class="form-control">
                            <label for="name" class="label">
                                <span class="label-text">Name</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="Genre Name"
                                   value="{{old('name')}}"
                                   id="name"
                                   name="name">
                        </div>
                        <div class="form-control">
                            <label for="parent_id" class="label">
                                <span class="label-text">Parent ID</span>
                            </label>
                            <select name="parent_id" id="parent_id"
                                    class="select select-bordered w-full max-w-xs">
                                <option value="{{null}}">No Parent</option>
                                @foreach($genres as $key=>$genre)
                                    <option value="{{$genre->id}}">{{$genre->id . " " . $genre->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-control">
                            <label for="icon" class="label">
                                <span class="label-text">Icon File</span>
                            </label>
                            <input type="text"
                                   class="input input-bordered"
                                   placeholder="Icon File"
                                   id="icon"
                                   name="icon">
                        </div>
                        <div class="py-6">
                            <button
                                class="btn btn-sm btn-primary text-gray-50"
                                type="submit">
                                Save New Genre
                            </button>
                            <a href="{{route('genres.index')}}"
                               class="btn btn-sm btn-secondary text-gray-50">
                                Back To Genres
                            </a>
                            <button class="btn btn-sm btn-accent" type="reset">Reset</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
