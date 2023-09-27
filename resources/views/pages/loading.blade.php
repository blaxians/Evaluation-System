<div class="container">
    <div class="spinner"></div>
</div>

<style>
    .container {
        height: 100vh;
        width: 100%;
        display: grid;
        place-items: center;
    }

    .spinner {
        width: 56px;
        height: 56px;
        display: grid;
        animation: spinner-plncf9 4s infinite;
    }

    .spinner::before,
    .spinner::after {
        content: "";
        grid-area: 1/1;
        border: 9px solid;
        border-radius: 50%;
        border-color: #47ff75 #47ff50 #0000 #0000;
        mix-blend-mode: darken;
        animation: spinner-plncf9 1s infinite linear;
    }

    .spinner::after {
        border-color: #0000 #0000 #dbdcef #dbdcef;
        animation-direction: reverse;
    }

    @keyframes spinner-plncf9 {
        100% {
            transform: rotate(1turn);
        }
    }
</style>
<script>
    setTimeout(function() {
        window.location.href = "{{ route('redirect') }}";
    }, 5000);
</script>
