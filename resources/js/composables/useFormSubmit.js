import { router } from "@inertiajs/vue3";

export function useFormSubmit(form, uri_name, hasFile = false) {
    const onFormSubmit = (options, edit) => {
        if (!edit) {
            form.post(route(`admin.${uri_name}.store`), options);
        } else {
            editFormRequest(edit, options);
        }
    };

    function editFormRequest(edit, options) {
        let uri = route(`admin.${uri_name}.update`, edit.id);
        if (hasFile) {
            router.post(
                uri,
                {
                    _method: "put",
                    ...form,
                },
                options
            );
        } else {
            form.put(uri, options);
        }
    }

    return { onFormSubmit };
}
