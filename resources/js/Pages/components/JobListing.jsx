import {useForm, usePage} from "@inertiajs/react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Form from "@/Pages/components/forms/Form.jsx";
import JobCard from "@/Pages/components/cards/JobCard.jsx";
import {useEffect, useRef} from "react";
import { showSuccess } from "@/reusableFunctions/alertUser.js";
import {queryLogic} from "@/reusableFunctions/queryLogic.js";
import QueryInput from "@/Pages/components/forms/QueryInput.jsx";
import InfiniteScrolling from "@/Pages/components/forms/InfiniteScrolling.jsx";


const JobListing = ({ endpoint, titleDefault }) => {
    const { jobs, query, flash } = usePage().props;
    const { data, setData } = useForm({ q: query });
    const cancelToken = useRef(null);

    // Flash messages
    useEffect(() => {
        if (flash.completed) showSuccess(flash.completed, 3000);
    }, [flash.completed]);

    // Searching
    useEffect(() => {
        const delayDebounce = queryLogic(
            endpoint, data, setData, cancelToken, 'jobs'
        )

        return () => clearTimeout(delayDebounce);
    }, [data.q]);

    return (
        <>
            <section>
                {!query && <PageHeading title={titleDefault} />}
                {query && <PageHeading title={`Search Results for '${query}'`} />}

                <Form>
                    <QueryInput
                        data={data}
                        setData={setData}
                        placeholder={"Search for job listings..."}
                    />
                </Form>

            </section>

            {jobs.data.length > 0 ? (
                <>
                    <InfiniteScrolling data={'jobs'}>
                        <div className="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 mt-6">
                            {jobs.data.map(job => (
                                <div key={job.id}>
                                    <JobCard job={job} />
                                </div>
                            ))}
                        </div>
                    </InfiniteScrolling>
                </>
            ) : (
                <p className="text-gray-500 font-bold mt-5">
                    {data.q ? `No jobs listed for '${data.q}'` : "No jobs currently listed."}
                </p>
            )}
        </>
    );
};

export default JobListing;
