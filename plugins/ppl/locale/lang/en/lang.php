<?php

use Ppl\Hrga\Models\Dashboard;

return [
    'plugin' => [
        'name' => 'Locale',
        'description' => 'Ppl Localization Plugin',
        'hrga' => [
            'name' => 'Hrga',
             'description' => 'Ppl: Aplikasi Permintaan Design',
        ],
    ],
    'permissions' => [
        'some_permission' => 'Some permission',
        'home' => [
            'title' => 'Home',
        ],
        'halamanpeminjaman' => [
            'title' => 'Halaman Peminjaman',
        ],
        'listruangrapat' => [
            'title' => 'List Ruang Rapat',
        ],
        'divisi' => [
            'title' => 'Divisi',
        ],
        'laporan' => [
            'title' => 'Laporan',
        ],
        'peminjamanruangan' => [
            'title' => 'Peminjaman Ruangan',
        ],
        'ruangrapat' => [
            'title' => 'Ruang Rapat',
        ]
    ],
    'text' => [
        'company_name' => 'PT Penjaminan Jamkrindo Syariah',
        'company_alias' => 'Ppl',
        'corporate_tagline' => 'Menjadi Perusahaan Penjaminan Syariah Terpercaya dan Terdepan dalam Pertumbuhan Bisnis di Indonesia',
        'cb_tos_agreement' => 'Saya setuju dengan Ketentuan Penggunaan',
        'url_forgot_password' => 'Lupa Sandi?',
        'url_user_manual' => 'User Manual',
        'btn_login' => 'Masuk',
        'welcome' => 'Hai, Selamat Datang',
        'greeting_login' => 'Silahkan login menggunakan data akun anda',
        'username' => 'Username',
        'password' => 'kata sandi',

        'agreement_title1' => 'PT PENJAMINAN JAMKRINDO SYARIAH',
        'agreement_title2' => 'DIVISI TEKNOLOGI INFORMASI',
        'agreement_title3' => 'DISCLAIMER',

        'agreement1' => '1. Web Aplikasi Merapat adalah aplikasi internal perusahaan
        yang semata-mata diadakan untuk kepentingan perusahaan, dan
        karenanya harus dipergunakan sebaik-baiknya sesuai petunjuk dan
        aturan yang berlaku.',

        'agreement2' => '2. Pemakai/penanggungjawab tidak dibenarkan memberikan username
        password akun kepada orang lain untuk kepentingan pribadi.',

        'agreement3' => '3. Untuk informasi lebih lanjut, bantuan (support), keluhan yang
        berkaitan dengan kurang optimalnya aplikasi, harap menghubungi
        Fungsi TI dengan PIC : Nabiilah Mufiidah, email : it@Ppl.id. ',

        'agreement4' => '4. Dengan telah membaca ketentuan ini, pengguna memahami isi
        petunjuk/ketentuan dan menerima resiko yang dibebankan sebagai
        akibat dari kesalahan yang diakibatkannya.',
    ],
    'agreement' => [
        'btn_agree' => 'Nanti',
        'btn_disagree' => 'Setuju & lanjutkan',
        'agreement_title1' => 'PT PENJAMINAN JAMKRINDO SYARIAH',
        'agreement_title2' => 'DIVISI TEKNOLOGI INFORMASI',
        'agreement_title3' => 'DISCLAIMER',

        'agreement1' => '1. Web Aplikasi Potongan Link adalah aplikasi internal perusahaan
        yang semata-mata diadakan untuk kepentingan perusahaan, dan
        karenanya harus dipergunakan sebaik-baiknya sesuai petunjuk dan
        aturan yang berlaku.',

        'agreement2' => '2. Pemakai/penanggungjawab tidak dibenarkan memberikan username
        password akun kepada orang lain untuk kepentingan pribadi, serta
        tidak diperkenankan menggunakan link untuk kepentingan pribadi
        diluar perusahaan (termasuk kegiatan ilegal).',

        'agreement3' => '3. Pemakai harus melindungi dan menjaga penditribusian link ke pihak
        pihak yang memang dianggap sebagai pihak yang membutuhkan link yang
        dimaksud. Segala potensi yang timbul akibat salahnya pendistribusian
        link akan dipertanggung jawabkan penuh oleh si pemilik akun. ',

        'agreement4' => '4. Untuk informasi lebih lanjut, bantuan (support), keluhan yang
        berkaitan dengan kurang optimalnya aplikasi, harap menghubungi
        Fungsi TI dengan PIC : Putri Amelia, email : it@Ppl.id. ',

        'agreement5' => '5. Dengan telah membaca ketentuan ini, pengguna memahami isi
        petunjuk/ketentuan dan menerima resiko yang dibebankan sebagai
        akibat dari kesalahan yang diakibatkannya.',
    ],
    'nav' => [
        'manage-users' => [
            'label' => 'Adm. Pengguna',
            'users' => [
                'label' => 'Pengguna',
                'desc' => 'Kelola Pengguna',
            ],
            'groups' =>[
                'label' => 'Grup',
                'label_plural' => 'Groups',
                'desc' => 'Kelola Grup',
                'groups_comment' => 'Tentukan grup yang dimiliki pengguna ini'
            ],
            'permission' =>[
                'label' => 'Izin',
                'desc' => 'Kelola Izin',
            ],
            'group' => 'Adm. Pengguna'
        ],
    ],

    'lists' => [
        'doctype' => [
            'memo' => 'Memo',
            'usulan' => 'Usulan'
        ],
        'flaqstatus' => [
            '1' => 'Dipesan',
            '2' => 'selesai',
            '3' => 'Sedang Dipakai',
            '4' => 'Selesai dengan catatan',
            '5' => 'Batal',
        ]
    ],

    'form' =>[
        'approve'=>[
            'label' => 'Approve',
        ],
        
    ],

    'button' =>[
        'edit_button' => 'Sunting',
        'check_button' => 'Check In',
        'batal_button' => 'Batal',
        'checkout_button' => 'Check Out',
        'daftar_hadir' => 'Daftar Hadir',
        'perpanjang_button' => 'Perpanjang',
        'buat'=> 'Buat'
    ],

    'models' => [
        'general' => [
            'account'=>'Akun',
            'groups' => 'Grup',
            'groups_comment' => 'Tentukan grup yang dimiliki pengguna ini.',
            'permissions' => 'Izin', 
            'id' => 'Nomor',
            'npk' => 'NPK',
            'first_name' => 'Nama Depan',
            'last_name' => 'Nama Belakang',
            'job' => 'Job',
            'unit' => 'Unit',
            'created_at' => 'Dibuat pada',
            'updated_at' => 'Diperbarui pada',
            'send_invite' => 'Kirim Undangan ke email',
            'send_invite_comment' => 'Kirim pesan selamat datang yang berisi informasi username/login dan kata sandi.',
            'reset_password' => 'Atur Ulang Kata Sandi',
            // 'superuser_comment' => 'Grants this account unlimited access to all areas of the system. Super users can add and manage other users. '
            'btn_login' => 'Masuk',

            'welcome' => 'Hai, Selamat Datang',

            'greeting_login' => 'Silahkan login menggunakan data akun anda',

            'username' => 'username',

            'password' => 'kata login',
            
        ],
        'home' =>[
            'label' => 'Sumber Daya Manusia',
            'label_plural' => 'Home',
            'homes' => [
                'label' => 'Jadwal Ruangan',
                'label_plural' => 'Home',
                'desc' => ''
            ],
            'peminjamanruang'=>[
                'label' => 'Peminjaman Ruangan',
                'label_plural' => 'Peminjaman Ruang',
                // 'btn-pinjamruang' => 'Pinjam Ruang Rapat',
                // 'form_peminjaman' => 'Form Peminjaman Ruang Rapat',
                'desc' => '',
                'field'=>[
                    'status' => 'Status',
                    'action' => 'Aksi',
                    'created_at'=> 'Created At'
                ],
                'form'=>[
                    'nama'=>'Nama',
                    'no_wa'=>'Nomor WhatsApp',
                    'unit_kerja'=>'Unit Kerja',
                    'nama_ruangan'=>'Nama Ruang Rapat',
                    'tanggal_awal'=>'Tanggal dan Waktu Peminjaman Awal',
                    'tanggal_akhir'=>'Tanggal dan Waktu Peminjaman Akhir',
                    'jumlah_peserta'=>'Jumlah Peserta Rapat',
                    'agenda_rapat'=>'Agenda Rapat',
                    'upload_undangan'=>'Upload Dokumen Memo',
                    'jenis_rapat'=>'Jenis Rapat',
                    'nama_peserta'=>'Nama Peserta Rapat',
                    'nama_mitra' => 'Nama Peserta Mitra',
                    'upload_kehadiran' => 'Upload Daftar Kehadiran',
                    'upload_link_kehadiran' => 'Upload Link Kehadiran',
                    'daftar_kehadiran' => 'Daftar Kehadiran',
                    'link_kehadiran' => 'Link Kehadiran'
                ],
                
            ],
            'meetingroom'=>[
                'label' => 'Ruang Rapat',
                'label_plural' => 'Ruang Rapat',
                'desc'=> ''
            ],

            'group' => 'Peminjaman Ruangan Saya'
        ],
        'dashboard'=>[
            'label' => 'Merapat',
            'label_plural' => 'Merapat',
            'dashboards'=>[
                'label' => 'Beranda',
                'label_plural' => 'Beranda',
                'desc'=>'',
            ],
            'halamanpeminjaman' => [
                'label' => 'Peminjaman User',
                'label_plural' => 'Peminjaman User',
                'desc'=>'',
                'field'=>[
                    'status' => 'Status',
                    'action' => 'Aksi',
                    'created_at'=> 'Created At'
                ],
                'form'=>[
                    'nama'=>'Nama',
                    'no_wa'=>'Nomor WhatsApp',
                    'unit_kerja'=>'Unit Kerja',
                    'nama_ruangan'=>'Nama Ruang Rapat',
                    'tanggal_awal'=>'Tanggal dan Waktu Peminjaman Awal',
                    'tanggal_akhir'=>'Tanggal dan Waktu Peminjaman Akhir',
                    'jumlah_peserta'=>'Jumlah Peserta Rapat',
                    'agenda_rapat'=>'Agenda Rapat',
                    'upload_undangan'=>'Upload Dokumen Memo',
                    'jenis_rapat'=>'Jenis Rapat',
                    'nama_peserta'=>'Nama Peserta Rapat',
                    'nama_mitra' => 'Nama Peserta Mitra',
                ],
                'btn'=>[
                    'lihat_form'=> 'Lihat Form',
                    'batal' => 'Batal',
                ]
            ],
            'listruangrapat' => [
                'label' => 'List Ruang Rapat',
                'label_plural' => 'Ruang Rapat',
                'update'=> 'Form Ruang Rapat',
                'ruang_rapat' => 'Ruang Rapat',
                'nama' => "Nama Ruangan",
                'kapasitas' => "Kapasitas",
                'fasilitas' => "Fasilitas",
                'aksi' => "Aksi",
                'foto_ruang' => 'Foto Ruang Rapat',
                'btn_tmbh' =>"Tambah Ruang Rapat",
                'desc'=>'',
            ],
            'divisi' =>[
                'label' => 'List Divisi',
                'label_plural' => 'List Divisi',
                'update' => 'Form List Divisi',
                'btn_tmbh' =>"Tambah List Divisi",
                'btn'=>[
                    'edit'=>'Sunting',
                ],
                'desc'=>'',
                'form'=>[
                    'nama'=>'Nama Divisi'
                ],
            ],
            'laporan' =>[
                'label' => 'laporan',
                'label_plural' => 'laporan',
                'desc'=>'',
                'form'=>[
                    'nama'=>'Nama Divisi',
                    'no_wa'=>'Nomor WhatsApp',
                    'unit_kerja'=>'Unit Kerja',
                    'nama_ruangan'=>'Nama Ruang Rapat',
                    'tanggal_awal'=>'Tanggal dan Waktu Peminjaman Awal',
                    'tanggal_akhir'=>'Tanggal dan Waktu Peminjaman Akhir',
                    'jumlah_peserta'=>'Jumlah Peserta Rapat',
                    'agenda_rapat'=>'Agenda Rapat',
                    'upload_undangan'=>'Upload Dokumen Memo',
                    'jenis_rapat'=>'Jenis Rapat',
                    'nama_peserta'=>'Nama Peserta Rapat',
                    'nama_mitra' => 'Nama Peserta Mitra',
                    'created_at'=> 'Created At'
                ],
                'btn'=>[
                    'btn_export' => 'Export'
                ]
            ],
            'group' => 'Peminjaman Ruangan'
        ],
    ]
];
