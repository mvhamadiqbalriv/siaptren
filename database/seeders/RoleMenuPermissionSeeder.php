<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class RoleMenuPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create role
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'bendahara']);
        Role::create(['name' => 'pimpinan_pesantren']);

        // forget cache menu
        Cache::forget('navigation');

        // create menu and permission
        $menu = Menu::create(['nama_menu' => 'User', 'url' => 'master/user', 'icon' => 'fe-user', 'jenis' => 'Master Data']);
        Permission::create(['name' => 'create master/user'])->assignRole('admin')->menus()->attach($menu);
        Permission::create(['name' => 'read master/user'])->assignRole('admin')->menus()->attach($menu);
        Permission::create(['name' => 'update master/user'])->assignRole('admin')->menus()->attach($menu);

        $civitas = Menu::create(['nama_menu' => 'Civitas Pesantren', 'url' => 'master/civitas', 'icon' => 'fe-users', 'jenis' => 'Master Data']);
        Permission::create(['name' => 'read master/civitas'])->assignRole(['admin', 'bendahara', 'pimpinan_pesantren'])->menus()->attach($civitas);

        $menu = $civitas->subMenus()->create(['nama_menu' => 'Asatidz', 'url' => 'master/civitas/asatidz', 'icon' => 'fe-circle', 'jenis' => 'Master Data']);
        Permission::create(['name' => 'create master/civitas/asatidz'])->assignRole('admin')->menus()->attach($menu);
        Permission::create(['name' => 'read master/civitas/asatidz'])->assignRole(['admin', 'bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'update master/civitas/asatidz'])->assignRole('admin', 'bendahara')->menus()->attach($menu);

        $menu = $civitas->subMenus()->create(['nama_menu' => 'Santri', 'url' => 'master/civitas/santri', 'icon' => 'fe-circle', 'jenis' => 'Master Data']);
        Permission::create(['name' => 'create master/civitas/santri'])->assignRole('admin')->menus()->attach($menu);
        Permission::create(['name' => 'read master/civitas/santri'])->assignRole(['admin', 'bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'update master/civitas/santri'])->assignRole('admin')->menus()->attach($menu);

        $menu = $civitas->subMenus()->create(['nama_menu' => 'Alumni', 'url' => 'master/civitas/alumni', 'icon' => 'fe-circle', 'jenis' => 'Master Data']);
        Permission::create(['name' => 'read master/civitas/alumni'])->assignRole(['admin', 'bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'update master/civitas/alumni'])->assignRole('admin')->menus()->attach($menu);

        $menu = Menu::create(['nama_menu' => 'Mata Pelajaran', 'url' => 'master/mata-pelajaran', 'icon' => 'fe-book-open', 'jenis' => 'Master Data']);
        Permission::create(['name' => 'create master/mata-pelajaran'])->assignRole('admin')->menus()->attach($menu);
        Permission::create(['name' => 'read master/mata-pelajaran'])->assignRole(['admin', 'bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'update master/mata-pelajaran'])->assignRole('admin')->menus()->attach($menu);

        $menu = Menu::create(['nama_menu' => 'Jadwal', 'url' => 'absensi/jadwal', 'icon' => 'fe-menu', 'jenis' => 'Absensi']);
        Permission::create(['name' => 'create absensi/jadwal'])->assignRole('admin')->menus()->attach($menu);
        Permission::create(['name' => 'read absensi/jadwal'])->assignRole(['admin', 'bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'update absensi/jadwal'])->assignRole('admin')->menus()->attach($menu);

        $absensi = Menu::create(['nama_menu' => 'Absensi', 'url' => 'absensi/data', 'icon' => 'fe-user-check', 'jenis' => 'Absensi']);
        Permission::create(['name' => 'read absensi/data'])->assignRole(['admin', 'bendahara', 'pimpinan_pesantren'])->menus()->attach($absensi);

        $menu = $absensi->subMenus()->create(['nama_menu' => 'Santri', 'url' => 'absensi/data/santri', 'icon' => 'fe-circle', 'jenis' => 'Absensi']);
        Permission::create(['name' => 'create absensi/data/santri'])->assignRole('admin')->menus()->attach($menu);
        Permission::create(['name' => 'read absensi/data/santri'])->assignRole(['admin', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'update absensi/data/santri'])->assignRole('admin')->menus()->attach($menu);

        $menu = $absensi->subMenus()->create(['nama_menu' => 'Asatidz', 'url' => 'absensi/data/asatidz', 'icon' => 'fe-circle', 'jenis' => 'Absensi']);
        Permission::create(['name' => 'create absensi/data/asatidz'])->assignRole('admin')->menus()->attach($menu);
        Permission::create(['name' => 'read absensi/data/asatidz'])->assignRole(['admin', 'bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'update absensi/data/asatidz'])->assignRole('admin')->menus()->attach($menu);

        $pemasukan = Menu::create(['nama_menu' => 'Pemasukan', 'url' => 'keuangan/pemasukan', 'icon' => 'fe-credit-card', 'jenis' => 'Keuangan']);
        Permission::create(['name' => 'read keuangan/pemasukan'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($pemasukan);

        $menu = $pemasukan->subMenus()->create(['nama_menu' => 'Pembayaran SPP', 'url' => 'keuangan/pemasukan/pembayaran-spp', 'icon' => 'fe-circle', 'jenis' => 'Keuangan']);
        Permission::create(['name' => 'create keuangan/pemasukan/pembayaran-spp'])->assignRole('bendahara')->menus()->attach($menu);
        Permission::create(['name' => 'read keuangan/pemasukan/pembayaran-spp'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'update keuangan/pemasukan/pembayaran-spp'])->assignRole('bendahara')->menus()->attach($menu);

        $menu = $pemasukan->subMenus()->create(['nama_menu' => 'Eksternal', 'url' => 'keuangan/pemasukan/eksternal', 'icon' => 'fe-circle', 'jenis' => 'Keuangan']);
        Permission::create(['name' => 'create keuangan/pemasukan/eksternal'])->assignRole('bendahara')->menus()->attach($menu);
        Permission::create(['name' => 'read keuangan/pemasukan/eksternal'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'update keuangan/pemasukan/eksternal'])->assignRole('bendahara')->menus()->attach($menu);

        $pengeluaran = Menu::create(['nama_menu' => 'Pengeluaran', 'url' => 'keuangan/pengeluaran', 'icon' => 'fe-shopping-cart', 'jenis' => 'Keuangan']);
        Permission::create(['name' => 'read keuangan/pengeluaran'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($pengeluaran);

        $menu = $pengeluaran->subMenus()->create(['nama_menu' => 'Pembayaran Gaji', 'url' => 'keuangan/pengeluaran/pembayaran-gaji', 'icon' => 'fe-circle', 'jenis' => 'Keuangan']);
        Permission::create(['name' => 'create keuangan/pengeluaran/pembayaran-gaji'])->assignRole('bendahara')->menus()->attach($menu);
        Permission::create(['name' => 'read keuangan/pengeluaran/pembayaran-gaji'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'update keuangan/pengeluaran/pembayaran-gaji'])->assignRole('bendahara')->menus()->attach($menu);

        $menu = $pengeluaran->subMenus()->create(['nama_menu' => 'Lainnya', 'url' => 'keuangan/pengeluaran/lainnya', 'icon' => 'fe-circle', 'jenis' => 'Keuangan']);
        Permission::create(['name' => 'create keuangan/pengeluaran/lainnya'])->assignRole('bendahara')->menus()->attach($menu);
        Permission::create(['name' => 'read keuangan/pengeluaran/lainnya'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'update keuangan/pengeluaran/lainnya'])->assignRole('bendahara')->menus()->attach($menu);

        $absensi = Menu::create(['nama_menu' => 'Absensi', 'url' => 'laporan/absensi', 'icon' => 'fe-file-text', 'jenis' => 'Laporan']);
        Permission::create(['name' => 'read laporan/absensi'])->assignRole(['admin', 'bendahara', 'pimpinan_pesantren'])->menus()->attach($absensi);

        $menu = $absensi->subMenus()->create(['nama_menu' => 'Asatidz', 'url' => 'laporan/absensi/asatidz', 'icon' => 'fe-circle', 'jenis' => 'Laporan']);
        Permission::create(['name' => 'read laporan/absensi/asatidz'])->assignRole(['admin', 'bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'export laporan/absensi/asatidz'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);

        $menu = $absensi->subMenus()->create(['nama_menu' => 'Santri', 'url' => 'laporan/absensi/santri', 'icon' => 'fe-circle', 'jenis' => 'Laporan']);
        Permission::create(['name' => 'read laporan/absensi/santri'])->assignRole(['admin', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'export laporan/absensi/santri'])->assignRole(['admin', 'pimpinan_pesantren'])->menus()->attach($menu);

        $keuangan = Menu::create(['nama_menu' => 'Keuangan', 'url' => 'laporan/keuangan', 'icon' => 'fe-credit-card', 'jenis' => 'Laporan']);
        Permission::create(['name' => 'read laporan/keuangan'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($keuangan);

        $menu = $keuangan->subMenus()->create(['nama_menu' => 'Pembayaran SPP', 'url' => 'laporan/keuangan/pembayaran-spp', 'icon' => 'fe-circle', 'jenis' => 'Laporan']);
        Permission::create(['name' => 'read laporan/keuangan/pembayaran-spp'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'export laporan/keuangan/pembayaran-spp'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);

        $menu = $keuangan->subMenus()->create(['nama_menu' => 'Pemasukan Eksternal', 'url' => 'laporan/keuangan/pemasukan-eksternal', 'icon' => 'fe-circle', 'jenis' => 'Laporan']);
        Permission::create(['name' => 'read laporan/keuangan/pemasukan-eksternal'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'export laporan/keuangan/pemasukan-eksternal'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);

        $menu = $keuangan->subMenus()->create(['nama_menu' => 'Gaji Asatidz', 'url' => 'laporan/keuangan/gaji-asatidz', 'icon' => 'fe-circle', 'jenis' => 'Laporan']);
        Permission::create(['name' => 'read laporan/keuangan/gaji-asatidz'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'export laporan/keuangan/gaji-asatidz'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);

        $menu = $keuangan->subMenus()->create(['nama_menu' => 'Pengeluaran Lain', 'url' => 'laporan/keuangan/pengeluaran-lain', 'icon' => 'fe-circle', 'jenis' => 'Laporan']);
        Permission::create(['name' => 'read laporan/keuangan/pengeluaran-lain'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
        Permission::create(['name' => 'export laporan/keuangan/pengeluaran-lain'])->assignRole(['bendahara', 'pimpinan_pesantren'])->menus()->attach($menu);
    }
}
