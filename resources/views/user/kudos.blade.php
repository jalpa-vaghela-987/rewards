<x-app-layout>
    <livewire:user-kudos :user="$user"/>

    <script type="text/javascript">
        window.onscroll = function (ev) {
            //console.log("scrolling");
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight-175) {
                window.livewire.emit('load-more');
                console.log("emitted")
            }
        };
    </script>

</x-app-layout>
