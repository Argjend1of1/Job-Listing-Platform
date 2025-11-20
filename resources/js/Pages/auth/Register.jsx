import { useForm } from "@inertiajs/react";
import Button from "../components/forms/Button.jsx";
import Input from "../components/forms/Input.jsx";
import Error from "../components/body/Error.jsx";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Label from "@/Pages/components/forms/Label.jsx";
import Select from "@/Pages/components/forms/Select.jsx";
import {useEffect, useRef, useState} from "react";

const Register = () => {
    const {data, setData, post, processing, errors} = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        logo: '',
        category: '',
        is_company: false,
        employer: ''
    });

    const [isCompany, setIsCompany] = useState(false);
    const inputRef = useRef();

    useEffect(() => {
        inputRef.current?.focus();
    }, []);

    /**
     * Send a post request for registering the user
     */
    const handleRegister = (e) => {
        e.preventDefault();
        post('/register', {
            forceFormData: true,
            preserveState:true,
            preserveScroll:true,
            onError: () => {
                setData('password_confirmation', '');
                setData('password', '');
            }
        });
    }

    /**
     *  Need the state in the backend also, hence using it on both cases.
     */
    const checkIsCompany = (e) => {
        setData('is_company', e.target.checked)
        setIsCompany(e.target.checked)
    }

    return (
        <>
            <PageHeading title={"Register"} />
            <form
                onSubmit={handleRegister}
                className={"max-w-2xl mx-auto space-y-6"}
                encType="multipart/form-data"
            >
                <Input
                    ref={inputRef}
                    name={"name"}
                    label={"Name"}
                    value={data.name}
                    onChange={(e) => setData('name', e.target.value)}
                />
                {errors.name && (
                    <Error error={errors.name}/>
                )}

                <Input
                    name={"email"}
                    label={"Email"}
                    value={data.email}
                    onChange={(e) => setData('email', e.target.value)}

                />
                {errors.email && (
                    <Error error={errors.email}/>
                )}

                <Input
                    type={"password"}
                    name={"password"}
                    label={"Password"}
                    value={data.password}
                    onChange={(e) => setData('password', e.target.value)}
                />
                {errors.password && (
                    <Error error={errors.password}/>
                )}

                <Input
                    type={"password"}
                    name={"password_confirmation"}
                    label={"Confirm Password"}
                    value={data.password_confirmation}
                    onChange={(e) => setData('password_confirmation', e.target.value)}
                />
                {errors.password_confirmation && (
                    <Error error={errors.password_confirmation}/>
                )}

                <Input
                    type={"file"}
                    name={"logo"}
                    label={"Profile Image"}
                    onChange={(e) => setData('logo', e.target.files[0])}
                    //for all the type="file" it creates an array, so we want the first element
                />
                {errors.logo && (
                    <Error error={errors.logo}/>
                )}

                <div>
                    <Label label={"Category"} name={"category"} />
                    <Select
                        id={"category"}
                        name={"category"}
                        value={data.category}
                        onChange={(e) => setData('category', e.target.value)}
                    />
                    {errors.category && (
                        <Error error={errors.category}/>
                    )}
                </div>

                <div className={"inline-flex items-center space-x-2 text-sm font-medium text-gray-700"}>
                    <Input
                        type={"checkbox"}
                        name={"is_company"}
                        value={data.is_company}
                        onChange={checkIsCompany}
                    />
                    <span>I'm registering as a company</span>
                </div>

                {isCompany && (
                    <>
                        <Input
                            label={"Company Name"}
                            name={"employer"}
                            value={data.employer}
                            onChange={(e) => setData('employer', e.target.value)}
                        />
                        {errors.employer && (
                            <Error error={errors.employer}/>
                        )}
                    </>
                )}

                <Button
                    type={"submit"}
                    disabled={processing}
                >
                    {processing ? 'Creating...' : 'Create Account'}
                </Button>
            </form>
        </>
    )
}

export default Register
