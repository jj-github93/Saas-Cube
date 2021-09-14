<x-guest-layout>
    <x-slot name="header">
        <h2 class="fonts-semibold text-xl text-gray-800 leading-tight">
            {{__('Genres')}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="overflow-x-auto">
                        <table class="table w-full table-zebra">
                            <thead>
                            <tr>
                                <th></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Parent ID</th>
                                <th>Icon</th>
                                <th class="flex justify-between">
                                    <span class="pt-2">Action

                                    </span>
                                    <a
                                        href="{{route('genres.create')}}"
                                        class="btn btn-sm btn-tertiary tet-gray-50">
                                        Add Genre
                                    </a>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($genres as $key=>$genre)
                                <tr class="hover">
                                    <td class="small">{{$key+1}}</td>
                                    <td>{{$genre->id}}</td>
                                    <td>{{$genre->name}}</td>
                                    <td> {{$genre->parent_id}} </td>
                                    <td>{{$genre->icon}}</td>
                                    <td>
                                        <a href="{{url('/admin/genres/' . $genre->id)}}" class="btn btn-sm btn-primary text-gray-50">Details</a>
                                        <a href="{{url('/admin/genres/' . $genre->id . '/edit')}}" class="btn btn-sm btn-secondary text-gray-50">Update</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="6">
                                    {{$genres->onEachSide(1)->links()}}
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-guest-layout>
