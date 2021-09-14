<x-guest-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Genre Details')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Show
                    <dl class="grid grid-cols-6 gaps-2">
                        <dt class="col-span-1">ID</dt>
                        <dd class="col-span-5">{{$genre->id}}</dd>
                        <dt class="col-span-1">Name</dt>
                        <dd class="col-span-5">{{$genre->name}}</dd>
                        <dt class="col-span-1">Parent ID</dt>
                        <dd class="col-span-5">{{$genre->parent_id}}</dd>
                        <dt class="col-span-1">Added</dt>
                        <dd class="col-span-5">{{$genre->created_at}}</dd>
                        <dt class="col-span-1">Actions</dt>
                        <dd class="col-span-5">

                            <form
                                action="{{route('genres.destroy',['genre'=>$genre])}}"
                                method="post">
                                @csrf
                                @method('delete')
                                <a href="{{route('genres.edit',['genre'=>$genre->id])}}"
                                   class="btn btn-sm btn-primary text-gray-50">Update</a>
                                <button class="btn btn-sm btn-secondary text-gray-50">
                                    Delete
                                </button>
                            </form>

                        </dd>
                    </dl>
                    <p class="pt-6">
                        <a href="{{url('/admin/genres')}}" class="btn btn-sm btn-accent">
                            Back To Genres
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
