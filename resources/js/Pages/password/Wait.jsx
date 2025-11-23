import { usePage } from "@inertiajs/react";

const Wait = () => {
    const {flash} = usePage().props
    return (
        <p
            className={'text-white font-semibold flex justify-center items-center'}
        >
            {flash.message}
        </p>
    )

}

export default Wait;
