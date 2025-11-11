import {Link} from "@inertiajs/react";

function Pagination({ links }) {
    if (!links.length) return null;

    return (
        <div className="flex justify-end gap-2 mt-8">
            {links.map((link, i) => (
                <Link
                    key={i}
                    href={link.url || '#'}
                    dangerouslySetInnerHTML={{ __html: link.label }}
                    className={`px-3 py-1 rounded text-black
                    ${link.active ? 'bg-blue-600' : 'bg-gray-600'}
                    ${!link.url ? 'opacity-50 cursor-not-allowed' : ''}`}
                />
            ))}
        </div>
    );
}

export default Pagination
