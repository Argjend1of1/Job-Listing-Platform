import {usePage} from "@inertiajs/react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";

const Index = () => {
    const {auth} = usePage().props;
    const {user} = auth;
    return (
        <>
            <PageHeading title={'Your Account Info'} />
            <div className={'max-w-2xl mx-auto space-y-6'}>
                <h2 className="text-2xl font-bold text-white mb-6">Account Information</h2>
                <div>
                    <p className="text-sm text-white font-semibold">Name:</p>
                    <p className="text-gray-400 text-base">{user.name}</p>
                </div>

                <div>
                    <p className="text-sm text-white font-semibold">Email:</p>
                    <p className="text-gray-400 text-base">{user.email}</p>
                </div>
                <div className="pt-6">
                    <a href="/account/edit"
                       className="inline-block px-6 py-2 border-2 border-gray-700 text-white hover:bg-gray-700 transition rounded-full focus:bg-gray-800">
                        Edit Account
                    </a>
                </div>
            </div>
        </>
    )
}

export default Index;
