import {usePage} from "@inertiajs/react";

const Wait = () => {
    const {flash} = usePage().props
    return <p className={'text-white'}>{flash.message}</p>
}

export default Wait;
