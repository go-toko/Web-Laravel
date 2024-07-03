<?php

namespace Database\Seeders;

use App\Models\MenuModel;
use App\Models\RoleMenuModel;
use App\Models\SubMenuModel;
use Illuminate\Database\Seeder;

class menuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //Parent Menu
        //Superadmin Menu
        $sudashboard = MenuModel::create([
            'name' => 'Dashboard',
            'url' => 'superadmin/dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'status' => 1,
        ]);
        $supeople = MenuModel::create([
            'name' => 'People',
            'url' => '#',
            'icon' => 'fas fa-users',
            'status' => 1,
        ]);
        $susettings = MenuModel::create([
            'name' => 'Settings',
            'url' => '#',
            'icon' => 'fas fa-cogs',
            'status' => 1,
        ]);
        $suSubscribe = MenuModel::create([
            'name' => 'Subscription',
            'url' => '#',
            'icon' => 'fas fa-bell',
            'status' => 1,
        ]);

        //Owner Menu
        $owdashboard = MenuModel::create([
            'name' => 'Dashboard',
            'url' => 'owner/dashboard',
            'icon' => 'fas fa-tachometer-alt',
            'status' => 1,
        ]);
        $owproducts = MenuModel::create([
            'name' => 'Produk',
            'url' => '#',
            'icon' => 'fas fa-box-open',
            'status' => 1,
        ]);
        $owpengeluaran = MenuModel::create([
            'name' => 'Pengeluaran',
            'url' => '#',
            'icon' => 'fas fa-shopping-basket',
            'status' => 1
        ]);
        $owsales = MenuModel::create([
            'name' => 'Penjualan',
            'url' => '#',
            'icon' => 'fas fa-shopping-cart',
            'status' => 1,
        ]);
        $owlaporan = MenuModel::create([
            'name' => 'Laporan',
            'url' => '#',
            'icon' => 'fas fa-file-alt',
            'status' => 1,
        ]);
        $oworang = MenuModel::create([
            'name' => 'Orang',
            'url' => '#',
            'icon' => 'fas fa-user',
            'status' => 1,
        ]);
        $owsettings = MenuModel::create([
            'name' => 'Pengaturan',
            'url' => '#',
            'icon' => 'fas fa-cogs',
            'status' => 1,
        ]);
        //SubMenu Table
        //SubMenu Super Admin

        //submenu people
        SubMenuModel::create([
            'menu_id' => $supeople->id,
            'name' => 'User Management',
            'url' => 'superadmin/people/user',
            'status' => 1,
        ]);

        SubMenuModel::create([
            'menu_id' => $supeople->id,
            'name' => 'Shop Management',
            'url' => 'superadmin/people/shop',
            'status' => 1,
        ]);

        //submenu settings
        SubMenuModel::create([
            'menu_id' => $susettings->id,
            'name' => 'Menu Management',
            'url' => 'superadmin/settings/menu-management',
            'status' => 1,
        ]);

        //submenu subscribe
        SubMenuModel::create([
            'menu_id' => $suSubscribe->id,
            'name' => 'Menu Management',
            'url' => 'superadmin/subscription/menu-management',
            'status' => 1,
        ]);
        SubMenuModel::create([
            'menu_id' => $suSubscribe->id,
            'name' => 'Subscription Management',
            'url' => 'superadmin/subscription/subscription-management',
            'status' => 1,
        ]);
        SubMenuModel::create([
            'menu_id' => $suSubscribe->id,
            'name' => 'Subscription Order',
            'url' => 'superadmin/subscription/subscription-order',
            'status' => 1,
        ]);

        //SubMenu Owner
        //submenu product
        SubMenuModel::create([
            'menu_id' => $owproducts->id,
            'name' => 'Daftar Produk',
            'url' => 'owner/produk/daftar-produk',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owproducts->id,
            'name' => 'Kategori',
            'url' => 'owner/produk/kategori',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owproducts->id,
            'name' => 'Merek',
            'url' => 'owner/produk/merek',
            'status' => 1
        ]);

        // Submenu Pengeluaran
        SubMenuModel::create([
            'menu_id' => $owpengeluaran->id,
            'name' => 'Pengeluaran',
            'url' => 'owner/pengeluaran/pengeluaran',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owpengeluaran->id,
            'name' => 'Kategori',
            'url' => 'owner/pengeluaran/kategori',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owpengeluaran->id,
            'name' => 'Statistik',
            'url' => 'owner/pengeluaran/statistik',
            'status' => 1
        ]);

        //submenu sales
        SubMenuModel::create([
            'menu_id' => $owsales->id,
            'name' => 'Penjualan',
            'url' => 'owner/penjualan/penjualan',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owsales->id,
            'name' => 'Aplikasi Kasir',
            'url' => 'owner/penjualan/aplikasi-kasir',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owsales->id,
            'name' => 'Statistik Penjualan',
            'url' => 'owner/penjualan/statistik-penjualan',
            'status' => 1
        ]);

        //submenu purchases
        // SubMenuModel::create([
        //     'menu_id' => $owpurchases->id,
        //     'name' => 'Purchases',
        //     'url' => 'owner/purchases/purchases',
        //     'status' => 1
        // ]);
        // SubMenuModel::create([
        //     'menu_id' => $owpurchases->id,
        //     'name' => 'Order',
        //     'url' => 'owner/purchases/order',
        //     'status' => 1
        // ]);

        //submenu report
        SubMenuModel::create([
            'menu_id' => $owlaporan->id,
            'name' => 'Produk',
            'url' => 'owner/laporan/produk',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owlaporan->id,
            'name' => 'Pengeluaran',
            'url' => 'owner/laporan/pengeluaran',
            'status' => 1
        ]);

        // Submenu Orang
        SubMenuModel::create([
            'menu_id' => $oworang->id,
            'name' => 'Pemasok',
            'url' => 'owner/orang/pemasok',
            'status' => 1,
        ]);
        SubMenuModel::create([
            'menu_id' => $oworang->id,
            'name' => 'Kasir',
            'url' => 'owner/orang/kasir',
            'status' => 1,
        ]);

        //submenu Settings
        SubMenuModel::create([
            'menu_id' => $owsettings->id,
            'name' => 'Daftar Toko',
            'url' => 'owner/pengaturan/daftar-toko',
            'status' => 1
        ]);


        //RoleMenu Table
        //Superadmin
        RoleMenuModel::create([
            'role_id' => 1,
            'menu_id' => $sudashboard->id,
            'subscribe' => 0,
        ]);

        RoleMenuModel::create([
            'role_id' => 1,
            'menu_id' => $supeople->id,
            'subscribe' => 0,
        ]);

        RoleMenuModel::create([
            'role_id' => 1,
            'menu_id' => $susettings->id,
            'subscribe' => 0,
        ]);

        RoleMenuModel::create([
            'role_id' => 1,
            'menu_id' => $suSubscribe->id,
            'subscribe' => 0,
        ]);

        //Owner

        RoleMenuModel::create([
            'role_id' => 2,
            'menu_id' => $owdashboard->id,
            'subscribe' => 0,
        ]);
        RoleMenuModel::create([
            'role_id' => 2,
            'menu_id' => $owproducts->id,
            'subscribe' => 0,
        ]);
        RoleMenuModel::create([
            'role_id' => 2,
            'menu_id' => $owpengeluaran->id,
            'subscribe' => 0,
        ]);
        RoleMenuModel::create([
            'role_id' => 2,
            'menu_id' => $owsales->id,
            'subscribe' => 0,
        ]);
        RoleMenuModel::create([
            'role_id' => 2,
            'menu_id' => $owlaporan->id,
            'subscribe' => 0,
        ]);
        RoleMenuModel::create([
            'role_id' => 2,
            'menu_id' => $oworang->id,
            'subscribe' => 0,
        ]);
        RoleMenuModel::create([
            'role_id' => 2,
            'menu_id' => $owsettings->id,
            'subscribe' => 0,
        ]);
    }
}