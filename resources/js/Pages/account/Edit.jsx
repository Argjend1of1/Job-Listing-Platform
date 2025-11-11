import {router, useForm} from "@inertiajs/react";
import Input from "@/Pages/components/forms/Input.jsx";
import {useEffect, useRef, useState} from "react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Button from "@/Pages/components/forms/Button.jsx";
import {confirmAction} from "@/reusableFunctions/confirmAction.js";
import {showError, showSuccess} from "@/reusableFunctions/alertUser.js";
import Error from "@/Pages/components/body/Error.jsx";

const Edit = ({ user }) => {
    const {employer, role} = user;

    const {data, setData, errors, processing, patch, delete:destroy} = useForm({
        name: user.name,
        employer: employer ? employer.name : '',
    });

    const inputRef = useRef(null);
    const [isDeleting, setIsDeleting] = useState(false);

    useEffect(() => {
        inputRef.current?.focus()
    }, [])

    const handleEditAccount = async (e) => {
        e.preventDefault();
        const confirmed = await confirmAction(
            "Are you sure you want to update your account ?",
            'Yes, I am sure!',
        )
        if(confirmed) {
            patch('/account/edit', {
                onSuccess: (page) => {
                    const {flash} = page.props;
                    showSuccess(flash.message, 2000);
                    router.get('/account');
                },
                onError: (page) => {
                    const {error} = page
                    showError(error);
                }
            });
        }
    }

    const handleDeleteAccount = async (e) => {
        e.preventDefault();

        const confirmed = await confirmAction(
            "Are you sure you want to remove your account ?",
            'Yes, I am sure!',
        )

        if(confirmed) {
            setIsDeleting(true);
            destroy('/account/edit', {
                onSuccess: (page) => {
                    const {flash} = page.props
                    showSuccess(flash.message, 2000)
                    setIsDeleting(false);
                },
                onError: (page) => {
                    const {flash} = page.props
                    showError(flash.error, 2000)
                    setIsDeleting(false)
                }
            })
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
                {errors.name && (
                    <Error error={errors.name} />
                )}

                {(role === 'employer' || role === 'superemployer') && (
                    <Input
                        name={"employer"}
                        label={"Company Name"}
                        value={data.employer}
                        onChange={(e) => setData('employer', e.target.value)}
                    />
                )}
                {errors.employer && (
                    <Error error={errors.employer} />
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
                    disabled={isDeleting}
                    className={'border-2 border-red-800 transition rounded-full py-2 px-6 font-bold ml-3 hover:bg-red-800 cursor-pointer focus:bg-red-900'}
                >
                    {isDeleting ? 'Deleting...' : 'Delete'}
                </Button>

            </form>
        </>
    )
}

export default Edit;
