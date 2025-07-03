<x-app-layout>
    <div class="container mx-auto px-4 py-10 md:py-12">
        <div class="p-8 bg-white my-10 border border-gray-300 rounded rounded-t-lg ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
                Company Pages
            </h2>

            <div name="description">
                <div>
                    <table width="100%">
                        @foreach(\App\Models\Company::all() as $c)
                            <tr>
                                <th align="left">
                                    <div class="flex inline">
                                        {{ substr($c->name, 0, 20) }}

                                        @if($c->verified)
                                            <div title="verified">
                                                <svg class="m-1 h-4 w-4 text-green-400" fill="none"
                                                     stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                     stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                </th>

                                <td align="left">
                                    <a class="text-blue-500 underline mt-1 mx-2" href="/developer/company/{{$c->id}}">
                                        Users
                                    </a>
                                </td>
                                <td align="left">
                                    <a class="text-blue-500 underline mt-1 mx-2" href="/developer/billing/{{$c->id}}">
                                        Billing Dashboard
                                    </a>
                                </td>
                                <td align="left">
                                    <a class="text-blue-500 underline mt-1 mx-2" href="/developer/activity/{{$c->id}}">
                                        Activity Dashboard
                                    </a>
                                </td>

                                <td align="centre">
                                    <div>
                                        @if($c->verified)
                                            <x-jet-secondary-button class="mt-2" onclick="window.open('{{ route('developer.toggle-verified-company', ['company' => $c->id]) }}', '_self')">
                                                Mark Not Verified
                                            </x-jet-secondary-button>
                                        @else
                                            <x-secondary-link-button class="mt-2 " href="{{ route('developer.toggle-verified-company', ['company' => $c->id]) }}">
                                                Mark Verified
                                            </x-secondary-link-button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
