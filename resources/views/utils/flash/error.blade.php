@if ($errors->has($key))
    <div class="flash-success">
        <div style="display: flex; align-items: center; justify-content: space-between">
            <div style="flex-grow: 1; color: red">
                {{ $errors->first($key) }}
            </div>
        </div>
    </div>
@endif
