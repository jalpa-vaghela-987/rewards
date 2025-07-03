<x-app-layout>

    <script src="https://cdn.rawgit.com/nnattawat/flip/master/dist/jquery.flip.min.js"></script>

    @if(!isset($reward) ?? false)
        @livewire('create-reward')
    @else
        @livewire('create-reward',['reward'=>$reward])
    @endif

    <script type="text/javascript">
        // $('.gift_card').flip({
        //     trigger: 'hover'
        // });
    </script>

</x-app-layout>
