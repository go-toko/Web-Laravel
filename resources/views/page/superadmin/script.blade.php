@section('forscript')
    <script>
        $(document).ready(function() {
            refreshOnlineUsers();
            refreshTotalUsers();
            getSubscriber();
            getSubscriberChart();
            getShopsCount();

            // memanggil setiap 10 menit (10000ms) refreshOnlineUsers();
            setInterval(function() {
                refreshOnlineUsers();
                refreshTotalUsers();
            }, 600000);
        });
    </script>
    <script>
        function refreshOnlineUsers() {
            $.ajax({
                url: "{{ route('superadmin.getUserOnlineCount') }}",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // update tampilan dengan data pengguna online
                    var users = response.userOnlineCount;
                    $('#online-users').empty();
                    $('#online-users').append(users);
                },
                error: function() {
                    // tangani error jika terjadi
                }
            });
        }

        function refreshTotalUsers() {
            $.ajax({
                url: "{{ route('superadmin.getUserCount') }}",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // update tampilan dengan data pengguna
                    var users = response.userCount;
                    $('#total-users').empty();
                    $('#total-users').append(users);
                },
                error: function() {
                    // tangani error jika terjadi
                }
            });
        }

        function getSubscriber() {
            $.ajax({
                url: "{{ route('superadmin.getSubscriberCount') }}",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // mendapatkan data subscriber
                    var subscriber = response.subscriberCount;
                    $('#subscription-users').empty();
                    $('#subscription-users').append(subscriber);
                }
            })
        }

        function getSubscriberChart() {
            // Mengambil data dari rute 'getSubscriberChart'
            fetch("{{ route('superadmin.getSubscriberChart') }}")
                .then(response => response.json())
                .then(data => {
                    const labels = data.labels;
                    const dataValues = data.data;

                    // Membuat grafik dengan Chart.js
                    const ctx = document.getElementById('SubscriptionChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah User Yang Berlangganan',
                                data: dataValues,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    precision: 0,
                                }
                            }
                        }
                    });
                });
        }

        function getShopsCount() {
            $.ajax({
                url: "{{ route('superadmin.getShopsCount') }}",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    // mendapatkan data Shop
                    var shops = response.shopsCount;
                    $('#total-shops').empty();
                    $('#total-shops').append(shops);
                }
            })
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
