<template>
    <aside class="h-screen md:w-64 md:flex md:flex-col sticky top-0">
        <ScrollPanel class="pb-0 px-2 h-[99%] bg-slate-50">
            <a
                href="#"
                class="py-3 sticky top-0 border-b bg-slate-50 flex items-center ps-2.5"
            >
                <img
                    src="https://ikonmart.itplus.site/assets/img/logo/logo.svg"
                    class="w-20 me-2"
                />
                <span
                    class="self-center text-2xl font-semibold whitespace-nowrap"
                    >IKON</span
                >
            </a>
            <ul class="space-y-2 font-medium">
                <li>
                    <Link
                        :href="route('dashboard')"
                        class="nav-item"
                        :class="{
                            'bg-blue-600 text-white':
                                route().current('dashboard'),
                        }"
                    >
                        <i class="pi pi-chart-pie"></i>
                        <span class="ms-3">Dashboard</span>
                    </Link>
                </li>
                <template v-for="(menu, index) in menus" :key="index">
                    <li v-if="menu.permission">
                        <Link
                            :href="menu.link"
                            :preserve-scroll="false"
                            :preserve-state="false"
                            class="nav-item"
                            :class="{
                                'bg-blue-600 text-white': menu.active,
                            }"
                        >
                            <i :class="menu.icon"></i>
                            <span class="ms-3">
                                {{ menu.name }}
                            </span>
                        </Link>
                    </li>
                </template>
            </ul>
        </ScrollPanel>
    </aside>
</template>

<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { useRolePermission } from "@/composables/useRolePermission";
import ScrollPanel from "primevue/scrollpanel";

const { hasRole, hasPermission } = useRolePermission();
const page = usePage();
// console.log(page.components);

const menus = ref([
    {
        name: "Banners",
        permission: hasPermission("banner_access"),
        icon: "pi pi-images",
        link: route("admin.banners.index"),
        active: page.component.startsWith("Admin/Banner"),
    },
    {
        name: "Categories",
        permission: hasPermission("category_access"),
        icon: "pi pi-tags",
        link: route("admin.categories.index"),
        active: page.component.startsWith("Admin/Category"),
    },
    {
        name: "Brands",
        permission: hasPermission("brand_access"),
        icon: "pi pi-tag",
        link: route("admin.brands.index"),
        active: page.component.startsWith("Admin/Brand"),
    },
    {
        name: "Product Types",
        permission: hasPermission("product_access"),
        icon: "pi pi-list",
        link: route("admin.product-types.index"),
        active: page.url.startsWith("/product-types"),
    },
    {
        name: "Products",
        permission: hasPermission("product_access"),
        icon: "pi pi-inbox",
        link: route("admin.products.index"),
        active: page.url.startsWith("/products"),
    },
    {
        name: "Product Inquiry",
        permission: hasPermission("product_access"),
        icon: "pi pi-info-circle",
        link: route("admin.product-inquiries.index"),
        active: page.url.startsWith("/product-inquiries"),
    },
    {
        name: "Countries",
        permission: hasPermission("country_access"),
        icon: "pi pi-globe",
        link: route("admin.countries.index"),
        active: page.component.startsWith("Admin/Country"),
    },
    {
        name: "Cities",
        permission: hasPermission("city_access"),
        icon: "pi pi-map",
        link: route("admin.cities.index"),
        active: page.component.startsWith("Admin/City"),
    },
    {
        name: "Townships",
        permission: hasPermission("township_access"),
        icon: "pi pi-map-marker",
        link: route("admin.townships.index"),
        active: page.component.startsWith("Admin/Township"),
    },
    {
        name: "Roles",
        permission: hasPermission("role_access"),
        icon: "pi pi-shield",
        link: route("admin.roles.index"),
        active: page.component.startsWith("Admin/Role"),
    },
    {
        name: "Users",
        permission: hasPermission("user_access"),
        icon: "pi pi-users",
        link: route("admin.users.index"),
        active: page.component.startsWith("Admin/User"),
    },
    {
        name: "Customers",
        permission: hasPermission("customer_access"),
        icon: "pi pi-users",
        link: route("admin.customers.index"),
        active: page.component.startsWith("Admin/Customer"),
    },
    {
        name: "Orders",
        permission: hasPermission("order_access"),
        icon: "pi pi-truck",
        link: route("admin.orders.index"),
        active: page.component.startsWith("Admin/Order"),
    },
    {
        name: "Contact Us",
        permission: true,
        icon: "pi pi-bell",
        link: route("admin.contact.index"),
        active: page.component.startsWith("Admin/Contact"),
    },
    {
        name: "Settings",
        permission: hasPermission("setting_access"),
        icon: "pi pi-cog",
        link: route("admin.settings.index"),
        active: page.component.startsWith("Admin/Setting"),
    },
]);
</script>

<style lang="scss" scoped></style>
