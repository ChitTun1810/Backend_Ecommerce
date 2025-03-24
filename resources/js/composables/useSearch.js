import { router } from "@inertiajs/vue3";
import _ from "lodash";

export function useSearch(uri_name) {
    const onListingFilter = _.debounce((options) => {
        router.get(route(`admin.${uri_name}.index`), options, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            only: [uri_name],
        });
    }, 250);

    return { onListingFilter };
}
