import Input from "@/Pages/components/forms/Input.jsx";
import { useForm } from "@inertiajs/react";
import Button from "@/Pages/components/forms/Button.jsx";
import {showError} from "@/reusableFunctions/alertUser.js";

const Index = () => {
    const {setData, post, processing, errors} = useForm({
        resume: ''
    })

    const handleUpload = (e) => {
        e.preventDefault()

        post('/resume', {
            forceFormData: true, // ensures Inertia sends multipart/form-data
            onError: (page) => {
                const{flash} = page.props

                if(flash.error)
                    showError(flash.error, 3000)
            }
        })
    }

    return (
        <>
            <form className="max-w-2xl mx-auto space-y-6"
                  onSubmit={handleUpload}
                  encType="multipart/form-data"
            >
                <Input
                    type="file"
                    name="resume"
                    label="Attach Resume"
                    onChange={(e) => setData('resume', e.target.files[0])}
                />
                {errors.resume && (
                    <p className={"text-red-500 text-sm"}>
                        {errors.resume}
                    </p>
                )}

                <Button
                    disabled={processing}
                    type="submit"
                    className="ml-auto inline-block font-semibold px-6 py-2 border-2 border-white-700 text-white hover:bg-white hover:text-black transition rounded-full cursor-pointer focus:bg-gray-100 focus:text-black"
                >
                    {processing ? "Uploading..." : "Upload Resume"}
                </Button>
            </form>
        </>
    )
}

export default Index;
