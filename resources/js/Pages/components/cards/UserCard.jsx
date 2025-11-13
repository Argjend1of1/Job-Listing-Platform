import Panel from "@/Pages/components/Panel.jsx";
import {useForm} from "@inertiajs/react";
import {showError, showSuccess} from "@/reusableFunctions/alertUser.js";
import {confirmAction} from "@/reusableFunctions/confirmAction.js";

const UserCard = ({user}) => {
    const {patch, processing} = useForm();
    const handlePromotion = async () => {
        const confirm = await confirmAction(
            'Do you really want to promote this user ?',
            'Yes, I am sure.'
        )
        if(!confirm) return;

        patch(`/admins/create/${user.id}`, {
            onError: (page) => {
                const {flash} = page.props;
                showError(flash.error)
            },
            onSuccess: (page) => {
                const {flash} = page.props;
                showSuccess(flash.message)
            },
        })
    }
    return (
        <Panel className={'gap-x-5 md:gap-x-3 items-center'}>
            <div>
                <img src={user.logo}
                     alt={user.name}
                     className="rounded-full flex items-center justify-center"
                     width="60"
                     height="60"
                />
            </div>

            <div className="flex-1 flex flex-col">
                <div className="mb-3">
                    <p className="font-bold text-sm mb-[-5px]">Name:</p>
                    <a className="self-start text-sm text-gray-400">{user.name}</a>
                </div>

                <div className="mb-2">
                    <p className="font-bold text-sm mb-[-5px]">Email:</p>
                    <a className="text-sm text-gray-400">{user.email}</a>
                </div>
                <div className="flex justify-end">
                    <button
                        onClick={handlePromotion}
                        className="border-2 border-green-800 transition rounded-full text-[10px] py-1 px-4 font-bold ml-3 hover:bg-green-800 cursor-pointer"
                        disabled={processing}
                    >
                        {processing ? 'Promoting...' : 'Promote'}
                    </button>
                </div>
            </div>
        </Panel>
    )
}

export default UserCard;
