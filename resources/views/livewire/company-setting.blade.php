    <div class="container mx-auto px-4 py-10 md:py-12">
        <div class="flex justify-between w-full mb-5">
            <x-jet-input class="w-1/4 text-sm" type="text" wire:model="search" placeholder="Search Company ..."
                         autofocus/>
        </div>

        <div class="p-8 bg-white my-10 border border-gray-300 rounded rounded-t-lg ">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-2">
                All Companies
            </h2>

            <div name="description">
                <div>
                    <table width="100%">
                        @foreach($company as $c)
                            <tr>
                                <th align="left">
                                    <div class="flex inline">
                                       <a href="{{route('edit.company',['company'=>$c->id])}}">{{ substr($c->name, 0, 20) }}</a>

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
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


