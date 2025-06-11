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
        'formperangkat' => [
            'title' => 'Form Pengajuan Perangkat',
        ],
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
        'laporan_ruangan' => [
            'title' => 'Laporan Ruang Rapat',
        ],
        'peminjamanruangan' => [
            'title' => 'Peminjaman Ruangan',
        ],
        'ruangrapat' => [
            'title' => 'Ruang Rapat',
        ],
        'beranda'=>[
            'title' => 'Beranda'
        ]
    ],
    'text' => [
        'textlink' => 'Aplikasi SDM',
        'company_name' => 'Telok University',
        'company_alias' => 'Ppl',
        'url_forgot_password' => 'Lupa Sandi?',
        'url_user_manual' => 'User Manual',
        'btn_login' => 'Masuk',
        'welcome' => 'Hai, Selamat Datang',
        'greeting_login' => 'Silahkan login menggunakan data akun anda',
        'username' => 'Username',
        'password' => 'kata sandi',

        'agreement_title1' => 'Telok University',
        'agreement_title2' => 'DIVISI TEKNOLOGI INFORMASI',
        'agreement_title3' => 'DISCLAIMER',
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
        'flagstatus_all' => [
            '1' => 'Menunggu Persetujuan',
            '2' => 'Ditolak',
            '3' => 'Disetujui',
            '4' => 'Selesai Dipinjam',
            '5' => 'Menunggu Persetujuan Kadiv',
            '6' => 'Menunggu Persetujuan Atasan',
            '7' => 'Selesai',
            '8' => 'Sudah Disetujui',
            '9' => 'Menunggu Persetujuan HR',
            '10' => 'Permohonan Revisi Ditolak',
            '11' => 'Menunggu Persetujuan',
        ],
        'flaqstatus' => [
            '1' => 'Dipesan',
            '2' => 'selesai',
            '3' => 'Sedang Dipakai',
            '4' => 'Selesai dengan catatan',
            '5' => 'Batal',
            '6' => 'Batal'
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
                'btn_kehadiran'=>[
                    'form_kehadiran' => 'Form Daftar Hadir'
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
        'absensi' =>[
            'label' => 'Form Absensi',
            'label_plural' => 'Absensi',
            'desc'=>'',
            'group' => 'Absensi',
        ],
        'biodata-diri' =>[
            'label' => 'Form Biodata Diri',
            'label_plural' => 'Biodata Diri',
            'desc'=>'',
            'group' => 'Biodata Diri',
        ],
        'form-pengajuan' =>[
            'label' => 'Form Pengajuan',
            'label_plural' => 'Form Pengajuan',
            'desc'=>'',
            'form-izin' =>[
                'label' => 'Form Pengajuan Izin',
                'label_plural' => 'Form Pengajuan Izin',
            ],
            'form-cuti' =>[
                'label' => 'Form Pengajuan Cuti',
                'label_plural' => 'Form Pengajuan Cuti',
            ],
            'form-sakit' =>[
                'label' => 'Form Pengajuan Sakit',
                'label_plural' => 'Form Pengajuan Sakit',
            ],
            'form-perangkat' =>[
                'label' => 'Form Pengajuan Perangkat',
                'label_plural' => 'Form Pengajuan Perangkat',
                'form' =>[
                    'btn_setuju' => 'Setujui',
                ],
            ],
            'group' => 'Pengajuan',
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
                'alert_delete' => 'ApakahAnda Yakin Akan Menghapus Data yang Terpilih?',
                'desc'=>'',
            ],
            'list-perangkat' =>[
                'label' => 'List Perangkat',
                'label_plural' => 'List Perangkat',
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
                'label' => 'Laporan Peminjaman Ruang Rapat',
                'label_plural' => 'Laporan Peminjaman Ruang Rapat',
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
            'group' => 'Master Data'
        ],
        'report'=> [
            'laporan_absensi' =>[
                'label' => 'Laporan Absensi',
                'desc' =>''
            ],
            'laporan_biodata_diri' =>[
                'label' => 'Laporan Biodata Diri',
                'desc' =>''
            ],
            'laporan_izin' =>[
                'label' => 'Laporan Pengajuan Izin',
                'desc' =>''
            ],
            'laporan_cuti' =>[
                'label' => 'Laporan Pengajuan Cuti',
                'desc' =>''
            ],
            'laporan_sakit' =>[
                'label' => 'Laporan Pengajuan Sakit',
                'desc' =>''
            ],
            'laporan_perangkat' =>[
                'label' => 'Laporan Pengajuan Perangkat',
                'desc' =>''
            ],
            'group' => 'Laporan'
        ]
    ]
];
