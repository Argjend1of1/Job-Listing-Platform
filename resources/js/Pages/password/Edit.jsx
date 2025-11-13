import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Form from "@/Pages/components/forms/Form.jsx";
import Input from "@/Pages/components/forms/Input.jsx";
import Button from "@/Pages/components/forms/Button.jsx";
import {router, useForm} from "@inertiajs/react";
import {useEffect, useRef} from "react";
import {showError, showSuccess} from "@/reusableFunctions/alertUser.js";

const Edit = ({ token, email }) => {
    const {data, setData, processing, patch} = useForm({
        password: '',
        password_confirmation: '',
        token: token,
        email: email,
    })
    const inputRef = useRef(null)

    useEffect(() => {
        inputRef.current?.focus();
    }, []);
    const handleReset = () => {
        // make sure to add the token and email from gmail to our site. We do this so we
        // can compare the hidden inputs with the token and email from gmail.
        patch(`/reset-password`, {
            onSuccess: (page) => {
                const {flash} = page.props;
                showSuccess(flash.message)
                router.get('/login')
            },
            onError: (page) => {
                const {flash} = page.props;
                showError(flash.error);
            }
        })
    }
    return (
        <>
            <PageHeading title={'Reset your password'} />

            <Form>
                <input type="hidden" name="token" value={data.token} />
                <input type="hidden" name="email" value={data.email} />

                <Input
                    type={'password'}
                    name={'password'}
                    placeholder={'Set your new password...'}
                    ref={inputRef}
                    value={data.password}
                    onChange={(e) => setData('password', e.target.value)}
                />

                <Input
                    type={'password'}
                    name={'password_confirmation'}
                    placeholder={'Confirm password...'}
                    value={data.password_confirmation}
                    onChange={(e) => setData('password_confirmation', e.target.value)}
                />

                <Button
                    onClick={handleReset}
                    disabled={processing}
                >
                    {processing ? 'Resetting...' : 'Reset Password'}
                </Button>
            </Form>
        </>
    )
}

export default Edit;
