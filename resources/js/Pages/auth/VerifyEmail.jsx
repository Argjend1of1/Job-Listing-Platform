import Form from "@/Pages/components/forms/Form.jsx";
import {router, useForm} from "@inertiajs/react";
import { showSuccess } from "@/reusableFunctions/alertUser.js";
import {useEffect} from "react";

const VerifyEmail = () => {
    const { post } = useForm();

    const resendEmail = () => {
        post("/email/verification-notification", {
            onSuccess: (page) => {
                const { flash } = page.props;
                showSuccess(flash.message);
            }
        });
    };

    /**
     * When the user checks for his email, if he does not return for a minute to this route,
     * redirect back to the homepage
     */
    useEffect(() => {
        const refreshPage = setTimeout(() => {
            router.get('/', {}, {
                replace: true
            })
        }, 30000)

        return () => clearTimeout(refreshPage);
    }, []);

    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-900 px-4">
            <div className="w-full max-w-lg bg-white shadow-lg rounded-2xl p-10">

                <h1 className="text-3xl font-extrabold text-gray-900 mb-4 text-center">
                    Verify Your Email
                </h1>

                <p className="text-gray-600 text-center leading-relaxed mb-8">
                    Before continuing, please verify your email address by clicking the link
                    we sent to your inbox.
                    <br />
                    If you didn’t receive an email, you can request a new one.
                </p>

                <Form className="mt-6">
                    <button
                        onClick={resendEmail}
                        type="button"
                        className="w-full bg-blue-600 cursor-pointer hover:bg-blue-700 text-white
                                   font-semibold py-3 rounded-xl shadow-md
                                   transition-transform transform hover:scale-[1.02]"
                    >
                        Resend Verification Email
                    </button>
                </Form>
            </div>
        </div>
    );
};

export default VerifyEmail;
