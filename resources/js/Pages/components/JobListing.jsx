import { router, useForm, usePage, InfiniteScroll } from "@inertiajs/react";
import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import Form from "@/Pages/components/forms/Form.jsx";
import Input from "@/Pages/components/forms/Input.jsx";
import JobCard from "@/Pages/components/cards/JobCard.jsx";
import {useEffect, useRef} from "react";
import { showSuccess } from "@/reusableFunctions/alertUser.js";
import {RotatingLines} from "react-loader-spinner";


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
        if (data.q === query) return;
        if (cancelToken.current) cancelToken.current.cancel();

        const delayDebounce = setTimeout(() => {
            router.get(endpoint, { q: data.q }, {
                preserveState: true,
                replace: true,
                reset: ['jobs', 'query'], // reset ensures we start from page 1 when infinite scrolling
                onCancelToken: (token) => cancelToken.current = token,
            });
        }, 500);

        return () => clearTimeout(delayDebounce);
    }, [data.q]);

    return (
        <>
            <section>
                {!query && <PageHeading title={titleDefault} />}
                {query && <PageHeading title={`Search Results for '${query}'`} />}
                <Form>
                    <Input
                        name="q"
                        label={false}
                        placeholder="Search for job listings..."
                        onChange={e => setData('q', e.target.value)}
                    />
                </Form>
            </section>

            {jobs.data.length > 0 ? (
                <>
                    <InfiniteScroll data='jobs'
                                    loading={() => <div className='flex justify-end my-3'>
                                        <RotatingLines
                                            visible={true}
                                            height="40"
                                            width="40"
                                            color="grey"
                                            strokeWidth="5"
                                            animationDuration="0.75"
                                            ariaLabel="rotating-lines-loading"
                                            wrapperStyle={{}}
                                            wrapperClass=""
                                        />
                                    </div>
                        } //used as a fallback when content is loading
                    >
                        <div className="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 mt-6">
                            {jobs.data.map(job => (
                                <div key={job.id}>
                                    <JobCard job={job} />
                                </div>
                            ))}
                        </div>
                    </InfiniteScroll>
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
