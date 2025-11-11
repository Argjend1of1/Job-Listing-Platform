import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import {useForm, usePage} from "@inertiajs/react";
import Form from "@/Pages/components/forms/Form.jsx";
import Input from "@/Pages/components/forms/Input.jsx";
import Button from "@/Pages/components/forms/Button.jsx";
import Error from "@/Pages/components/body/Error.jsx";
import Label from "@/Pages/components/forms/Label.jsx";

const Edit = () => {
    const { job } = usePage().props;

    const {
        processing, data, setData, patch, delete:destroy, errors
    } = useForm({
        title:      job.title,
        schedule:   job.schedule,
        about:      job.about,
        salary:     job.salary,
    })


    const handleEdit = () => {
        patch(`/dashboard/edit/${job.id}`)
    }

    const handleDelete = () => {
        destroy(`/dashboard/edit/${job.id}`);
    }

    return (
        <>
            <PageHeading title="Edit Job Listing" />

            <div className="max-w-2xl mx-auto space-y-6">
                <Form>
                    <Input
                        label="Title"
                        name="title"
                        value={data.title}
                        onChange={(e) => setData('title', e.target.value)}
                    />
                    {errors.title && (
                        <Error error={errors.title} />
                    )}

                    <Label name='schedule' label='Schedule'/>
                    <select
                        name={"schedule"}
                        className={"rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full"}
                        value={data.schedule}
                        onChange={(e) => setData('schedule', e.target.value)}
                    >
                        <option
                            value={"Full Time"}
                            className={"text-black"}
                        >
                            Full Time
                        </option>
                        <option
                            value={"Part Time"}
                            className={"text-black"}
                        >
                            Part Time
                        </option>
                    </select>
                    {errors.schedule && (
                        <Error error={errors.schedule} />
                    )}

                    <Input
                        label="About Job"
                        name="about"
                        value={data.about}
                        onChange={(e) => setData('about', e.target.value)}
                    />
                    {errors.about && (
                        <Error error={errors.about} />
                    )}

                    <Input
                        label="Salary"
                        name="salary"
                        value={data.salary}
                        onChange={(e) => setData('salary', e.target.value)}
                    />
                    {errors.salary && (
                        <Error error={errors.salary} />
                    )}

                    <div className="my-5 flex justify-between">
                        <Button
                            disabled={processing}
                            onClick={handleEdit}
                            className="inline-block px-6 py-2 border-2 border-gray-700 text-white hover:bg-gray-700 transition rounded-full cursor-pointer"
                        >
                            Update Job
                        </Button>

                        <Button
                            disabled={processing}
                            onClick={handleDelete}
                            className="border-2 border-red-800 transition rounded-full py-2 px-6 ml-3 hover:bg-red-800 cursor-pointer focus:bg-red-900"
                        >
                            Delete Job Listing
                        </Button>
                    </div>

                </Form>
            </div>

        </>
    )
}

export default Edit;
