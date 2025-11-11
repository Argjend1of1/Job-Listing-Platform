import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Input from "@/Pages/components/forms/Input.jsx";
import {useForm} from "@inertiajs/react";
import Error from "@/Pages/components/body/Error.jsx";
import Label from "@/Pages/components/forms/Label.jsx";
import Button from "@/Pages/components/forms/Button.jsx";
import AlertUser from "../components/AlertUser.jsx";

const Store = () => {
    const {data, setData, processing, errors, post} = useForm({
        title: '',
        salary: '',
        location: '',
        schedule: 'Full Time',
        about: '',
        url: '',
        tags: ''
    });

    const handleCreate = async (e) => {
        e.preventDefault();
        post('/jobs/create');
    }

    return (
        <>
            <PageHeading title={"New Job Listing"} />

            <form
                onSubmit={handleCreate}
                className={"max-w-2xl mx-auto space-y-6"}
            >
                <Input
                    label="Title"
                    name={"title"}
                    placeholder={"CEO"}
                    value={data.title}
                    onChange={(e) => setData('title', e.target.value)}
                />
                {errors.title && (
                    <Error error={errors.title}/>
                )}

                <Input
                    label="Salary"
                    name={"salary"}
                    placeholder={"$50,000 USD"}
                    value={data.salary}
                    onChange={(e) => setData('salary', e.target.value)}
                />
                {errors.salary && (
                    <Error error={errors.salary}/>
                )}

                <Input
                    label="Location"
                    name={"location"}
                    placeholder={"Winter Park, Florida"}
                    value={data.location}
                    onChange={(e) => setData("location", e.target.value)}
                />
                {errors.location && (
                    <Error error={errors.location}/>
                )}

                <Label label={"Schedule"} name={"schedule"} />
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
                    <Error error={errors.schedule}/>
                )}

                <Input
                    label="About"
                    name={"about"}
                    placeholder={"Describe the job..."}
                    value={data.about}
                    onChange={(e) => setData('about', e.target.value)}
                />
                {errors.about && (
                    <Error error={errors.about}/>
                )}

                <Input
                    label="URL"
                    name={"url"}
                    placeholder={"https://example.com"}
                    value={data.url}
                    onChange={(e) => setData('url', e.target.value)}
                />
                {errors.url && (
                    <Error error={errors.url}/>
                )}

                <Input
                    label="Tags"
                    name={"tags"}
                    placeholder={"developer,fullstack, web"}
                    value={data.tags}
                    onChange={(e) => setData('tags', e.target.value)}
                />
                {errors.tags && (
                    <Error error={errors.tags}/>
                )}

                <Button
                    disabled={processing}
                    type={"submit"}
                >
                    {processing ? "Publishing..." : "Publish"}
                </Button>
            </form>
        </>
    )
}

export default Store;
