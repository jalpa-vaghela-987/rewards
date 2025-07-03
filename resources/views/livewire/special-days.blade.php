<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="w-full mb-5 flex">
                <x-jet-input class="w-1/4" type="text" wire:model="search" placeholder="Search User ..." />

{{--                <div class="flex">--}}
{{--                    <select class="ml-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm flex-wrap @if($special_day == '') text-gray-500 @endif" wire:model="special_day">--}}
{{--                        <option value="">Select Special Day</option>--}}
{{--                        <option value="birthday">Birthday</option>--}}
{{--                        <option value="anniversary">Anniversary</option>--}}
{{--                    </select>--}}
{{--                    <x-jet-input type="date" />--}}
{{--                </div>--}}
            </div>

            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" wire:click="sortBy('name')" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                            @if($sortField === 'name')
                                <span><i class="fa {{ $sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down' }}"></i></span>
                            @endif
                        </th>
                        <th scope="col" wire:click="sortBy('birthday')" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Birthday
                            @if($sortField === 'birthday')
                                <span><i class="fa {{ $sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down' }}"></i></span>
                            @endif
                        </th>
                        <th scope="col" wire:click="sortBy('anniversary')" class="cursor-pointer px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Anniversary
                            @if($sortField === 'anniversary')
                                <span><i class="fa {{ $sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down' }}"></i></span>
                            @endif
                        </th>
{{--                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                        </th>--}}
{{--                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">--}}
{{--                        </th>--}}
                    </tr>
                    </thead>

                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr :key="$user.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full" src="{{ $user->profile_photo_url }}" alt="" />
                                    </div>
                                    <div class="ml-4" wire:loading.class.delay="opacity-40">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $user->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            {{ $user->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ data_get($user, 'birthday', 'N/A' ) }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ data_get($user, 'anniversary', 'N/A' ) }}</div>
                            </td>

{{--                            <td class="px-6 py-4 whitespace-nowrap">--}}
{{--                            </td>--}}

{{--                            <td class="px-6 py-4 whitespace-nowrap">--}}
{{--                            </td>--}}
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap" colspan="100%">
                                <div class="flex items-center justify-center text-gray-600 h-8">
                                    <span class="mr-5"><i class="fa fa-envelope"></i></span> No Users Found ...
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="p-5">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
