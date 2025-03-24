import { usePage } from "@inertiajs/vue3";

export function useRolePermission() {
    const page = usePage();

    const hasRole = (name) => {
        return page.props.auth?.user?.roles.includes(name);
    };

    const hasPermission = (name) => {
        return page.props.auth?.user?.permissions.includes(name);
    };

    return { hasRole, hasPermission };
}
