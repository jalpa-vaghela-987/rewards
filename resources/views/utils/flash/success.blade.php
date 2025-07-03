@if (session()->has('success'))
    <div class="flash-success">
        <div style="display: flex; align-items: center; justify-content: space-between">
            <div style="flex-grow: 1; color: green">
                {{ session('success') }}
            </div>
        </div>
    </div>
@endif
