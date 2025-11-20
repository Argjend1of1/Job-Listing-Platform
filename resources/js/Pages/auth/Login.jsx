import {Link, useForm} from "@inertiajs/react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Button from "@/Pages/components/forms/Button.jsx";
import Input from "@/Pages/components/forms/Input.jsx";
import {useEffect, useRef} from "react";

const Login = () => {
    const {
        data,
        setData,
        post,
        errors,
        processing
    } = useForm({
        email: '',
        password: ''
    });
    const inputRef = useRef();

    useEffect(() => {
        inputRef.current?.focus();
    }, []);

    const handleLogin = (e) => {
        e.preventDefault();
        post('/login')
    }

    return (
        <>
            <PageHeading title={"Log In"}/>
            <form
                className={"max-w-2xl mx-auto space-y-6"}
                onSubmit={handleLogin}
            >
                <div>
                    <Input
                        ref={inputRef}
                        type={'text'}
                        name={'email'}
                        label={"Email"}
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                    />
                    {errors.email && (
                        <p className={"text-red-500 text-sm mt-1"}>
                            {errors.email}
                        </p>
                    )}
                </div>

                <div>
                    <Input
                        type={'password'}
                        name={'password'}
                        label={"Password"}
                        value={data.password}
                        onChange={(e) => setData('password', e.target.value)}
                    />
                    {errors.password && (
                        <p className={"text-red-500 text-sm mt-1"}>
                            {errors.password}
                        </p>
                    )}
                </div>

                <div className="mt-4 text-sm">
                    <Link href={"/forgot-password"} className="text-blue-500 hover:underline">
                        Forgot your password?
                    </Link>
                </div>

                <Button
                    type={"submit"}
                    disabled={processing}
                >
                    {processing ? 'Logging In...' : 'Log In'}
                </Button>
            </form>
        </>
    )
}

export default Login
