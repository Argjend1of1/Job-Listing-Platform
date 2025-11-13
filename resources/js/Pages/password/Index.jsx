import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Form from "@/Pages/components/forms/Form.jsx";
import Input from "@/Pages/components/forms/Input.jsx";
import {useEffect, useRef} from "react";
import {useForm} from "@inertiajs/react";
import Button from "@/Pages/components/forms/Button.jsx";
import Error from "@/Pages/components/body/Error.jsx";

const Index = () => {
    const inputRef = useRef(null);
    const {data, setData, processing, errors, post} = useForm({
        email: ''
    })

    useEffect(() => {
        inputRef.current?.focus();
    }, []);

    const sendResetEmail = () => {
        post('/forgot-password')
    }

    return (
        <>
            <PageHeading title={'Reset Your Password'} />

            <Form>
                <Input
                    ref={inputRef}
                    type={'email'}
                    label={'Email'}
                    name={'email'}
                    placeholder={'Enter your email...'}
                    value={data.email}
                    onChange={(e) => setData('email', e.target.value)}
                />
                {errors.email && (
                    <Error error={errors.email} />
                )}

                <Button
                    onClick={sendResetEmail}
                    disabled={processing}
                >
                    {processing ? 'Sending...' : 'Send Reset Link'}
                </Button>
            </Form>
        </>
    )
}

export default Index;
