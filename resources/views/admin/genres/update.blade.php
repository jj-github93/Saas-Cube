<x-app-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Edit Genre')}}
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
                            <form action="{{route('genres.update', ['genre'=>$genre->id])}}" method="post">
                                @csrf
                                @method('patch')
                                <div class="form-control">
                                    <label for="name" class="label">
                                        <span class="label-text">Name</span>
                                    </label>
                                    <input type="text"
                                           class="input input-bordered"
                                           placeholder="name"
                                           value="{{old('name') ?? $genre->name}}"
                                           id="name"
                                           name="name">
                                </div>
                                <div class="form-control">
                                    <label for="icon" class="label">
                                        <span class="label-text">Icon</span>
                                    </label>
                                    <input type="text"
                                           class="input input-bordered"
                                           placeholder="icon"
                                           value="{{old('icon') ?? $genre->icon}}"
                                           id="icon"
                                           name="icon">
                                </div>
                                <div class="form-control">
                                    <label for="parent_id" class="label">
                                        <span class="label-text">Parent ID</span>
                                    </label>
                                    <select name="parent_id" id="parent_id"
                                            class="select select-bordered w-full max-w-xs">
                                        <option value="{{null}}">No Parent</option>
                                        @foreach($all_genres as $key=>$value)
                                            @if(!($value->parent_id == $genre->id))
                                                <option
                                                    {{$value->id == $genre->parent_id ? "selected" : ''}}
                                                    value="{{$value->id}}">{{$value->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="py-6">
                                    <button
                                        class="btn btn-sm btn-primary text-gray-50"
                                        type="submit">
                                        Update Genre
                                    </button>
                                    <a href="{{route('genres.index')}}"
                                       class="btn btn-sm btn-secondary text-gray-50">
                                        Back To Genres
                                    </a>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
        </div>
</x-app-layout>
