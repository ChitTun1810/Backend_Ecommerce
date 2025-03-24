import "./bootstrap";
import "../css/app.css";
import "../css/base.css";
import "vant/lib/index.css";
import "primevue/resources/themes/lara-light-blue/theme.css";
import "primeicons/primeicons.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimeVue from "primevue/config";
import CKEditor from "@ckeditor/ckeditor5-vue";

// const appName = import.meta.env.VITE_APP_NAME || "Laravel";
const appName = "IKON MART";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(CKEditor)
            .component("AuthenticatedLayout", AuthenticatedLayout)
            .component("PrimaryButton", PrimaryButton)
            .component("TextInput", TextInput)
            .component("InputError", InputError)
            .component("InputLabel", InputLabel)
            .use(PrimeVue, {
                unstyled: false,
            })
            .mount(el);
    },
    progress: {
        // color: "#4B5563",
    },
});
