import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Form from "@/Pages/components/forms/Form.jsx";
import Input from "@/Pages/components/forms/Input.jsx";
import Button from "@/Pages/components/forms/Button.jsx";
import {router, useForm, usePage} from "@inertiajs/react";
import {useEffect, useRef} from "react";
import {showError, showSuccess} from "@/reusableFunctions/alertUser.js";
import Error from "@/Pages/components/body/Error.jsx";

const Edit = ({ token, email }) => {
    const {data, setData, processing, post, errors} = useForm({
        password: '',
        password_confirmation: '',
        token: token,
        email: email,
    })
    const inputRef = useRef(null)

    useEffect(() => {
        inputRef.current?.focus();
    }, []);

    console.log(errors)

    const handleReset = () => {
        // make sure to add the token and email from gmail to our site. We do this so we
        // can compare the hidden inputs with the token and email from gmail.
        post(`/reset-password`, {
            onSuccess: (page) => {
                const {flash} = page.props;
                showSuccess(flash.message, 2000)
                setTimeout(() => {
                    router.get('/login')
                }, 1500)
            },
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
                {errors.password && (
                    <Error error={errors.password} />
                )}
                {errors.error && (
                    <Error error={errors.error} />
                )}

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
