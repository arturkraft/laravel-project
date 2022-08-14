@if(session()->has('successful-message'))
    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 5000)" x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-laravel text-white px-48 py3">
        <p>
            {{session('successful-message')}}
        </p>
    </div>
@endif