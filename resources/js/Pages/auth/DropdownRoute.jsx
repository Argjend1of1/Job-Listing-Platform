import {Link} from "@inertiajs/react";

const DropdownRoute = ({href, children}) => {
    return (
        <Link
            href={href}
            className="block border-b border-b-gray-800 px-4 py-2 text-white hover:bg-gray-800 focus:bg-gray-900"
        >
            {children}
        </Link>
    )
}

export default DropdownRoute;
