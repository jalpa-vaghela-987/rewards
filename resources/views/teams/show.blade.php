<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-10 md:py-12">
        <div>
            <div class="container mx-auto px-4 py-10 md:py-12">
                @livewire('teams.update-team-name-form', ['team' => $team])
            </div>

            <div class="container mx-auto px-4 lg:py-8 md:py-12">
                @livewire('team-member-manager', ['team' => $team]) <!-- Just the add user form i changed -->
            </div>

{{--            <div class="container mx-auto px-4 py-10 md:py-12">--}}
{{--                @livewire('teams.team-member-manager', ['team' => $team])--}}
{{--            </div>--}}

            @if(auth()->user()->ownsTeam($team) || auth()->user()->hasTeamRole($team, 'admin'))
                @if (Gate::check('delete', $team) && !$team->personal_team)
                    <x-jet-section-border/>
                    <div class="container mx-auto px-4 py-10 md:py-12">
                        <div class="mt-10 sm:mt-0">
                            @livewire('delete-team-form', ['team' => $team])
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-app-layout>
