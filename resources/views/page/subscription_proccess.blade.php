<div id="snap-payment-container"></div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
</script>
<script type="text/javascript">
    console.log({{  }});
    snap.pay("{{ $snapToken }}", {
        onSuccess: function(result) {
            // Handler jika pembayaran berhasil
            window.location.href = "{{ route('login') }}";
        },
        onPending: function(result) {
            // Handler jika pembayaran tertunda
            window.location.href = "{{ route('login') }}";
        },
        onError: function(result) {
            // Handler jika terjadi kesalahan pada pembayaran
            window.location.href = "{{ route('login') }}";
        }
    });
</script>
