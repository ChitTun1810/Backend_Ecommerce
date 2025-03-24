<template>
    <div class="sticky top-0 z-40 bg-slate-50">
        <div
            class="w-full h-16 px-6 flex items-center justify-between"
        >
            <!-- left navbar -->
            <div class="flex">
                <!-- mobile hamburger -->
                <div class="inline-block lg:hidden items-center mr-4">
                    <button
                        class="hover:text-blue-500 hover:border-white focus:outline-none navbar-burger"
                        @click="toggleSidebar()"
                    >
                        <svg
                            class="h-5 w-5"
                            v-bind:style="{ fill: 'black' }"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <title>Menu</title>
                            <path
                                d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"
                            />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- right navbar -->
            <div class="flex items-center relative">
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <span class="inline-flex rounded-md">
                            <button
                                type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                            >
                                {{ $page.props.auth.user.name }}

                                <svg
                                    class="ms-2 -me-0.5 h-4 w-4"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <DropdownLink :href="route('profile.edit')">
                            Profile
                        </DropdownLink>
                        <DropdownLink
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            Log Out
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
        </div>

        <!-- dropdown menu -->
        <!-- dropdown menu end -->
    </div>
</template>

<script setup>
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

import { ref } from "vue";

const dropDownOpen = ref(false);
</script>

<style lang="scss" scoped></style>
