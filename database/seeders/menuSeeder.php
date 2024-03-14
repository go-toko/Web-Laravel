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
            'name' => 'Subscribe',
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
            'name' => 'Product',
            'url' => '#',
            'icon' => 'fas fa-box-open',
            'status' => 1,
        ]);

        $owsales = MenuModel::create([
            'name' => 'Sales',
            'url' => '#',
            'icon' => 'fas fa-shopping-cart',
            'status' => 1,
        ]);

        $owpurchases = MenuModel::create([
            'name' => 'Purchases',
            'url' => '#',
            'icon' => 'fas fa-shopping-basket',
            'status' => 1,
        ]);

        $owreport = MenuModel::create([
            'name' => 'Reports',
            'url' => '#',
            'icon' => 'fas fa-file-alt',
            'status' => 1,
        ]);

        $owsettings = MenuModel::create([
            'name' => 'Settings',
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
            'url' => 'superadmin/settings/menu',
            'status' => 1,
        ]);

        //submenu subscribe
        SubMenuModel::create([
            'menu_id' => $suSubscribe->id,
            'name' => 'Menu Management',
            'url' => 'superadmin/subscription/menu',
            'status' => 1,
        ]);
        SubMenuModel::create([
            'menu_id' => $suSubscribe->id,
            'name' => 'Subscription Management',
            'url' => 'superadmin/subscription/management',
            'status' => 1,
        ]);

        //SubMenu Owner
        //submenu product
        SubMenuModel::create([
            'menu_id' => $owproducts->id,
            'name' => 'Products',
            'url' => 'owner/products/list',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owproducts->id,
            'name' => 'Create Product',
            'url' => 'owner/products/create',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owproducts->id,
            'name' => 'Category',
            'url' => 'owner/products/category',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owproducts->id,
            'name' => 'Brand',
            'url' => 'owner/products/brand',
            'status' => 1
        ]);

        //submenu sales
        SubMenuModel::create([
            'menu_id' => $owsales->id,
            'name' => 'Sales',
            'url' => 'owner/sales/sales',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owsales->id,
            'name' => 'POS',
            'url' => 'owner/sales/pos',
            'status' => 1
        ]);

        //submenu purchases
        SubMenuModel::create([
            'menu_id' => $owpurchases->id,
            'name' => 'Purchases',
            'url' => 'owner/purchases/purchases',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owpurchases->id,
            'name' => 'Order',
            'url' => 'owner/purchases/order',
            'status' => 1
        ]);

        //submenu report
        SubMenuModel::create([
            'menu_id' => $owreport->id,
            'name' => 'Sales Report',
            'url' => 'owner/report/sales',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owreport->id,
            'name' => 'Inventory Report',
            'url' => 'owner/report/inventory',
            'status' => 1
        ]);

        //submenu Settings
        SubMenuModel::create([
            'menu_id' => $owsettings->id,
            'name' => 'My Profile',
            'url' => 'owner/settings/profile',
            'status' => 1
        ]);
        SubMenuModel::create([
            'menu_id' => $owsettings->id,
            'name' => 'My Store',
            'url' => 'owner/settings/store',
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
            'menu_id' => $owsales->id,
            'subscribe' => 0,
        ]);
        RoleMenuModel::create([
            'role_id' => 2,
            'menu_id' => $owpurchases->id,
            'subscribe' => 0,
        ]);
        RoleMenuModel::create([
            'role_id' => 2,
            'menu_id' => $owreport->id,
            'subscribe' => 1,
        ]);
        RoleMenuModel::create([
            'role_id' => 2,
            'menu_id' => $owsettings->id,
            'subscribe' => 0,
        ]);
    }
}