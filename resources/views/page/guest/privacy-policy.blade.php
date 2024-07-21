@extends('layout.mainlayout')

@section('title', 'Kebijakan Privasi')

@section('forhead')\
    <style>
        .page-wrapper {
            margin: 0 !important;
            padding: 0 !important;
        }

        .privacy-policy ul {
            list-style-type: disc;
            margin-left: 25px;
        }

        .privacy-policy li {
            margin-bottom: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="page-wrapper pagehead">
        <div class="content">
            <div class="row privacy-policy">
                <h4>Kebijakan Privasi</h4>
                <p>Selamat datang di Gotoko.ID. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan,
                    dan melindungi informasi pribadi Anda saat Anda menggunakan aplikasi Gotoko.ID. Kami berkomitmen untuk
                    menjaga privasi dan keamanan informasi pribadi Anda.</p>

                <h5>Informasi yang Kami Kumpulkan</h5>
                <ul>
                    <li><strong>Informasi Akun:</strong> Saat Anda membuat akun di Gotoko.ID, kami mengumpulkan informasi
                        seperti nama, alamat email, dan nomor telepon.</li>
                    <li><strong>Informasi Toko dan Kasir:</strong> Untuk pengelolaan multi toko dan multi kasir, kami
                        mengumpulkan informasi tentang toko-toko Anda dan data kasir.</li>
                    <li><strong>Informasi Produk:</strong> Data produk yang Anda kelola dalam aplikasi juga kami simpan.
                    </li>
                    <li><strong>Informasi Pembayaran:</strong> Untuk transaksi menggunakan QRIS, kami mengumpulkan informasi
                        yang diperlukan untuk memproses pembayaran.</li>
                    <li><strong>Informasi Lokasi:</strong> Kami mengumpulkan informasi lokasi pengguna untuk membantu dalam
                        pengawasan dan manajemen operasional toko Anda.</li>
                </ul>

                <h5>Penggunaan Informasi</h5>
                <p>Informasi yang kami kumpulkan digunakan untuk:</p>
                <ul>
                    <li>Mengelola dan mengoperasikan aplikasi Gotoko.ID.</li>
                    <li>Memberikan layanan yang Anda minta.</li>
                    <li>Meningkatkan kualitas layanan kami.</li>
                    <li>Memproses pembayaran melalui QRIS.</li>
                    <li>Memberikan dukungan pelanggan.</li>
                    <li>Memantau lokasi pengguna untuk keamanan dan efisiensi operasional.</li>
                </ul>

                <h5>Perlindungan Informasi</h5>
                <p>Kami mengambil langkah-langkah keamanan yang sesuai untuk melindungi informasi pribadi Anda dari akses,
                    penggunaan, atau pengungkapan yang tidak sah. Semua data rahasia, seperti password, dienkripsi
                    menggunakan bcrypt, dan manajemen infrastruktur yang aman.</p>

                <h5>Berbagi Informasi</h5>
                <p>Kami berjanji tidak akan membagikan informasi pengguna dalam bentuk apapun tanpa persetujuan pengguna,
                    kecuali jika diharuskan oleh hukum atau untuk melindungi hak-hak kami.</p>

                <h5>Hak Pengguna</h5>
                <p>Anda memiliki hak untuk:</p>
                <ul>
                    <li>Mengakses informasi pribadi Anda yang kami simpan.</li>
                    <li>Meminta perbaikan atau penghapusan informasi pribadi Anda.</li>
                    <li>Menolak atau membatasi pemrosesan informasi pribadi Anda.</li>
                </ul>

                <h5>Penghapusan Akun</h5>
                <p>Jika Anda ingin menghapus akun Anda di Gotoko.ID, Anda dapat menghubungi tim dukungan pelanggan kami
                    melalui email admin@gotoko.id atau telepon +6281232254875. Kami akan memproses permintaan Anda secepat
                    mungkin dan memastikan bahwa semua informasi pribadi Anda dihapus dari sistem kami.</p>

                <h5>Perubahan Kebijakan Privasi</h5>
                <p>Kami dapat memperbarui Kebijakan Privasi ini dari waktu ke waktu. Perubahan akan diinformasikan melalui
                    aplikasi atau melalui email. Kami mendorong Anda untuk meninjau Kebijakan Privasi ini secara berkala.
                </p>

                <h5>Kontak Kami</h5>
                <p>Jika Anda memiliki pertanyaan atau kekhawatiran tentang Kebijakan Privasi ini, silakan hubungi kami di:
                </p>
                <ul>
                    <li><strong>Email:</strong> admin@gotoko.id</li>
                    <li><strong>Telepon:</strong> +6281232254875</li>
                </ul>

                <p>Terima kasih telah menggunakan Gotoko.ID. Kami menghargai kepercayaan Anda dalam menjaga privasi dan
                    keamanan informasi pribadi Anda.</p>
            </div>
        </div>
    </div>
@endsection

@section('forscript')
    {{-- Toast Script --}}
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ URL::asset('/assets/plugins/toastr/toastr.js') }}"></script>
@endsection
