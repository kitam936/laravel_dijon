<x-app-layout>
    <x-slot name="header">
        <div class="flex">
        <h2 class="flex font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            ユーザー一覧
        </h2>
        <div class="ml-80 mb-2">
            <button onclick="location.href='{{ route('admin.users.create') }}'" class="text-white text-ml  bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded ">新規登録</button>
        </div>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-2/3 md:p-6 text-gray-900 dark:text-gray-100">

                    <section class="text-gray-600 body-font">
                        <div class="container md:px-5 py-4 mx-auto">
                            <x-flash-message status="session('status')" />

                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                            <table class="table-auto w-full text-left whitespace-no-wrap">
                              <thead>
                                <tr>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">Name</th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">Email</th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">登録日</th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                                  <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($users as $user )
                                <tr>
                                  <td class="md:px-4 py-3"> {{ $user->name}}</td>
                                  <td class="md:px-4 py-3">{{ $user->email}}</td>
                                  <td class="md:px-4 py-3">{{ $user->created_at->diffForHumans() }}</td>
                                  <td class="pmd:x-4 py-3">
                                  <button onclick="location.href='{{ route('admin.users.edit',['user'=>$user->id]) }}'" class="text-white bg-indigo-400 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-600 rounded">編集</button>
                                  </td>
                                  <form id="delete_{{ $user->id }}" method="post" action="{{ route('admin.users.destroy',['user'=>$user->id]) }}">
                                    @csrf
                                    @method('delete')
                                    <td class="md:px-4 py-3">
                                     <a href="#" data-id="{{ $user->id }}" onclick="deletePost(this)" class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none hover:bg-red-600 rounded">削除</a>
                                   </td>
                                  </form>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                            {{ $users->links() }}
                          </div>

                        </div>
                      </section>


                </div>
            </div>
        </div>
    </div>
    <script>
        function deletePost(e) {
        'use strict';
        if (confirm('本当に削除してもいいですか?')) {
        document.getElementById('delete_' + e.dataset.id).submit();
        }
        }
    </script>

</x-app-layout>
