<div class="flex flex-col">
    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="w-full mb-5">
                <x-jet-input class="w-1/4" type="text" wire:model="search" placeholder="Search User ..." autofocus/>
                <a href="/export-user-stats" class="w-full ">
                    <span class="text-lg float-right pt-5 mr-3">
                        <i class="fas fa-upload text-xl cursor-pointer  text-gray-700 "></i>
                         Export
                    </span>
                </a>
            </div>

            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" width="5%" wire:click="sort('name')"
                                class="cursor-pointer px-6 py-3 max-w-[3.23rem] px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase font-bold tracking-wider">
                                Name
                                <span>
                                    @if($sortColumn === 'name')
                                        <i class="fa {{$sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down'}}"></i>
                                    @else
                                        <i class="fas fa-sort"></i>
                                    @endif
                                </span>
                            </th>
                            <th scope="col" wire:click="sort('points')"
                                class="cursor-pointer px-6 py-3 max-w-[3.23rem] px-6 py-3 text-left text-xs font-medium te xt-gray-500 uppercase font-bold tracking-wider">
                                Available {{ getReplacedWordOfKudos() }} to Spend
                                <span>
                                    @if($sortColumn === 'points')
                                        <i class="fa {{$sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down'}}"></i>
                                    @else
                                        <i class="fas fa-sort"></i>
                                    @endif
                                </span>
                            </th>
                            <th scope="col" wire:click="sort('points_to_give')"
                                class="cursor-pointer px-6 py-3 max-w-[3.23rem] px-6 py-3 text-left text-xs font-medium te xt-gray-500 uppercase font-bold tracking-wider">
                                Available {{ getReplacedWordOfKudos() }} to Give
                                <span>
                                    @if($sortColumn === 'points_to_give')
                                        <i class="fa {{$sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down'}}"></i>
                                    @else
                                        <i class="fas fa-sort"></i>
                                    @endif
                                </span>
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase font-bold tracking-wider">
                                Last {{ getReplacedWordOfKudos() }} Sent At
                            </th>
                            <th scope="col" wire:click="sort('last_login')"
                                class="cursor-pointer px-6 py-3 max-w-[3.23rem] px-6 py-3 text-left text-xs font-medium te xt-gray-500 uppercase font-bold tracking-wider">
                                Last Login At
                                <span>
                                    @if($sortColumn === 'last_login')
                                        <i class="fa {{$sortDirection === 'asc' ? 'fa-chevron-up' : 'fa-chevron-down'}}"></i>
                                    @else
                                        <i class="fas fa-sort"></i>
                                    @endif
                                </span>
                            </th>
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
                                <div class="text-sm text-gray-900">{{ number_format($user->points) }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ number_format($user->points_to_give) }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->formatted_recent_kudos_sent_at }}</div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->formatted_last_login_at }}</div>
                            </td>
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
