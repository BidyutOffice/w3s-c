@if (session('success'))
    <div id="flash-msg" class="flash-message text-sm text-green-500 my-1 capitalize">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div id="flash-msg" class="flash-message text-sm text-red-500 my-1 capitalize">
        {{ session('error') }}
    </div>
@endif

<style>
    .flash-message {
        opacity: 1;
        transition: opacity 1s ease-out;
    }
</style>

<script>
    setTimeout(() => {
        const msg = document.getElementById('flash-msg');
        if (msg) {
            msg.style.opacity = '0';
            setTimeout(() => {
                msg.style.display = 'none';
            }, 1000);
        }
    }, 6000);
</script>
