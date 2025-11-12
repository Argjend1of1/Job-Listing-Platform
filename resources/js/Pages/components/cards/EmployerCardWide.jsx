import Panel from "@/Pages/components/Panel.jsx";
import {useForm} from "@inertiajs/react";
import {useState} from "react";
import {confirmAction} from "@/reusableFunctions/confirmAction.js";
import {showError, showSuccess} from "@/reusableFunctions/alertUser.js";

const EmployerCardWide = ({ employer }) => {
    const {user} = employer;
    const {delete:destroy, patch} = useForm()
    const [isRemoving, setIsRemoving] = useState(false);
    const [isDemoting, setIsDemoting] = useState(false);
    const [isPromoting, setIsPromoting] = useState(false);

    const handleDemotion = async () => {
        const confirm = await confirmAction(
            "Do you really want to demote this premium employer?",
            'Yes, demote him!'
        );
        if (!confirm) return;

        patchRequest()
    }

    const handlePromotion = async () => {
        const confirm = await confirmAction(
            "Do you really want to promote this employer?",
            'Yes, promote him!'
        );
        if (!confirm) return;
        setIsPromoting(true)

        patchRequest()
    }

    const handleRemoval = async () => {
        const confirm = await confirmAction(
            "Do you really want to remove this employer?",
            'Yes, remove him!'
        );
        if (!confirm) return;
        setIsRemoving(true);

        destroy(`/employers/${employer.id}`, {
            onSuccess: (page) => {
                const {flash} = page.props
                showSuccess(flash.message)
            },
            onError: (page) => {
                const {flash} = page.props
                showError(flash.error)
            },
            onFinish: () => setIsRemoving(false)
        });
    }

    const patchRequest = () => {
        setIsDemoting(true);
        setIsPromoting(true);
        patch(`/employers/${employer.id}`, {
            onSuccess: (page) => {
                const {flash} = page.props
                showSuccess(flash.message)
            },
            onError: (page) => {
                const {flash} = page.props
                showError(flash.error)
            },
            onFinish: () => {
                setIsDemoting(false);
                setIsPromoting(false);
            }
        })
    }

    return (
        <Panel className="gap-x-5 md:gap-x-3 items-center mt-10">
            <div>
                <img src={user.logo}
                     alt={employer.name}
                     className={'rounded-full'}
                     width="40"
                     height="40"
                />
            </div>

            <div className="flex-1 flex flex-col">
                <div className="mb-3">
                    <p className="font-bold text-sm mb-[-5px]">Name:</p>
                    <a className="self-start text-sm text-gray-400">{employer.user.name}</a>
                </div>

                <div className="mb-2">
                    <p className="font-bold text-sm mb-[-5px]">Company Name:</p>
                    <a className="text-sm text-gray-400">{employer.name}</a>
                </div>
                <div className="flex justify-end">
                    {user.role === 'employer' ? (
                        <>
                            <button onClick={handlePromotion}
                                    disabled={isPromoting || isRemoving }
                                    className={`border-2 border-green-800 transition rounded-full text-[10px] py-1 px-4 font-bold ml-3
                                        ${isRemoving || isPromoting
                                            ? 'bg-gray-400 border-gray-400 text-gray-200 cursor-not-allowed opacity-60'
                                            : 'hover:bg-green-800 cursor-pointer'
                                    }`}
                            >
                                {isPromoting ? 'Promoting... ' : 'Promote'}
                            </button>

                            <button
                                onClick={handleRemoval}
                                disabled={isRemoving || isPromoting}
                                className={`border-2 border-red-800 transition rounded-full text-[10px] py-1 px-4 font-bold ml-3
                                    ${isRemoving || isPromoting
                                        ? 'bg-gray-400 border-gray-400 text-gray-200 cursor-not-allowed opacity-60'
                                        : 'hover:bg-red-800 cursor-pointer'
                                }`}
                            >
                                {isRemoving ? 'Removing...' : 'Remove Employer'}
                            </button>
                        </>
                    ) : (
                        <button onClick={handleDemotion}
                                disabled={isDemoting}
                                className={`border-2 border-red-800 transition rounded-full text-[10px] py-1 px-4 font-bold ml-3
                                    ${isDemoting
                                        ? 'bg-gray-400 border-gray-400 text-gray-200 cursor-not-allowed opacity-60'
                                        : 'hover:bg-red-800 cursor-pointer'
                                }`}
                        >
                            {isDemoting ? 'Demoting...' : 'Demote'}
                        </button>
                    )}
                </div>
            </div>
        </Panel>
    )
}

export default EmployerCardWide;
