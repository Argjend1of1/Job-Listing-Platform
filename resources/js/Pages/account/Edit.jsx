import {useForm, usePage} from "@inertiajs/react";
import Input from "@/Pages/components/forms/Input.jsx";
import {useEffect, useRef} from "react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Button from "@/Pages/components/forms/Button.jsx";
import {confirmAction} from "@/reusableFunctions/confirmAction.js";

const Edit = ({employer}) => {
    const {auth} = usePage().props;
    const {role} = auth.user;
    const {data, setData, errors, processing, patch, delete:destroy} = useForm({
        name: auth.user.name,
        company: employer ? employer.name : ''
    });

    const inputRef = useRef(null);

    useEffect(() => {
        inputRef.current?.focus()
    }, [])

    const handleEditAccount = async (e) => {
        e.preventDefault();
        const confirmed = await confirmAction({
            text: "Are you sure you want to update your account ?",
            confirmButtonText: 'Yes, I am sure!'
        })
        if(confirmed) {
            patch('/account/edit');
        }
    }

    const handleDeleteAccount = async (e) => {
        e.preventDefault();

        const confirmed = await ConfirmAction({
            text: "Are you sure you want to remove your account ?",
            confirmButtonText: 'Yes, I am sure!'
        })

        if(confirmed) {
            destroy('/account/edit')
        }
    }

    return (
        <>
            <PageHeading title={"Edit Your Account"}/>
            <form
                onSubmit={handleEditAccount}
                className={"max-w-2xl mx-auto space-y-6"}
            >
                <Input
                    ref={inputRef}
                    name={"name"}
                    label={"Your Name"}
                    value={data.name}
                    onChange={(e) => setData('name', e.target.value)}
                />
                {(role === 'employer' || role === 'superemployer') && (
                    <Input
                        name={"employer"}
                        label={"Company Name"}
                        value={data.company}
                        onChange={(e) => setData('company', e.target.value)}
                    />
                )}

                <Button
                    type={'submit'}
                    disabled={processing}
                    className={'inline-block px-6 py-2 border-2 border-gray-700 text-white hover:bg-gray-700 transition rounded-full focus:bg-gray-800 cursor-pointer'}
                >
                    {processing ? 'Updating...' : 'Update'}
                </Button>

                <Button
                    type={'button'}
                    onClick={handleDeleteAccount}
                    disabled={processing}
                    className={'border-2 border-red-800 transition rounded-full py-2 px-6 font-bold ml-3 hover:bg-red-800 cursor-pointer focus:bg-red-900'}
                >
                    {processing ? 'Deleting...' : 'Delete'}
                </Button>

            </form>
        </>
    )
}

export default Edit;
