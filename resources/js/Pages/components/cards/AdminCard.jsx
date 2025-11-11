import Panel from "@/Pages/components/Panel.jsx";
import {router, useForm} from "@inertiajs/react";
import {confirmAction} from "@/reusableFunctions/confirmAction.js";
import {showError, showSuccess} from "@/reusableFunctions/alertUser.js";

const AdminCard = ({ admin }) => {
    const {patch} = useForm();
    const handleDemotion = async () => {
        const confirmed = await confirmAction(
            'Are you sure you want to demote this user ?',
            'Yes I am sure'
        );

        if (!confirmed) return;
        patch(`/admins/${admin.id}`, {
            onSuccess: (page) => {
                const {flash} = page.props;
                showSuccess(flash.message);
                router.reload();
            },
            onError: (page) => {
                const {flash} = page.props;
                showError(flash.error);
            }
        })
    }

    return (
        <Panel className={'gap-x-5 md:gap-x-3 items-center'}>
            <div>
                <img src={admin.logo}
                     alt={admin.name}
                     className={'rounded-full'}
                     width="40"
                     height="40"
                />
            </div>

            <div className="flex-1 flex flex-col">
                <div className="">
                    <p className="font-bold text-sm mb-[-5px]">Name:</p>
                    <a className="self-start text-sm text-gray-400">{admin.name}</a>
                </div>

                <div className="mb-5 mt-2">
                    <p className="font-bold text-sm mb-[-5px]">Email:</p>
                    <a className="text-sm text-gray-400">{admin.email}</a>
                </div>
                <div className="flex justify-end">
                    <button onClick={handleDemotion}
                            className="border-2 border-red-800 transition rounded-full text-[10px] py-1 px-4 font-bold ml-3 hover:bg-red-800 cursor-pointer"
                    >
                        Demote
                    </button>
                </div>
            </div>
        </Panel>
    )
}

export default AdminCard;
