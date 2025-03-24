<script setup>
import Navbar from "@/Components/Navbar.vue";
import Sidebar from "@/Components/Sidebar.vue";
import { Toast } from "vant";
import { useNotification } from "@/composables/useNotification";

const { getNotificationPermission } = useNotification();

getNotificationPermission();
</script>

<template>
    <div class="flex">
        <Sidebar />
        <Toast />
        <div class="w-screen">
            <Navbar />
            <main class="container mx-auto">
                <div class="p-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
