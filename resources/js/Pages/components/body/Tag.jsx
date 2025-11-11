import {Link} from "@inertiajs/react";

const Tag = ({tag, className = ''}) => {
    return (
        <Link
            href={`/tags/${tag.name.toLowerCase()}`}
            className={`bg-white/15 rounded-xl font-bold transition-colors duration-200 hover:bg-white/25 ${className}`}
        >
            {tag.name}
        </Link>
    )
}

export default Tag
