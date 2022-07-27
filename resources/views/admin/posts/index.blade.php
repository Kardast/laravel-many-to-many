@extends('admin.layouts.base')

@section('mainContent')
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Id</th>
                <th>Slug</th>
                <th>title</th>
                <th>name</th>
                <th>birth</th>
                <th>category</th>
                <th>tags</th>


            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->slug }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->user->name }}</td>
                    <td>{{ $post->user->userDetails->birth }}</td>
                    <td>
                        <a href="{{ route('admin.categories.show', ['category' => $post->category]) }}">
                            {{ $post->category->name }}
                        </a>
                    </td>
                    <td>
                        @foreach($post->tags as $tag)
                            <a href="{{ route('admin.tags.show', ['tag' => $tag]) }}">{{ $tag->name }}</a>
                            @if(!$loop->last) , @endif
                        @endforeach
                    </td>
                    <td>{{ $post->tags->pluck('name')->join(',', 'and') }}</td>

                    <td>
                        <a href="{{ route('admin.posts.show', ['post' => $post]) }}" class="btn btn-primary">View</a>
                    </td>
                    @if(Auth::id() == $post->user_id)
                        <td>
                            <a href="{{ route('admin.posts.edit', ['post' => $post]) }}" class="btn btn-warning">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('admin.posts.destroy', ['post' => $post]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>

{{ $posts->links() }}

    {{-- AGGIUNGI IL DELETE CONFIRM --}}
@endsection
